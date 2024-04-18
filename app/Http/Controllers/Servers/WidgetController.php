<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    StoreWidgetRequest,
    UpdateWidgetRequest
};

use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;


class WidgetController extends Controller
{
    protected $widgetService;
    protected $widgetRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        WidgetService $widgetService,
        WidgetRepository $widgetRepository,
    ) {
        parent::__construct();
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

        $this->widgetService = $widgetService;
        $this->widgetRepository = $widgetRepository;
    }


    function index()
    {
        $this->authorize('modules', 'widget.index');

        $widgets = $this->widgetService->paginate();
        // dd($widgets);
        $config['seo'] = __('messages.widget')['index'];

        return view('servers.widgets.index', compact([
            'widgets',
            'config',
        ]));
    }

    function create()
    {
        $this->authorize('modules', 'widget.create');

        $config['seo'] = __('messages.widget')['create'];
        $config['method'] = 'create';
        return view('servers.widgets.store', compact([
            'config',
        ]));
    }

    public function store(StoreWidgetRequest $request)
    {

        $successMessage = $this->getToastMessage('widget', 'success', 'create');
        $errorMessage = $this->getToastMessage('widget', 'error', 'create');

        if ($this->widgetService->create()) {
            return redirect()->route('widget.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('widget.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        $this->authorize('modules', 'widget.edit');

        // Gán id vào sesson
        session(['_id' => $id]);


        $config['seo'] = __('messages.widget')['update'];
        $config['method'] = 'update';

        return view('servers.widgets.store', compact([
            'config',
            'widget',
        ]));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWidgetRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('widget', 'success', 'update');
        $errorMessage = $this->getToastMessage('widget', 'error', 'update');
        // Lấy giá trị sesson
        $idWidget = session('_id');
        if (empty($idWidget)) {
            return redirect()->route('widget.index')->with('toast_error', $errorMessage);
        }

        if ($this->widgetService->update($idWidget)) {
            // Xoá giá trị sesson
            session()->forget('_id');
            return redirect()->route('widget.index')->with('toast_success', $successMessage);
        }
        // Xoá giá trị sesson
        session()->forget('_id');
        return redirect()->route('widget.edit', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'widget.destroy');

        $successMessage = $this->getToastMessage('widget', 'success', 'delete');
        $errorMessage = $this->getToastMessage('widget', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('widget.index')->with('toast_error', $errorMessage);
        }
        if ($this->widgetService->destroy($request->_id)) {
            return redirect()->route('widget.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('widget.index')->with('toast_error', $errorMessage);
    }
}
