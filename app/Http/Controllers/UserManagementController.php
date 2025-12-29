<?php

namespace App\Http\Controllers;

use App\Services\UserManagementService;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    protected UserManagementService $userManagementService;

    public function __construct(UserManagementService $userManagementService)
    {
        $this->userManagementService = $userManagementService;
    }

    public function index(Request $request)
    {
        $filters = [
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ];

        $dataUser = [
            'userList' => $this->userManagementService->getAllUser(10, $filters)
        ];
        return view('modules.user-management.index', compact('dataUser'));
    }
}
