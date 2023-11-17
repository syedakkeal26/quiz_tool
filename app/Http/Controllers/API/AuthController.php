<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Validator;
use App\Models\User;
use App\Models\AssetMaster;
use App\Models\linkGen;
use App\Models\quiz_main;
use App\Models\Category;
use App\Models\participator;
use App\Models\quiz_participant;
use App\Models\quiz_questions;
use App\Models\quiz_options;
use App\Models\QuizSection;
use App\Models\employee_skills;
use App\Models\Test_request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function get_details(Request $request)
    {
        // $username="admin";
        // $password="admin123";
        // if($username==$request->username && $password==$request->password){
            $email=$request->email;
            // dd($email);
            if($email){
                $id=participator::where('email',$email)->value('id');
                if($id){

                    $linkGen=linkGen::with('title','participator')->where('participant_id',$id)->where('status',1)->orderBy('created_at', 'DESC')->get();
                //    dd($linkGen);
                    $linkGenResponse = collect($linkGen);
                    $linkGenResponse->map(function ($linkGen)use($id) {
                    $linkid = base64_encode($linkGen->id);
                    $total_mark=quiz_participant::where('linkgen_id',$linkGen->id)->sum('max_score');

 								$assets = AssetMaster::where('id', $linkGen->dept_id)->value('id');
                        $sections = QuizSection::with('quiz_main')->where('asset_master_id', $assets)->get();

                        $sections = QuizSection::with('quiz_main')->where('asset_master_id', $assets)->get();
                        foreach ($sections as $key => $section) {
                            foreach ($section->quiz_main as $sec) {
                                $parent[] = $sec->category->parent_id;
                            }
                        }

                    	 $parentid = array_unique($parent);
                        foreach ($parentid as $parents) {

                            $category[] = Category::with('department')->where('id', $parents)->first();
                        }


                        $linkGen['pdf_url'] = "https://quiztool.colanapps.in/public/report_download/";
                        // $linkGen['pdf_url'] = "http://127.0.0.1:8000/report_download/";
                        $linkGen['linkgenId'] = $linkid;
                        $linkGen['total_score'] = $total_mark;
                        $linkGen['category_name'] = $linkGen->participator->category;
                   		$linkGen['cat']=$category;

                        return $linkGen;
                    });

                    return  response()->json([$linkGenResponse]);

                }else{
                    return response()->json(['message' => 'Email Does not Exist']);
                }
            }
            else{
                return response()->json(['message' => 'Email field is required']);
            }
        // }else{
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

    }
    public function employee_skills(Request $request)
    {
        $email=$request['email'];
        $emp_skills=$request['skills'];
        // dd($email);
        if($email){
            $id=participator::where('email',$email)->value('id');

            if($id){
                // $linkGen=linkGen::with('title','participator')->where('participant_id',$id,)->where('status',1)->get();

                //Check skill availablity
                $linkGens_array = array();
                foreach($emp_skills as $newskill)
                {
                    $all_test= DB::table('asset_master as t1')
                                ->select('t1.title', 't4.category_name', 't1.id','t4.id as cat_id')
                                ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
                                ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
                                ->join('categories as t4', 't4.id', '=', 't3.category_id')
                                ->whereRaw('LOWER(t4.category_name) like ? ',['%'.trim(strtolower($newskill))])
                                ->first();
                               //dd($all_test);

                    if($all_test)
                    {
                            $testresult= DB::table('link_gens')
                            ->select('link_gens.dept_id', 'link_gens.participant_id', 'link_gens.total_mark', 'quiz_mains.category_id', 'quiz_mains.max_score','categories.category_name')
                            ->join('asset_master','link_gens.dept_id','=','asset_master.id')
                            ->join('quiz_sections','asset_master.id','=','quiz_sections.asset_master_id')

                            ->join('quiz_mains','quiz_mains.id','=','quiz_sections.quiz_main_id')
                             ->join('categories','categories.id','=','quiz_mains.category_id')
                            ->where('link_gens.participant_id',$id)
                            ->where('quiz_mains.category_id',$all_test->cat_id)
                            ->orderBy('link_gens.total_mark', 'DESC')
                            //->orderBy('link_gens.id', 'DESC')
                            ->first();



//                     if($all_test->cat_id == 4)
//                     {	dd($testresult);
//                     }

                    if($testresult)
                    {
                            $category =$testresult->category_name;
                            $category =strtolower($category);
                            $total_mark =$testresult->total_mark;
                            $max_score =$testresult->max_score;
                            $score_1 = $total_mark / $max_score;
                            $score = $score_1 * 100;
                           // dd($score);
                            if($score < 40){
                                //Fail
                                $linkGens = "YES";
                            }
                            else{
                                //Pass
                                $linkGens ="YES~PASS";
                            }
                            $linkGens_array[$newskill] = $linkGens;
                        }
                        else
                        {
                            //Not attended
                            $linkGens_array[$newskill] ='YES';
                        }
                    }
                    else
                    {
                        //No test
                        $linkGens_array[$newskill] ='NO';
                    }

                }
                return  response()->json([$linkGens_array]);

            }else{
                return response()->json(['message' => 'Email Does not Exist']);
            }
        }
        else{
            return response()->json(['message' => 'Email field is required']);
        }


    }

    public function get_count(Request $request)
    {
        $email=$request->email;
        if($email){
            $id=participator::where('email',$email)->value('id');
            if($id){
                $data=linkGen::with('title','participator')->where('participant_id',$id)->where('status',1)->get();
                $count=count($data);
                // $linkGenResponse = collect($linkGen);
                // $linkGenResponse->map(function ($linkGen)use($id) {
                // $linkid = base64_encode($linkGen->id);
                // $total_mark=quiz_participant::where('linkgen_id',$linkGen->id)->sum('max_score');

                //     $linkGen['pdf_url'] = "https://quiztool.colanapps.in/public/report_download/";
                //     $linkGen['linkgenId'] = $linkid;
                //     $linkGen['total_score'] = $total_mark;

                //     return $linkGen;
                // });

                return  response()->json(['count' => $count]);

            }else{
                return response()->json(['message' => 'Email Does not Exist']);
            }
        }else{
            return response()->json(['message' => 'Email field is required']);
        }
    }
     public function get_answer(Request $request)
    {
        $email = $request->email;
        $testno = $request->testno;
            if($email){
                $id=participator::where('email',$email)->value('id');
                if($id){
                    $query = quiz_participant::where('participant_id',$id)->where('linkgen_id',$testno)->get();
                    foreach ($query as $key => $value) {
                        $participant_id = $value['participant_id'];
                        $question = quiz_questions::where('id',$value['question_id'])->value('question');
                        $answer = quiz_options::where('question_id',$value['question_id'])
                                  ->where('answer','1')->value('option');
                        $linkid = linkGen::where('id',$testno)->value('dept_id');
                        $title = AssetMaster::where('id',$linkid)->value('title');

                        if($value['option_id']==0){
                            $yourans = '---';
                        }
                        else{
                         $yourans = quiz_options::where('id',$value['option_id'])->value('option');
                        }

                        if($value['score'] == '0'){
                            $status = 'wrong';
                        }
                        else{
                            $status = 'correct';
                        }


                    $data[] = [

                        'participant_id Name' => $participant_id,
                        'question' => $question,
                        'answer' => $answer,
                        'your answer' => $yourans,
                        'status' => $status
                    ];

                }
                 return response()->json(['data' => $data,'title' => $title ]);


                }else{
                    return response()->json(['message' => 'Email Does not Exist']);
                }
            }else{
                return response()->json(['message' => 'Email field is required']);
            }

    }
    public function employee_test_request(Request $request){
        $mail=$request->email;
        $emp_skills=$request->Skill;
        $asset=$request->skill_master_id;
       // dd($asset);
        if($mail){
            $id=participator::where('email',$mail)->value('id');
            // dd($id);
            if($id){
                $search = $request->category;
                $user= DB::table('asset_master as t1')
                ->select('t1.title', 't4.category_name', 't1.id')
                ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
                ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
                ->join('categories as t4', 't4.id', '=', 't3.category_id')
                ->where('t1.id', '=',$asset )
                 //->whereRaw('LOWER(t4.category_name) like ? ',['%'.trim(strtolower($search))])
                ->limit(1)
                ->get();
                //dd($user);
                $mail_split = explode(",", $mail);
                $arr_filter = array_unique($mail_split);
                foreach ($arr_filter as  $mails) {
                    $host = request()->getHttpHost();
                    $url = url('/') . "/participant_register";
                    // dd($url);
                    $depts = DB::table('asset_master')
                        ->where('id', '=', $asset)->value('title');
    // dd($depts);
                    if (linkGen::whereSlug($slug = str_slug($depts))->exists()) {
                        $original = $slug;
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                        $rand = substr(str_shuffle(str_repeat($pool, 5)), 0, 7);
                        $count = 2;

                        while (linkGen::whereSlug($slug)->exists()) {
                            $slug = "{$original}_" . $count++ . $rand;
                        }
                    }

                    $data = new linkGen;
                    $data->url = $url;
                    $data->dept_id = $asset;
                    $data->slug = $slug;
                    $data->email =$mails;

                    if ($data->save()) {
                        $new_url = $url . "/" . $slug;
                    } else {
                        $new_url = "Url is not generated <br> Please try again";                }

                    $details = [
                        'URL'  => $new_url,
                        'mail' => $mails,
                        'asset'=>$asset
                    ];

                    \Mail::to($mails)->later(now()->addMinutes(5),new \App\Mail\GroupMail($details));
                    $message = "Mail Sent successfully";
                }
                return response()->json(["success" => true]);
            }
        }
    }

