<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class UsersController extends Controller
{

    public function index() {
        $users = User::all();

        return view('configuracion.users', ['users' => $users]);
    }

    public function create(Request $request) {
        dd($request->all());
    }

}
