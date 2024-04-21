<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\{
    StoreCustomerRequest,
    UpdateCustomerRequest
};

use App\Services\Interfaces\CustomerServiceInterface as CustomerService;
use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;


class CustomerController extends Controller
{
    protected $customerService;
    protected $customerRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        CustomerService $customerService,
        CustomerRepository $customerRepository,
    ) {
        parent::__construct();        
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'customer_catalogues',
            'foreignkey' => 'customer_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', 'customer.index');

        $customers = $this->customerService->paginate();
        // dd($customers);
        $config['seo'] = __('messages.customer')['index'];

        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();

        return view('servers.customers.index', compact([
            'customers',
            'config',
            'dropdown',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'customer.create');

        $config['seo'] = __('messages.customer')['create'];
        $config['method'] = 'create';
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($dropdown);
        return view('servers.customers.store', compact([
            'config',
            'dropdown',
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
        $customer = $this->customerRepository->getCustomerLanguageById($id, $this->currentLanguage);
        // dd($customer);


        $albums =  json_decode($customer->album);
        // Danh mục cha
        $dropdown = $this->nestedset->Dropdown();
        // dd($customer);


        $config['seo'] = __('messages.customer')['update'];
        $config['method'] = 'update';

        return view('servers.customers.store', compact([
            'config',
            'customer',
            'albums',
            'dropdown',
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
        return redirect()->route('customer.edit', $id)->with('toast_error', $errorMessage);
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
            return redirect()->route('customer.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('customer.index')->with('toast_error', $errorMessage);
    }
}
