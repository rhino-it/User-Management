<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('index method on user controller');
        if (Gate::denies('logged-in')){
            dd('no access allowed');
        }
        if (Gate::allows('is-admin')){
            return view('admin.users.index',['users' => User::paginate(10)]);
        }
        dd('you need to be admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
//        $validatedData = $request->validated();
//        $user = User::create($validatedData);

//       $user = User::create($request->except(['_token','roles'])); you may delete

       $newUser = new CreateNewUser();
       $user = $newUser->create($request->only(['name','email','password','password_confirmation'])); /*all()*/

       $user->roles()->sync($request->roles);

       Password::sendResetLink($request->only(['email']));

       $request->session()->flash('success', 'You have created the user');

       return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit', [
            'roles' => Role::all(),
            'user' => User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user){
            $request->session()->flash('error', 'You cannot edit this user');
            return redirect(route('admin.users.index'));
        }
        $user->update($request->except(['_token', 'roles']));
        $user->roles()->sync($request->roles);
        $request->session()->flash('success', 'You have updated the user');
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
       User::destroy($id);

       $request->session()->flash('success', 'You have deleted the user');
       return redirect(route('admin.users.index'));
    }
}