public function test_list(Request $request)
    {       // purticular skill -mached
        $email=$request->email;
		$emp_skills=$request->emp_skills;
// dd($emp_skills);

        if($email){
            $id=participator::where('email',$email)->value('id');
            if($id){
 				$search = $request->skills;
            //dd($search);
            //New coding  Dec 6 start

			 // $new_test=DB::table('asset_master as t1')
			 // ->select('t1.title', 't4.category_name', 't1.id')
			 // ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
			 // ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
			 // ->join('categories as t4', 't4.id', '=', 't3.category_id')
			 // ->get();
          //   //$result=array_uintersect($new_test,$emp_skills);
          //   $result = '';
          // foreach ($new_test as $val){
          // $result=$val['title'];
          // }

          //  dd($new_test);


            // End DEC 6



                $all_test= DB::table('asset_master as t1')
                 ->select('t1.title', 't4.category_name', 't1.id')
                 ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
                 ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
                 ->join('categories as t4', 't4.id', '=', 't3.category_id')
                 ->whereRaw('LOWER(t4.category_name) like ? ',['%'.trim(strtolower($search))])
                 ->where('deleted_at',null)
                 ->get();
           // dd($all_test);



                 $sec_data = array();
                foreach ($all_test as  $all_tests) {
                // dd($all_tests);
                    $attend_test= DB::table('asset_master as t1')
                    ->select('t1.title', 't4.category_name', 't1.id','t5.total_mark','t3.max_score','t5.participant_id','t5.id as link_gens_id','t2.quiz_main_id')
                    ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
                    ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
                    ->join('categories as t4', 't4.id', '=', 't3.category_id')
                    ->join('link_gens as t5','t5.dept_id','=','t1.id')

                  //  ->groupBy('t1.id')
                    ->where('t1.id', '=',$all_tests->id )
                    ->where('t5.participant_id',$id)
                    ->get();
                     // dd($attend_test) ;
                    $topic= DB::table('asset_master as t1')
                    ->select('t1.title', 't4.category_name', 't1.id','t2.quiz_main_id')
                    ->join('quiz_sections as t2','t2.asset_master_id', '=', 't1.id')
                    ->join('quiz_mains as t3', 't3.id', '=', 't2.quiz_main_id')
                    ->join('categories as t4', 't4.id', '=', 't3.category_id')
                    //    ->groupBy('t1.id')
                    ->where('t1.id', '=',$all_tests->id )
                    ->get();
                   // dd($all_tests) ;
                   $key_array= $all_tests->title;
                   $removeTest = false;
                   #$key_id = $topics->quiz_main_id;
                    foreach ($topic as $key => $topics) {
                        $sec_data[$key_array]['topics'][]=$topics->category_name;

                    	//Check and remove main test
                    	if(!in_array($topics->category_name,$emp_skills))
                        {
                        	$removeTest = true;
                        	continue;
                        }
                        // $sec_data[$key_array]['topics'][]=$topics->status;

                    }

                	//Skip main test
                	if($removeTest == true)
                    {
                    	unset($sec_data[$key_array]);
                    	continue;
                    }

                    $sec_data[$key_array]['skill_status']="fail";


//dd($attend_test);
                  if(count($attend_test)>0 ){
                //  dd($attend_test);

                        foreach ($attend_test as $key => $attend_tests) {
                            $total_mark =$attend_tests->total_mark;
                       //dd($total_mark);
                            $max_score =$attend_tests->max_score;
                     // dd($max_score);
                            $score_1 = $total_mark / $max_score;

                            $score = (int)($score_1 * 100);
//dd($score);
                            if($score < 40){
                                $sec_data[$key_array]['status']="fail";
                                $sec_data[$key_array]['asset_id']=$attend_tests->id;
                                $sec_data[$key_array]['link_gens_id']=base64_encode($attend_tests->link_gens_id);
                            }
                            else{
                                $sec_data[$key_array]['status']="pass";
                                $sec_data[$key_array]['asset_id']=$attend_tests->id;
                                $sec_data[$key_array]['link_gens_id']=base64_encode($attend_tests->link_gens_id);

                            }
                             $attended_date=linkGen::where('id',$attend_tests->link_gens_id)->value('updated_at');
                             $sec_data[$key_array]['attended_date']= $attended_date->format('m/d/Y H:i:s');
                        	 $att_date=linkGen::where('id',$attend_tests->link_gens_id)->value('updated_at');
                             $sec_data[$key_array]['next_try']= $att_date->addDays(8)->format('m/d/Y H:i:s');
                       		$current_date=Carbon::now()->format('m/d/Y H:i:s');
                         	$sec_data[$key_array]['current_date']=$current_date;
                        	$at_date=$att_date->addDays(8)->format('m/d/Y H:i:s');
                      		if($current_date>=$at_date){
                      		$sec_data[$key_array]['next_atmp']='success';
                      		}else{
                      		$sec_data[$key_array]['next_atmp']='one week';
                      		}


                            $result_score=0;
                            $result_maxscore=0;
                            $questions= quiz_participant::where('quiz_main_id',$attend_tests->quiz_main_id)
                            ->where('linkgen_id',$attend_tests->link_gens_id)->get();
                            //dd($questions);
                            if(count($questions)>0){
                                foreach($questions as $key4 => $ques){
                                    $result_score = $result_score + $ques->score;

                                    $result_maxscore = $result_maxscore + $ques->max_score;

                                }
                                $count1 = $result_score / $result_maxscore;
                                $count22 = $count1 * 100;
                                $count2 = (int)ceil($count22);
                           // dd($attend_tests->category_name);
                          //.  dd((int)$count2);
                                #echo $count1."-".$count22."-".$count2."-".$result_score."-".$result_maxscore."<br>";
                                  # echo $attend_tests->category_name."<br>";
                                  #echo trim(strtolower($search))."-".trim(strtolower($attend_tests->category_name)); exit;
                                 # $sec_data[$key_array]['skill_status']="pass-".$count2;
                                if($count2>=40 && trim(strtolower($search)) == trim(strtolower($attend_tests->category_name))){
                                    $sec_data[$key_array]['skill_status']="pass";
                                    $sec_data[$key_array]['status']="pass";
                                }
                            }
                        }

                     }
                     else{
                        $sec_data[$key_array]['status'] ="nil";
                        $sec_data[$key_array]['asset_id']=$all_tests->id;
                    }
                }
                  // dd($sec_data);
                return  response()->json($sec_data);

            }else{
                return response()->json(['message' => 'Email Does not Exist']);
            }
        }
        else{
            return response()->json(['message' => 'Email field is required']);
        }
}
    public function get_test_request(Request $request)
    {


    	$user_email=$request->email;
    	$skill=$request->skill_name;
    $check_request=Test_request::where('user_email',$user_email)->where('skill_name',$skill)->value('id');

    if(!$check_request){

    $data= new Test_request;
    $data->user_email=$user_email;
    $data->skill_name=$skill;
    $data->save();

   return response()->json(['message' => 'Your Request has been submitted']);

   	}
   return response()->json(['message' => 'Already Requested! Please wait....']);

	}

}
