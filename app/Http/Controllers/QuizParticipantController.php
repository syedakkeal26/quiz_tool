<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\quiz_participant;
use Illuminate\Http\Request;
use App\Models\quiz_main;
use App\Models\quiz_questions;
use App\Models\quiz_options;
use App\Models\participator;
use App\Models\AssetMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\linkGen;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use DateTime;
use App\Mail\Subscribe;
use Illuminate\Support\Facades\Mail;
use App\Models\QuizSection;
use Symfony\Component\Console\Question\Question;
use App\Models\Grouplink;
use App\Models\Category;
use Stevebauman\Location\Facades\Location;
use Adrianorosa\GeoLocation\GeoLocation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;



class QuizParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $id=$request->cookie('id1');
        $id = Cookie::get('id1');

        if ($id != null) {
            $participator = participator::with('department', 'category')->where('id', $id)->first();
            $title_where = participator::where('id', $id)->value('department_id');
            $title = AssetMaster::where('id', $title_where)->value('title');
            $q_count = AssetMaster::where('id', $title_where)->value('total_questions');
            $time = 2 * $q_count;

            return view('Quiz_participants.quiz_participant_index', compact(['participator', 'title', 'time']));
        } else {
            return Redirect::away("/finish");
        }
    }


    public function participantRegisterView($slug)
    {

        Session::forget('slug');
        if (Cookie::has('id1')) {

            return redirect()->route('quiz.index');
        } else {

            $linkData = DB::table('link_gens')
                ->where('slug', '=', $slug)
                ->where('participant_id', '=', NULL)->get();

            if (count($linkData) > 0) {

                return view('Quiz_participants.participants_register', compact('slug'));
            } else {
                return view('Quiz_participants.quiz_finished');
            }
        }
    }

    public function participantRegister(Request $request)
    {
        $group_id = linkGen::where('slug', $request->slug)->value("group_id");
        if ($group_id == null) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:participators',
                'password' => 'required|min:8',
                'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:participators',
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:participators|ends_with:colanonline.com,colaninfotech.net,colaninfotech.in',
                'password' => 'required|min:8',
                'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:participators',
            ]);
        }
        if (!participator::where('phone_no', $request->phone_no)->exists()) {
            $dep_id = linkGen::where('slug', $request->slug)->first();
            Session::put('link', $dep_id->id);

            $dept = DB::table('asset_master')
                ->where('id', '=', $dep_id->dept_id)->first();

            if (!empty($dept) && ($dep_id->participant_id == null)) {

                $data = new participator;
                $data->name = $request->name;
                $data->email = $request->email;
                $data->password = Hash::make($request->password);;
                $data->department_id = $dept->id;
                $data->Phone_no = $request->phone_no;
                $data->type = "participate";
                $data->save();
                $id = $data->id;
                if ($data->save()) {

                    Cookie::forever('id1', $data->id);

                    linkGen::where(['id' => $dep_id->id, 'slug' => $request->slug, 'participant_id' => null])
                        ->update($data = [
                            'participant_id' => $data->id
                        ]);
                    Session::forget('finished');
                    $audio_status = linkGen::where('slug', $request->slug)->value('audio_status');
                    Session::put('audio_status', $audio_status);
                    return redirect()->route('quiz.index')->withCookie(cookie('id1', $id));
                }
            } else {
                return view('Quiz_participants.quiz_finished');
            }
        } else {
            return back()->with('warning', 'You have already registered, please go to login page');
        }
    }
    public function test_start(Request $request)
    {

        Session::put('started', true);
        $id = $request->cookie('id1');
        if (Session::has('start_time') != null) {
            Session::get('start_time');
        } else {
            $details = GeoLocation::lookup();
            $user_ip=$details->getIp();
            $location=Location::get( $user_ip);
            $user_ip=$location->ip;
            $user_country=$location->countryName;
            $user_state=$location->regionName;
            $user_city=$location->cityName;
            $address=$user_city.','.$user_state.','.$user_country;
           // dd($_SERVER,$user_ip,$location);
            $start_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
            Session::put('start_time', $start_time);

            $participator1 = participator::where('id', $id)->value('start_time');
            $linkgen = linkGen::where('participant_id', $id)->latest('id')->first();
            linkGen::where('id', $linkgen->id)->update([
                'ipaddress'=> $user_ip,
                'location'=>$address,
            ]);
            if ($participator1 == null) {
                participator::where('id', $id)
                    ->update([
                        'start_time' => $start_time,
                        'ipaddress'=> $user_ip,
                        'location'=>$address,
                    ]);

                $linkgen_time = linkGen::where('participant_id', $id)->latest('id')->first();
                $linkgen_time->update([
                    'start_time' => $start_time
                ]);
            } else {
                participator::where('id', $id)
                    ->update([
                        'start_time' => $start_time
                    ]);
                $linkgen_time = linkGen::where('participant_id', $id)->latest('id')->first();
                $linkgen_time->update([
                    'start_time' => $start_time
                ]);
            }
        }

        $link_id = Session::get('link');
        $assetmasterid = linkGen::where('id', $link_id)->value('dept_id');
        $assetmasterTotalQues = AssetMaster::where('id', $assetmasterid)->value('total_questions');
        $test_time = $assetmasterTotalQues * 2;
        $minutes = 60 * 2;
        $hours = intdiv($minutes, 60) . ':' . ($minutes % 60);

        $end_time = participator::where('id', $id)->value('start_time');
        $end_time = Carbon::parse($end_time)
            ->addMinutes($test_time);


        $current_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $diff_min = $current_time->diffInMinutes($end_time);
        $d1 = new DateTime($current_time);
        $d2 = new DateTime($end_time);
        $interval = $d1->diff($d2);
        $diff_sec = $interval->s;
        $diff_min = $interval->i;
        $diff_hrs = $interval->h;

        if (Cookie::has('id1')) {
            $id = Cookie::get('id1');
            $participator = participator::with('quiz_main')->where('id', $id)->first();

            $section1 = QuizSection::where('asset_master_id', $assetmasterid)->get();
            $questions = null;
            $groupid = linkGen::where('id', $link_id)->value('group_id');
            $group_ques = Grouplink::where('id', $groupid)->value('group_question_id');
            $group_split = json_decode($group_ques);
            // dd( $groupid,$group_ques,$group_split);
            if ($groupid != null) {
                foreach ($group_split as $key => $section) {

                    if ($questions == null) {
                        $questions = quiz_questions::with('options')
                        						  ->where('archieved_status', null)
                        						->where('id', $section);
                    } else {
                        $questions2 = quiz_questions::with('options')
                        							->where('archieved_status', null)
                        							->where('id', $section);
                        $questions->union($questions2);
                    }
                }
                $quiz1 = $questions->InRandomOrder()->get()->toArray();
            } else {
                foreach ($section1  as $key => $section) {
                    if ($questions == null) {
                        $questions = quiz_questions::with('options') 
                        						->where('archieved_status', null)
												->where('quiz_id', $section->quiz_main_id)
                        						->InRandomOrder()->limit($section->no_of_questions);
                    } else {
                        $questions2 = quiz_questions::with('options')
                         							->where('archieved_status', null)
													->where('quiz_id', $section->quiz_main_id)
                        							->InRandomOrder()->limit($section->no_of_questions);
                        $questions->union($questions2);
                    }
                }
                $quiz1 = $questions->get()->toArray();
            }

            foreach($quiz1 as $categorys)
            {
                $category[] =Category::where('id',$categorys['category_id'])->value('category_name');
            }

            $t_status = linkGen::where('id', $link_id)->value('status');
            if ($t_status == null) {
                $linkgen = linkGen::where('id', $link_id)->update([
                    'status' => 0,
                ]);
            }
            $audio_status = linkGen::where('id', $link_id)->value('audio_status');
            return view('Quiz_participants.quiz_participant_view', compact(['quiz1', 'participator', 'diff_hrs', 'diff_min', 'diff_sec', 'link_id', 'audio_status','category']));
        } else {
            return Redirect::away("/finished");
        }
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
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $linkgen_id = linkGen::where('dept_id', $request->dept_id)->where('participant_id', $request->participant)->latest('id')->first();
        // dd($linkgen_id);
        $link_status = $linkgen_id->status;
        if ($link_status == 0) {
            // dd($request->dept_id);
            Session::put('finished', true);
            $sess = $request->sess;

            Session::put('sess', $sess);
            $sess1 = Session::get('sess');

            $val1 = $request->all();

            $quiz_answer = array();

            foreach ($val1 as $key => $value) {
                $key_split = explode("_", $key);

                if ($key_split[0] == "ques") {
                    $quiz_answer["question" . $key_split[1]]["id"] = $val1['ques_' . $key_split[1]];
                    $quiz_answer["question" . $key_split[1]]["answer"] = isset($val1['answer_' . $key_split[1]]) ? $val1['answer_' . $key_split[1]] : 0;
                }
            }

            foreach ($quiz_answer as $value) {
                foreach ($value as $key => $val) {
                    if ($key == "id") {
                        $q_id = (int)$val;
                        $question = quiz_questions::where('id', $q_id)
                        							->where('archieved_status', null)
													->get();
                    }
                    if ($key == "answer") {
                        $option_id = (int)$val;
                        if ($val != 0) {
                            $option = quiz_options::where('id', $option_id)                                                  
												  ->get();

                            if ($option[0]->answer == 1) {
                                $score = $question[0]->score;
                            } else {
                                $score = 0;
                            }
                        } else {
                            $score = 0;
                        }

                        $ques_id = quiz_questions::where('id', $q_id)
                        						->where('archieved_status', null)
												->value('quiz_id');

                        $linkgen_id = linkGen::where('dept_id', $request->dept_id)->where('participant_id', $request->participant)->latest('id')->first();

                        $participation = new quiz_participant;
                        $participation->participant_id = $request->participant;
                        $participation->question_id = $q_id;
                        $participation->option_id = $option_id;
                        $participation->score = $score;
                        $participation->max_score = $question[0]->score;
                        $participation->quiz_main_id = $ques_id;
                        $participation->linkgen_id = $linkgen_id->id;
                        $result = $participation->save();


                        $linkgen = linkGen::where('dept_id', $request->dept_id)->where('participant_id', $request->participant)->orderBy('id', 'DESC')->limit(1)->update([
                            'status' => 1, 'end_time' => $end_time,
                        ]);

                        $pscore = 0;
                        $pmaxscore = 0;
                        $participant_score = quiz_participant::where('linkgen_id', $linkgen_id->id)->get();
                        foreach ($participant_score as $marks) {
                            $pscore = $pscore + $marks->score;
                        }
                        $linkgen = linkGen::where('dept_id', $request->dept_id)->where('participant_id', $request->participant)->orderBy('id', 'DESC')->limit(1)->update([
                            'total_mark' => $pscore,
                        ]);
                    }
                }
            }
            if ($result) {
                $cookies = Cookie::forget('id1');
                Session::forget('start_time');
                $sess = Session::get('sess');
                Session::forget('started');
                $group_id=$linkgen_id['participant_id'];
                $email_split = participator::where('id',$group_id)->value('email');
                $mail_split = explode("@", $email_split);
                return response()->view("Quiz_participants.quiz_finish", compact('sess','mail_split'))->withCookie($cookies);
            }
            return "Inserted Successfully";
        } else {
            return view('Quiz_participants.quiz_finished');
        }
    }

    public function finish()
    {

        return view('Quiz_participants.quiz_finish');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\quiz_participant  $quiz_participant
     * @return \Illuminate\Http\Response
     */
    public function show(quiz_participant $quiz_participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\quiz_participant  $quiz_participant
     * @return \Illuminate\Http\Response
     */
    public function edit(quiz_participant $quiz_participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\quiz_participant  $quiz_participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, quiz_participant $quiz_participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\quiz_participant  $quiz_participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(quiz_participant $quiz_participant)
    {
        //
    }

    public function participantLoginView($slug)
    {
        Session::forget('slug');
        if (Cookie::has('id1')) {

            return redirect()->route('quiz.index');
        } else {

            $linkData = DB::table('link_gens')
                ->where('slug', '=', $slug)
                ->where('participant_id', '=', NULL)->get();

            if (count($linkData) > 0) {
                return view('Quiz_participants.participant_login', compact('slug'));
            } else {
                return view('Quiz_participants.quiz_finished');
            }
        }
    }


    public function participantlogin(Request $request)
    {
        $get_email = linkGen::where('slug', $request->slug)->value('email');
        $get_data = participator::where('email', $get_email)->value('Phone_no');
        $request->validate([
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|min:8',
        ]);
        $data = participator::where('Phone_no', $request->mobile)->first();
        if ($get_email == null) {
            if (!participator::where('Phone_no', $request->mobile)->exists()) {
                return back()->with('error', 'mobile is not valid');
            } else {
                $password = Hash::check($request->password, $data->password);
                if ($password == true) {
                    $id = $data->id;
                    $dep_id = linkGen::where('slug', $request->slug)->first();
                    $dept1 = DB::table('asset_master')->where('id', '=', $dep_id->dept_id)->first();
                    $dept = DB::table('asset_master')
                        ->where('id', '=', $dep_id->dept_id)->first();
                        // dd($dept);
                    if ($dep_id->status != 1) {
                        participator::where('Phone_no', $request->mobile)->update([
                            'department_id' => $dept->id,
                        ]);
                        Cookie::forever('id1', $data->id);

                        linkGen::where(['id' => $dep_id->id, 'slug' => $request->slug])
                            ->update($data = [
                                'participant_id' => $data->id
                            ]);
                        Session::put('link', $dep_id->id);
                        Session::forget('finished');
                        $audio_status = linkGen::where('slug', $request->slug)->value('audio_status');
                        Session::put('audio_status', $audio_status);
                        return redirect()->route('quiz.index')->withCookie(cookie('id1', $id));
                    } else {
                        return view('Quiz_participants.quiz_finished');
                    }
                } else {
                    return back()->with('error', 'Password is not valid');
                }
            }
        } else {
            if ($get_data == $request->mobile) {
                $password = Hash::check($request->password, $data->password);
                if ($password == true) {
                    $id = $data->id;
                    $dep_id = linkGen::where('slug', $request->slug)->first();
                    $dept1 = DB::table('asset_master')->where('id', '=', $dep_id->dept_id)->first();
                    $dept = DB::table('quiz_mains')
                        ->where('id', '=', $dep_id->dept_id)->first();
                    if ($dep_id->status != 1) {
                        participator::where('Phone_no', $request->mobile)->update([
                            'department_id' => $dep_id->dept_id,
                        ]);
                        Cookie::forever('id1', $data->id);

                        linkGen::where(['id' => $dep_id->id, 'slug' => $request->slug])
                            ->update($data = [
                                'participant_id' => $data->id
                            ]);
                        Session::put('link', $dep_id->id);
                        Session::forget('finished');
                        $audio_status = linkGen::where('slug', $request->slug)->value('audio_status');
                        Session::put('audio_status', $audio_status);
                        return redirect()->route('quiz.index')->withCookie(cookie('id1', $id));
                    } else {
                        return view('Quiz_participants.quiz_finished');
                    }
                } else {
                    return back()->with('error', 'Password is not valid');
                }
            } else {
                return back()->with('error', 'Invalid Username and Password');
            }
        }
    }
 public function getotp(Request $request){   
    		$getphone= $request->number;
 			$slug = $request->slug;
    		$checkPhone = participator::where('Phone_no', $getphone)->first();
    		if($checkPhone != null){
    		$randomNumber = random_int(100000, 999999);
    		$checkPhone->otp = $randomNumber;
    		$checkPhone->save();
    		$getEmail = $checkPhone->email;
    		Session::put('user_email',$getEmail);
            $user_email=Session::get('user_email');
            if ($randomNumber) {
                $details = [
                    'emp_name'=>$checkPhone->name,
                    'otp'=>$randomNumber,
                ];
                    Mail::to($user_email)->send(new \App\Mail\Forget($details));
                    }
    		return view('Quiz_participants.forget_pass', compact('getEmail','slug'));
    		}
    		else{ 
    		return redirect()->back()->with('error', 'Invalid Mobile Number');
    		}
 }
  
		public function forget(Request $request){
        $otp=$request->otp;
        $slug=$request->slug;
        $user_email=Session::get('user_email');
        $db_otp=participator::where('email', $user_email)->first();
        $randomString = Str::random(8);
        $new_pass=Hash::make($randomString);
        if($db_otp->otp==$otp){
        		$db_otp->password = $new_pass;
            	$db_otp->otp = null;
        		$db_otp->save();
        	if($db_otp->save()){
            
             $details = [
                            'user_name' => $db_otp->name,
                            'user_email' => $user_email,
                            'password'=>$randomString,
                            
                        ];
            	Mail::to($user_email)->send(new \App\Mail\ForgetOtpMail($details));
            }
        return redirect("/participantLoginView/$slug");
        }
        return redirect()->back()->with('error', 'Invalid OTP');

        
        // dd($user_email,$otp);
	}
    public function forget_password_view($slug)
    {
        Session::put('slug', $slug);
        return view('Quiz_participants.passwords.email', compact('slug'));
    }

    public function send_otp(Request $request)
    {

        $request->validate([
            'number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $number = $request->number;
        $slug = $request->slug;
        $user_number = participator::where('Phone_no', '=', $number)->first();

        if ($user_number == null) {
            return back()->with('error', 'Please enter a valid phone number');
        } else {
            session()->put('number', $number);
            $test = session()->get('number');

            $user_email = participator::where('Phone_no', '=', $number)->value('email');
            $user_name = participator::where('Phone_no', '=', $number)->value('name');

            $user = participator::where('Phone_no', '=', $number)->get();
            // dd($user);

            do {
                $randomNumber = random_int(100000, 999999);
            } while (participator::where("otp", "=", $randomNumber)->first());

            $otp = participator::where('Phone_no', '=', $number)
                ->update(['otp' => $randomNumber]);
            if ($otp) {
                Mail::to($user_email)->send(new Subscribe($user_name, $randomNumber));
            }

            return redirect()->route("verify_otp_view")->with('success', 'OTP SENT TO YOUR REGISTERED MAILID');;
        }
    }
    public function verify_otp_view()
    {
        $slug = session()->get('slug');
        return view('Quiz_participants.passwords.reset', compact('slug'));
    }
    public function otp_verify(Request $request)
    {

        $this->validate($request, [
            'otp' => 'required',
        ]);
        $otp = $request->otp;
        $slug = $request->slug;
        $user_number = session()->get('number');
        $dbOTP = participator::wherePhone_no($user_number)->value('otp');

        if ($dbOTP == $otp) {
            $user_number = session()->get('number');
            //updating OTP to NULL
            participator::where("Phone_no", $user_number)->update([
                'otp' => null
            ]);
            return redirect()->to("/verified");
        } else {
            return back()->with('error', 'Please enter a valid OTP');
        }
    }
    public function verified_view()
    {
        $slug = session()->get('slug');
        return view('Quiz_participants.passwords.confirm', compact('slug'));
    }
    public function change_password(Request $request)
    {

        $this->validate($request, [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8'
        ]);
        $password = $request->password;
        $user_number = session()->get('number');
        participator::where("Phone_no", $user_number)->update([
            'password' => Hash::make($request['password'])

        ]);
        $slug = Session::get('slug');
        Session::forget('number');
        return redirect()->to("participantLoginView/$slug")->with('success', 'password Changed Successfully');
    }


    public function test_video($id)
    {
        if(gettype($id)=="string")
            $slug =$id;
        else
        $slug = linkGen::where('id', $id)->value('slug');
        return view('Quiz_participants.video_iframe', compact('slug'));
    }
    public function view_online($slug)
    {
        $details = linkGen::where('slug', $slug)->first();
        return view('Quiz_participants.view_test', compact('details'));
    }

    public function finished()
    {
        return view('Quiz_participants.quiz_finished');
    }
    public function reset(Request $request)
    {
        $id = $request->id;
        $participant_id = $request->participant_id;
        linkGen::where('id', $id)->where('participant_id', $participant_id)->update([
            "status"     => NULL,
            "participant_id"  => NULL,
        ]);
        $delete_recort = quiz_participant::where('linkgen_id',$id)->where('participant_id',$participant_id)->delete();
        return redirect('/result');

    }
    public function meeting(Request $request, $id)
    {   
        return view('metting_page', compact('id'));        
    }
}
