<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\{
    StoreCustomerRequest,
    UpdateCustomerRequest,
};

use App\Services\Interfaces\CustomerServiceInterface as CustomerService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface as CustomerCatalogueRepository;



class CustomerController extends Controller
{
    protected $customerService;
    protected $provinceRepository;
    protected $customerRepository;
    protected $customerCatalogueRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        CustomerService $customerService,
        ProvinceRepository $provinceRepository,
        CustomerRepository $customerRepository,
        CustomerCatalogueRepository $customerCatalogueRepository,
    ) {
        $this->customerService = $customerService;
        $this->provinceRepository = $provinceRepository;
        $this->customerRepository = $customerRepository;
        $this->customerCatalogueRepository = $customerCatalogueRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'customer.index');

        $customers = $this->customerService->paginate();
        $customerCatalogues = $this->customerCatalogueRepository->all();
        $config['seo'] = __('messages.customer')['index'];
        // dd('index');

        return view('servers.customers.index', compact([
            'customers',
            'config',
            'customerCatalogues'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'customer.create');

        $provinces = $this->provinceRepository->all();
        $customerCatalogues = $this->customerCatalogueRepository->all();

        $config['seo'] = __('messages.customer')['create'];
        $config['method'] = 'create';
        return view('servers.customers.store', compact([
            'config',
            'provinces',
            'customerCatalogues'
        ]));
    }

    public function store(StoreCustomerRequest $request)
    {
        $successMessage = $this->getToastMessage('customer', 'success', 'create');
        $errorMessage = $this->getToastMessage('customer', 'error', 'create');

        if ($this->customerService->create()) {
            return redirect()->route('customer.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('customer.create')->with('toast_error', $errorMessage);
    }


    public function edit($id)
    {
        $this->authorize('modules', 'customer.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $provinces = $this->provinceRepository->all();
        $customerCatalogues = $this->customerCatalogueRepository->all();
        $customer = $this->customerRepository->findById($id);
        // dd($customer);


        $config['seo'] = __('messages.customer')['update'];
        $config['method'] = 'update';

        return view('servers.customers.store', compact([
            'config',
            'provinces',
            'customer',
            'customerCatalogues',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('customer', 'success', 'update');
        $errorMessage = $this->getToastMessage('customer', 'error', 'update');
        // Lấy giá trị sesson
        $idCustomer = session('_id');
        if (empty($idCustomer)) {
            return redirect()->route('customer.index')->with('toast_error', $errorMessage);
        }

        if ($this->customerService->update($idCustomer)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('customer.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('customer.create')->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'customer.destroy');

        $successMessage = $this->getToastMessage('customer', 'success', 'delete');
        $errorMessage = $this->getToastMessage('customer', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('customer.index')->with('toast_error', $errorMessage);
        }
        if ($this->customerService->destroy($request->_id)) {

            return redirect()->route('customer.index')->with('toast_success',  $successMessage);
        }
        return redirect()->route('customer.index')->with('toast_error', $errorMessage);
    }
}
