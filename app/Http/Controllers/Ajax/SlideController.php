<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SlideServiceInterface as SlideService;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    protected $slideService;
    public function __construct(
        SlideService $slideService,
    ) {
        parent::__construct();
        $this->slideService = $slideService;
    }


    public function drag(Request $request)
    {
        $successMessage = $this->getToastMessage('slide', 'success', 'drag');
        $errorMessage = $this->getToastMessage('slide', 'error', 'drag');

        $payload = $request->except(['_token']);
        $response = $this->slideService->dragUpdate($payload);
        if ($response !== false) {
            return response()->json([
                'type' => 'success',
                'message' => $successMessage,
            ]);
        }

        return response()->json([
            'type' => 'error',
            'message' => $errorMessage,
        ]);
    }
}
