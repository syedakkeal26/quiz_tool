<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;



class SubadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subadmin=User::where('role','subadmin')->paginate(5);
        return view('subadmin.subadmin',compact('subadmin'));
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
        $ids=Crypt::decryptString($id);
        $subadmin=User::where('id',$ids)->first();
        return view('subadmin.edit_subadmin',compact('subadmin'));
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
        $this->validate($request, [
            'subadmin_name' => 'required',
            'subadmin_email' => 'required|ends_with:colanonline.com,colaninfotech.net,colaninfotech.in',
        ]);
        $id=$request->subadmin_id;
        $name=$request->subadmin_name;
        $email=$request->subadmin_email;

        $response = Http::withHeaders([
            'Authorization' => 'Basic bG10YXBpOjM4ZWJiZmNkMzkwMzM4YWY1OGFmYWQyNWE1NDlhMTU4',
        ])->asForm()->post('https://lmt.mycipl.in/emp_detail_mycipl.php', [
            'email' => $email,
        ]);
        $data = $response->collect('data')->first();
        if($data==null)
        {
            return redirect()->back()->with('error',"Invalid MailID or MailId Not Found");
        }
        $update=User::where('id', '=', $id)
            ->update(['name' => $name,
                    ]);
        $subadmin=User::where('role','subadmin')->paginate(5);
        Session::put('message','Details Updated successfully');
        // return redirect()->route('subadmin_list');
    return redirect('/subadmin');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $id=$request->subadmin_id;
        $emp_name=User::where('id',$id)->value('name');
        User::where("id", $id)->delete();
        // $data=User::where('id',$id)->delete();
        $subadmin=User::where('role','subadmin')->get();
        $msg='You Removed '.$emp_name.' From Sub-Admin';
        Session::put('messages', $msg);
     //    Session::put('message','Records Deleted successfully');
        return redirect()->route('subadmin.index')->with(compact('subadmin'));
    }

    public function regformapi(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|ends_with:colanonline.com,colaninfotech.net',
             ]);
        $url=$request->getSchemeAndHttpHost();
             if ($validator->fails()) {
                return response()->json(['success'=>'false','error'=>$validator->messages()]);
            }
            $user_email=$request->email;
            $response = Http::withHeaders([
                'Authorization' => 'Basic bG10YXBpOjM4ZWJiZmNkMzkwMzM4YWY1OGFmYWQyNWE1NDlhMTU4',
            ])->asForm()->post('https://lmt.mycipl.in/emp_detail_mycipl.php', [
                'email' => $user_email,
            ]);
            $data = $response->collect('data')->first();

            if($data==null)
            {
                return response()->json(['success'=>'false','error'=>['email'=>['EmailID Not found']] ]);
            }
            $emp_name=$data['Fullname'];
            $emp_email=$data['empOffEmail'];
            do {
                $randomString_password = Str::random(8);
                } while(User::where("password", "=", $randomString_password)->first());
            $db_emp=User::where("email", "=", $emp_email)->value('role');

            if($db_emp == 'employee'){
                User::where("email", "=", $emp_email)->update([
                    'role' => 'subadmin',
                    'password' => Hash::make($randomString_password)
                ]);
                $details = [
                    'emp_name' => $emp_name,
                    'emp_email' => $emp_email,
                    'password' => $randomString_password,
                    'route'=>  $url.'/public/admin',
                ];
                \Mail::to($emp_email)->send(new \App\Mail\Subadmin($details));
                return response()->json(['success'=>'true']);
            }
            elseif($db_emp==null)
            {
                $data = new User;
                $data->name = $emp_name;
                $data->email= $emp_email;
                $data->password=Hash::make($randomString_password);
                $data->role= 'subadmin';
                $data->save();
                if($data->save()){
                    $url=$request->getSchemeAndHttpHost();
                    $details = [
                                'emp_name' => $emp_name,
                                'emp_email' => $emp_email,
                                'password' => $randomString_password,
                                'route'=>  $url.'/public/admin',
                            ];
                            \Mail::to($emp_email)->send(new \App\Mail\Subadmin($details));
                }
                $msg='You Added '.$emp_name.' as Sub-Admin';
                Session::put('message', $msg);
                return response()->json(['success'=>'true']);
            }elseif($db_emp=='subadmin'){
                $msg=$emp_name.' is Already Exists';
                Session::put('message', $msg);
                return response()->json(['success'=>'true']);

        }
    }
    public function sendpassword(Request $request)
    {
        $emp_id=$request->data;
        $emp= str_replace('"', "", $emp_id);
        $emp_email=User::where("id", "=", $emp)->value('email');
        if($emp_email)
        {

            $emp_name=User::where("id", "=", $emp_email)->value('name');
            $emp_email=User::where("id", "=", $emp)->value('email');
            do {
                $randomString_password = Str::random(8);
                } while(User::where("password", "=", $randomString_password)->first());
                User::whereEmail($emp_email)->update([
                    'password'=>Hash::make($randomString_password),
                ]);
                $url=$request->getSchemeAndHttpHost();
                $details = [
                            'emp_name' => $emp_name,
                            'emp_email' => $emp_email,
                            'password' => $randomString_password,
                            'route'=> $url.'/public/admin',
                        ];
                        \Mail::to($emp_email)->send(new \App\Mail\Subadmin($details));

            Session::put('message','Credentials Sended Successfully');
            return response()->json(['success'=>'true']);
        }else{
            Session::put('messages','Something went wrong');
            return response()->json(['success'=>'true']);
        }
    }
}



