<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;


class SourceController extends Controller
{
    protected $sourceRepository;
    public function __construct(
        SourceRepository $sourceRepository,

    ) {
        $this->sourceRepository = $sourceRepository;
    }

    public function getAllSource()
    {
        $sources = $this->sourceRepository->all();
        return response()->json([
            'data' => $sources
        ]);
    }
}
