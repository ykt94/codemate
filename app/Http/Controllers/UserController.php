<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function balance(int $id)
    {
        return User::query()->with('latestBalance')->findOrFail($id);
    }

}
