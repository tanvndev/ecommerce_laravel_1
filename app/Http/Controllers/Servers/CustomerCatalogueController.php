<?php

namespace App\Http\Controllers\Servers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\{
    StoreCustomerCatalogueRequest,
    UpdateCustomerCatalogueRequest,
};
use App\Services\Interfaces\CustomerCatalogueServiceInterface as CustomerCatalogueService;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface as CustomerCatalogueRepository;


class CustomerCatalogueController extends Controller
{
    protected $customerCatalogueService;
    protected $customerCatalogueRepository;


    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        CustomerCatalogueService $customerCatalogueService,
        CustomerCatalogueRepository $customerCatalogueRepository,

    ) {
        $this->customerCatalogueService = $customerCatalogueService;
        $this->customerCatalogueRepository = $customerCatalogueRepository;
    }
    //
    function index()
    {
        $this->authorize('modules', 'customer.catalogue.index');

        $customerCatalogues = $this->customerCatalogueService->paginate();
        $config['seo'] = __('messages.customerCatalogue')['index'];

        return view('servers.customer_catalogues.index', compact([
            'customerCatalogues',
            'config'
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'customer.catalogue.create');

        $config['seo'] = __('messages.customerCatalogue')['create'];
        $config['method'] = 'create';
        return view('servers.customer_catalogues.store', compact([
            'config',
        ]));
    }

    public function store(StoreCustomerCatalogueRequest $request)
    {
        $successMessage = $this->getToastMessage('customerCatalogue', 'success', 'create');
        $errorMessage = $this->getToastMessage('customerCatalogue', 'error', 'create');
        // dd($request->all());
        if ($this->customerCatalogueService->create()) {
            return redirect()->route('customer.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('customer.catalogue.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'customer.catalogue.edit');

        // Gán id vào sesson
        session(['_id' => $id]);
        // Lấy ra các tỉnh thành
        $customerCatalogue = $this->customerCatalogueRepository->findById($id);
        // dd($customer);

        $config['seo'] = __('messages.customerCatalogue')['update'];
        $config['method'] = 'update';

        return view('servers.customer_catalogues.store', compact([
            'config',
            'customerCatalogue',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerCatalogueRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('customerCatalogue', 'success', 'update');
        $errorMessage = $this->getToastMessage('customerCatalogue', 'error', 'update');

        // Lấy giá trị sesson
        $idCustomer = session('_id');
        if (empty($idCustomer)) {
            return redirect()->route('customer.catalogue.index')->with('toast_error', $errorMessage);
        }

        if ($this->customerCatalogueService->update($idCustomer)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('customer.catalogue.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('customer.catalogue.create')->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'customer.catalogue.destroy');

        $successMessage = $this->getToastMessage('customerCatalogue', 'success', 'delete');
        $errorMessage = $this->getToastMessage('customerCatalogue', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('customer.catalogue.index')->with('toast_error', $errorMessage);
        }
        if ($this->customerCatalogueService->destroy($request->_id)) {

            return redirect()->route('customer.catalogue.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('customer.catalogue.index')->with('toast_error', $errorMessage);
    }
}
