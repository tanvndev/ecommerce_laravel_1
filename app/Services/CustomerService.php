<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\CustomerServiceInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerService extends BaseService implements CustomerServiceInterface
{
    protected $customerRepository;

    public function __construct(
        CustomerRepository $customerRepository,
    ) {
        parent::__construct();
        $this->customerRepository = $customerRepository;
        $this->controllerName = 'CustomerController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'customer_catalogue_id' => request('customer_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'customers.id',
            'customers.publish',
            'customers.image',
            'customers.user_id',
            'customers.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'customer_language as tb2' => ['tb2.customer_id', '=', 'customers.id'],
            'customer_catalogue_customer as tb3' => ['tb3.customer_id', '=', 'customers.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $customers = $this->customerRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['customer_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($customers);
        return $customers;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $customer_catalogue_id = request('customer_catalogue_id');
        if ($customer_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.customer_catalogue_id IN (
                        SELECT id 
                        FROM customer_catalogues
                        INNER JOIN customer_catalogue_language as pcl ON pcl.customer_catalogue_id = customer_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM customer_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM customer_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$customer_catalogue_id, $customer_catalogue_id, session('currentLanguage')]
                ]
            ];
        }
        return $rawConditions;
    }

    public function create()
    {

        DB::beginTransaction();
        try {

            //   Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create customer
            $customer = $this->customerRepository->create($payload);
            if ($customer->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($customer->id);
                // Create pivot and sync
                $this->createPivotAndSync($customer, $payloadLanguage);

                // create router
                $this->createRouter($customer);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    public function update($id)
    {

        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của customer hiện tại để xoá;
            $customer = $this->customerRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update customer
            $updateCustomer = $this->customerRepository->update($id, $payload);

            if ($updateCustomer) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $customer->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($customer, $payloadLanguage);

                // update router
                $this->updateRouter($customer);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function catalogue()
        {
            if (!empty(request('catalogue'))) {
                return array_unique(array_merge(
                    request('catalogue'),
                    [request('customer_catalogue_id')],
                ));
            }
            return [request('customer_catalogue_id')];
        }


    private function formatPayloadLanguage($customerId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra customer_id 
        $payloadLanguage['customer_id'] = $customerId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($customer, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng customer_language
        $this->customerRepository->createPivot($customer, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng customer_catalogue_customer
        $customer->customer_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->customerRepository->delete($id);

            // Xoa router
            $this->deleteRouter($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    private function payload()
    {
        return ['customer_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
