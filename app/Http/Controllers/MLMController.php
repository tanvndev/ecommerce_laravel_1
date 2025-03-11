<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\MLMServiceInterface;
use Illuminate\Http\Request;

class MLMController extends Controller
{
    protected $mlmService;
    protected $userRepository;

    public function __construct(
        MLMServiceInterface $mlmService,
        UserRepositoryInterface $userRepository,
    ) {
        parent::__construct();
        $this->mlmService = $mlmService;
        $this->userRepository = $userRepository;
    }

    public function getDescendants($userId)
    {
        $descendants = $this->mlmService->getAllDescendants($userId);
        $user = $this->getUser($userId);

        return view('mlm.descendants', compact(
            'descendants',
            'user'
        ));
    }

    public function getUserIncome($userId)
    {
        $income = $this->mlmService->getUserIncome($userId);
        $user = $this->getUser($userId);

        return view('mlm.income', compact(
            'income',
            'user'
        ));
    }

    private function getUser($userId)
    {
        return $this->userRepository->findById($userId);
    }
}
