<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        return view('pages.profile.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modles\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modles\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modles\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pofile)
    {
        $user = User::find($pofile);
        $this->validate($request,[
            'first_name' => 'required',
            'gender' => 'required',
            'phone' => 'required',

        ]);

        $data = $request->except('status','first_name','last_name');
        $data['name'] = $request->first_name;
        if($lastName = $request->last_name){
            $data['name'] = $data['name'].' '.$lastName;
        }

        if ($request->has('avatar')) {
            $file_path = public_path('storage / images / ' . $user->avatar);
            if (file_exists($file_path) && !empty($user->avatar)) {
                unlink($file_path);
            }
            $image = $request->file('avatar');
            $name = $user->id . '-' . time() . '.' . $image->getClientOriginalExtension(); //getting the extension and create name
            $image->storePubliclyAs('public/img/profile', $name);
            $image_path = "storage/img/profile/" . $name;
            $data['avatar'] = $image_path ;
        }


        $user->update($data);
        return redirect()->back()->with('success', trans('trans.updated_successful'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modles\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function passwordUpdate(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if (Auth::check() && $user->id == auth()->user()->id) {
            if (Hash::check($request->current_password, $user->password)) {
//                $user = User::findOrFail($user->id);
                $user->password = bcrypt($request->password);
                $user->save();
                return redirect()->back()->with('success', trans('trans.password_changed_successfully'));
            } else {
                return redirect()->back()->with('error', trans('trans.current_password_does_not_match'));
            }

        } else {
            return redirect()->to('/');
        }
    }


}
