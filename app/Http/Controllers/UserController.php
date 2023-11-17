<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data=User::all();
        $datas = Auth::user();
        return view('profile',compact('datas'));
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
        //
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
        if($request->form=="password"){
            // $validated = $request->validate([
            //     'password' => 'required',
            //     'cpassword' => 'required|same:password',
            // ]);
            $rules = [
                'opassword' => 'required|min:8',
                'password' => 'required|min:8',
                'cpassword' => 'required|min:8|same:password',
            ];

            $customMessages = [
                'opassword.required' => 'The Old Password field is required.',
                'password.required' => 'The :attribute field is required.',
                'cpassword.required' => 'The Re-Enter Password field is required.',
                'same' => 'New Password and Re-Enter Password does not match'
            ];
            $this->validate($request, $rules, $customMessages);
            $old_password_db=User::where('id', $id)->value('password');
            if(Hash::check($request->opassword,$old_password_db)){
                User::where('id', $id)->update([
                    'password' => Hash::make($request->password),
                  ]);
                return redirect()->route('logout');
            }else{
                return redirect()->back()->with('error',' Incorrect Old Password');
            }
        }else{
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return redirect()->back()->with('message',' Profile Update sucessfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
