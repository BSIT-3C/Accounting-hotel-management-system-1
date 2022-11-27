<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected function store(Request $request) {

        $formFields = $request->validate([
            'work_start'=>['required' , 'string'],
            'work_end'=>['required', 'string'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
         ]);

         if ($request->hasFile('photo')) {
            $formFields['photo'] = $request->file('photo')->store('profile', 'public');
         }

         $formFields['password'] = bcrypt($formFields['password']);

         $user = Employee::create($formFields);

         auth()->login($user);

         return redirect('/home');

    }
}
