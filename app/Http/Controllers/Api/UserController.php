<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        
        $users = User::latest()->get();

        return $users;
    }

    public function store() {

        request() ->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',

        ]);

        $users = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
    }

    public function update(User $user) {

        request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:8'
        ]);


        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }

    public function view($user){

        $users = User::find($user);

        return response()->json($users);
    }

    public function delete(User $user) {

        $user->delete();
        
        return response()->noContent();
    }


    public function searchUser(){
        $searchQuery = request('query');

        $users = User::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('email', 'like', '%' . $searchQuery . '%')
                  ->orWhere('created_at', 'like', '%' . $searchQuery . '%');
        })
        ->get(['name', 'email', 'created_at']); // Only select necessary columns

        return response()->json($users);

    }

}
