<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Notifications\WelcomeEmailNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::where("role_id",2)->get();

        return view("user.list",compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $countries = Country::get();

        return view("user.create",compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        try {
            
            $password = Str::random(8);

            $user = User::create([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "password" => bcrypt( $password),
                "country_id" => $request->country_id,
                "state_id" => $request->state_id,
                "city_id" => $request->city_id,
                "photo" => $request->file('photo')->store('photos','public')
            ]);

            $user->notify(new WelcomeEmailNotification($user,$password));

            return back()->withSuccess("User Created Successfully");

        } catch (Exception $e) {

            return back()->withError($e->getMessage()); 
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $countries = Country::get();
        return view("user.update",compact('user','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            
            $data = [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "country_id" => $request->country_id,
                "state_id" => $request->state_id,
                "city_id" => $request->city_id
            ];

            if ($request->hasFile('photo')) {
                $data['photo'] =  $request->file('photo')->store('photos','public');
            }

            $user->update($data);

            return back()->withSuccess("User updated Successfully");

        } catch (Exception $e) {

            return back()->withError($e->getMessage()); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->withSuccess("User deleted Successfully"); 
    }


    public function updateStatus(User $user)
    {
        $user->update(["is_active" => !$user->is_active]);

        return back()->withSuccess("User Status Updated Successfully");
    }
}
