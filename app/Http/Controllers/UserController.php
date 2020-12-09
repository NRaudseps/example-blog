<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('user.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('user.edit', $user);
    }

}
