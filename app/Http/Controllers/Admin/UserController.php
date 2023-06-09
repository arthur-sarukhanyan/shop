<?php

namespace App\Http\Controllers\Admin;

use App\Facades\UserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ListUserRequest;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @param ListUserRequest $request
     * @return View
     */
    public function list(ListUserRequest $request): View
    {
        $params = $request->all();
        $list = UserFacade::list($params);
        return view('admin.users.main', ['list' => $list]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }
}
