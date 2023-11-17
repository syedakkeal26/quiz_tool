<?php

namespace App\Http\Controllers;

use App\Models\quiz_main;
use App\Models\Department;
use App\Models\Category;
use App\Models\quiz_questions;
use App\Models\quiz_options;
use App\Models\AssetMaster;
use App\Models\Test_request;
use App\Models\QuizSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\QuizImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\quiz_participant;
use App\Models\participator;
use App\Models\linkGen;
use App\Models\User;
use Str;
use Auth;
use Crypt;
use Validator;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Models\Grouplink;
use Carbon\Carbon;

class QuizMainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('report_download');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $quiz_list = quiz_main::with('category','department')->paginate(5);
        // dd(Auth::user()->role);
        // if(Auth::user()->role!="subadminnew"){
        $quiz_list = DB::table('asset_master')->select('id', 'title', 'total_questions')->where('deleted_at',null)->latest()->paginate(5);
        $department = Department::all();
        $category = Category::select('category_name')->groupBy('category_name')->get();

        // dd($category);

        // return view('quiz_dept', compact('department', 'category'));
        return view('quiz_dept', compact('quiz_list', 'department', 'category'));
   //  }
   // return redirect()->route('participantList');
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

    public function import_view()
    {
        // dd('bjkdfbhgj');
        return view('quizimport');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'quiz_import'  => 'required|mimes:xls,xlsx'
        ]);


        Excel::import(new QuizImport, request()->file('quiz_import'));
        // dd('hgkujhgk');

        return redirect('/import')->with('message', 'File Imported Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\quiz_main  $quiz_main
     * @return \Illuminate\Http\Response
     */
    public function show($quiz_question_id)
    {
        //get quiz_main id

        $id = quiz_questions::select('quiz_id')->where('id', $quiz_question_id)->first();

        // dd($id);


        $quiz_view = DB::table('quiz_mains')
            ->join('quiz_questions', 'quiz_mains.id', '=', 'quiz_questions.quiz_id')
            ->join('quiz_options', 'quiz_questions.id', '=', 'quiz_options.question_id')
            ->where('quiz_options.question_id', '=', $quiz_question_id)
            ->paginate(5);
        $new_arr = array();
        $answer = "";
        foreach ($quiz_view as $key => $value) {
            foreach ($value as $key => $val) {
                //dd($val);
                if ($key == "title" || $key == "question" || $key == "option") {

                    $new_quiz_view[$key][] = $val;
                }
            }
            if ($value->answer == "1") {
                $answer = $value->option;
                ///echo $answer;
            }
        }
        foreach ($new_quiz_view as $key => $value) {
            $new_quiz_view[$key] = array_unique($value);
        }
        $new_quiz_view["answer"][] = $answer;
        //echo $new_arr->question;
        // foreach ($new_quiz_view as $key => $value) {
        //   echo "<pre>";
        //   print_r($value);
        //   if(array_key_exists(1, $value)){

        //       echo $value[1];
        //   }

        //     foreach ($value as $key => $val1) {
        //         //echo $val1."<br>";
        //     }
        //     //echo $value;
        // }
        //dd($new_quiz_view);
        return view('quiz_questionview', compact('new_quiz_view', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\quiz_main  $quiz_main
     * @return \Illuminate\Http\Response
     */
    public function edit($quiz_question_id)
    {

        // dd($id);

        $quiz_edit = DB::table('quiz_mains')
            ->join('quiz_questions', 'quiz_mains.id', '=', 'quiz_questions.quiz_id')
            ->join('quiz_options', 'quiz_questions.id', '=', 'quiz_options.question_id')
            ->where('quiz_options.question_id', '=', $quiz_question_id)
            ->paginate(5);
        $new_arr = array();
        $answer = "";
        $id = "";
        // dd($quiz_edit);
        foreach ($quiz_edit as $key => $value) {
            foreach ($value as $key => $val) {
                //dd($val);
                if ($key == "title") {

                    $new_quiz_edit[$key][$value->quiz_id] = $val;
                } elseif ($key == "question") {
                    $new_quiz_edit[$key][$value->question_id] = $val;
                } elseif ($key == "option") {
                    $new_quiz_edit[$key][$value->id] = $val;
                }
            }
            if ($value->answer == "1") {
                $answer = $value->option;
                $id = $value->id;
                ///echo $answer;
            }
        }
        foreach ($new_quiz_edit as $key => $value) {
            $new_quiz_edit[$key] = array_unique($value);
        }
        $new_quiz_edit["answer"][$id] = $answer;
        //dd($new_quiz_edit);

        $id = quiz_questions::select('quiz_id')->where('id', $quiz_question_id)->first();

        return view('quiz_questionedit', compact('new_quiz_edit', 'id'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\quiz_main  $quiz_main
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $options_id)
    {

        $id = $request->quiz_id;

        $option_split = explode("_", $options_id);
        array_pop($option_split);
        print_r($option_split);



        for ($i = 0; $i < count($option_split); $i++) {
            $option = "option_" . $option_split[$i];

            if ($request->option_ . $option_split[$i] == $request->answer) {

                quiz_options::where('id', $option_split[$i])->update($data = [
                    'option' => $request->$option,
                    'answer' => "1",
                ]);
            } else {

                quiz_options::where('id', $option_split[$i])->update($data = [
                    'option' => $request->$option,
                    'answer' => "0",
                ]);
            }
            print_r($data);
        }

        return redirect()->back()->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\quiz_main  $quiz_main
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request, $question_id)
    {

        quiz_options::where('question_id', $question_id)->delete();
        quiz_questions::where('id', $question_id)->delete();

        $quiz_id = $request->quiz_id;

        $max_score = 0;
        echo $quiz_id;
        $quiz_options = quiz_questions::where('quiz_id', $quiz_id)->get();
        foreach ($quiz_options as $key => $value) {
            $max_score = $max_score + $value->score;
        }
        echo $max_score . "<br>";


        $options_count = $quiz_options->count();
        echo $options_count;

        quiz_main::where('id', $quiz_id)->update($data = [
            'max_number_questions' => $options_count,
            'max_score' => $max_score,
        ]);

        return redirect()->back()->with('success', ' Question Deleted sucessfully');
    }

    public function result(Request $request)
    {

        $res = [];
        $ques = [];
        $live = '';
        if ($request->view_online == "on") {
            $data = '';

            $live = linkGen::with('title')->where('status', 0)->paginate(5);
        } else {
            $participant = participator::with('quiz_main')->get();
            //   dd($participant);

            $result = quiz_participant::with('category', 'participator')->get();

            $link_gen = linkGen::with('title')->orderBy('id', 'DESC')->get();


          //  foreach ($participant as $key => $value) {
                // dd($participant,$key,$value);


                foreach ($link_gen as $key => $val2) {

                    $score = 0;
                    $maxscore = 0;
                    foreach ($result as $key => $val) {



                        if ($val2->id == $val->linkgen_id) {

                           //no of question
                            // $res[$val2->id]['no_of_quis']=$count2 = DB::table('quiz_participants')
                            // ->where('linkgen_id', '=', $val->linkgen_id)
                            // ->count();
                            // dd($res[$val2->id]['no_of_quis']); --no of questions
                            // dd($val->participator->id);
                            $score = $score + $val->score;
                            $maxscore = $maxscore + $val->max_score;


                            $res[$val2->id]['id'] = $val2->id;
                            $res[$val2->id]['name'] = $val->participator->name;
                            $res[$val2->id]['participant_id'] = $val->participator->id;
                            $res[$val2->id]['department'] = $val2->title->title;
                            $res[$val2->id]['email'] = $val->participator->email;
                            $res[$val2->id]['mobile'] = $val->participator->Phone_no;
                            $res[$val2->id]['start_time'] = $val2->start_time;
                            $res[$val2->id]['score'] = $score;
                            $res[$val2->id]['max_score'] = $maxscore;
                            $res[$val2->id]['total_question']  = $val2->title->total_questions;

                        }
                    }
                }
                $live = '';
             //}

            $myCollectionObj = collect($res);
            $data = $this->paginate($myCollectionObj);
            // dd($data);
        }

        Session::put('view_online', $request->view_online);

        return view('Quiz_participants.participant_result', compact('data','live'));
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(url('/result'));
    }

    public function member_search(request $request)
    {
        // search (filter) function for result page
        if (Session::has('view_online') == true) {
             if (isset($request->title)) {
                $request->validate([
                    'title' => 'regex:/^[a-zA-Z]+$/',
                ]);
            }
        if (isset($request->name)) {
                $request->validate([
                    'name' => 'regex:/^[a-zA-Z]+$/',
                ]);
            }
            // if (isset($request->title)) {
            //     $request->validate([
            //         'title' => 'regex:/^[a-zA-Z]+$/',
            //     ]);
            // }
            if (isset($request->mobile)) {
                $request->validate([
                    'mobile' => 'regex:/^[-0-9\+]+$/',
                ]);
            }

            $data = [];
       // dd($request);
            if ((isset($request->title) ||isset($request->name)) || (isset($request->email)) || (isset($request->mobile)) || (isset($request->date))) {
              // $link_gen = linkGen::with('title')->orderBy('id', 'DESC')->get();
              //dd($request);
               // $query = linkGen::with('title')->query();
         // dd($query);
                $query = $query->where('status', 0);

                   if (isset($request->title)) {
                    $title = $request->title;
                    $query = $query->whereHas('department', function ($query) use ($title) {
                        $query->where('title', $title);
                    });
                }
                if (isset($request->name)) {
                    $name = $request->name;
                    $query = $query->whereHas('participator', function ($query) use ($name) {
                        $query->where('name', $name);
                    });
                }
                if (isset($request->email)) {
                    $email = $request->email;
                    $query = $query->whereHas('participator', function ($query) use ($email) {
                        $query->where('email', $email);
                    });
                }
                if (isset($request->mobile)) {
                    $mobile = $request->mobile;
                    $query = $query->whereHas('participator', function ($query) use ($mobile) {
                        $query->where('Phone_no', $mobile);
                    });
                }
                if (isset($request->date)) {
                    $date = $request->date;
                    $query = $query->whereDate('start_time', $date);
                }
                $live = $query->paginate(1);


                return view('Quiz_participants.participant_result', compact('data', 'live'));
            } else {
          //  dd("current");
                return redirect()->back();
            }
        } else {
            if ($request->name) {

                $request->validate([
                    'name' => 'regex:/^[a-zA-Z]+$/',
                ]);
            }

            if ($request->mobile) {
                $request->validate([
                    'mobile' => 'regex:/^[-0-9\+]+$/',
                ]);
            }

            $live = '';

            $participant = participator::with('department')->get();

            if ((isset($request->title)) || (isset($request->name)) || (isset($request->email)) || (isset($request->mobile)) || (isset($request->date))) {
				//dd($request->title);
              //   $query = "SELECT * FROM participators LEFT JOIN quiz_participants ON participators.id = quiz_participants.participant_id JOIN quiz_mains ON quiz_mains.id = quiz_participants.quiz_main_id JOIN departments ON departments.id = categories.department_id WHERE ";
        // dd($request->title);

                $query = "SELECT * FROM participators LEFT JOIN quiz_participants ON participators.id = quiz_participants.participant_id JOIN asset_master ON asset_master.id = participators.department_id  WHERE ";

                $where = array();

                $i = 0;
                 //dd($request->title);
                if (isset($request->title)) {
                    $title = $request->title;
                    if ($i > 0) {
                        $query .= " AND ";
                    }
                    $query .= "asset_master.title like '$title%'";
                    ++$i;
                    // dd( $query);
                }
                if (isset($request->name)) {
                    $name = $request->name;
                    if ($i > 0) {
                        $query .= " AND ";
                    }
                    $query .= "participators.name LIKE '$name%'";
                    //dd( $query);
                    ++$i;
                }
                if (isset($request->email)) {
                    $email = $request->email;
                    if ($i > 0) {
                        $query .= " AND ";
                    }
                    $query .= "participators.email LIKE '$email%'";
                    ++$i;
                }

                if (isset($request->mobile)) {
                    $mobile = $request->mobile;
                    if ($i > 0) {
                        $query .= " AND ";
                    }
                    $query .= "participators.Phone_no LIKE '$mobile%'";
                    ++$i;
                }

                if (isset($request->date)) {

                    if ($i > 0) {
                        $query .= " AND ";
                    }

                    $date = $request->date;
                    $query .= "quiz_participants.created_at like '$date%'";
                }



                $search = DB::select($query);

                $result = array();
                foreach ($search as $key => $value) {
                    foreach ($search as $key1 => $val1) {
                        if ((!empty($value->participant_id)) && (!empty($val1->participant_id))) {
                            $result[$value->participant_id][$key1] = $val1;
                        }
                    }
                }

                $res = array();

                $link_gen = linkGen::with('title')->get();

                foreach ($result as $key => $val) {
                    foreach ($link_gen as $key3 => $val2) {
                        $score = 0;
                        $maxscore = 0;

                        foreach ($val as $key2 => $val3) {

                            if (($val2->id == $val3->linkgen_id)) {
                                $score = $score + $val3->score;
                                $maxscore = $maxscore + $val3->max_score;
                                $res[$val2->id]['id'] = $val2->id;
                                $res[$val2->id]['name'] = $val3->name;
                                $res[$val2->id]['participant_id'] = $val2->participant_id;
                                $res[$val2->id]['department'] = $val3->title;
                                $res[$val2->id]['email'] = $val3->email;
                                $res[$val2->id]['mobile'] = $val3->Phone_no;
                                $res[$val2->id]['start_time'] = $val2->start_time;
                                $res[$val2->id]['score'] = $score;
                                $res[$val2->id]['max_score'] = $maxscore;
                                $res[$val2->id]['total_question']  = $val2->title->total_questions;
                            }
                        }
                    }
                }
                $myCollectionObj = collect($res);
                $data = $this->pagination($myCollectionObj);

                return view('Quiz_participants.participant_result', compact('data', 'live'));
            } else {

                return redirect('/result');
            }
        }
    }
    public function pagination($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(url('/member_search'));
    }

    public function quiz_list($id)
    {

        $quiz = quiz_main::with('department')->join('quiz_questions', 'quiz_mains.id', '=', 'quiz_questions.quiz_id')
            ->join('quiz_options', 'quiz_questions.id', '=', 'quiz_options.question_id')
            ->where('quiz_questions.quiz_id', '=', $id)
            ->where('quiz_questions.archieved_status', null)
            ->where('quiz_options.answer', '=', '1')
            ->paginate(5);
       $quiz_id=$id;
        return view('quizhome', compact('quiz','quiz_id'));
    }

    public function generateLink(request $request, $id)
    {

        $host = request()->getHttpHost();
        $url = url('/') . "/participant_register";

        $depts = DB::table('asset_master')
            ->where('id', '=', $id)->value('title');

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
        $data->dept_id = $id;
        $data->slug = $slug;

        if ($data->save()) {
            $new_url = $url . "/" . $slug;
        } else {
            $new_url = "Url is not generated <br> Please try again";
        }

        echo "<h4>" . $new_url . "</h4>";
    }

    public function participantList()
    {
        $participant_list = participator::paginate(5);

        return view('Quiz_participants.participant_list', compact('participant_list'));
    }

    public function audio_req(Request $request)
    {
        $audio_status = $request->audio_req;
        $gene_id = $request->gene_id;
        $link_id = linkGen::where('dept_id', $gene_id)->latest()->value('id');
        $audio_status = linkGen::where('id', $link_id)->value('audio_status');
        if ($audio_status == 'disable') {
            linkGen::where('id', $link_id)->update([
                'audio_status' => 'enable',
            ]);
            return response()->json(['success' => 'true']);
        } else {
            linkGen::where('id', $link_id)->update([
                'audio_status' => 'disable',
            ]);
            return response()->json(['success' => 'false']);
        }
    }
    public function custom_link(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'total_questions' => 'required|numeric|lte:100',
        ]);
        Session::put('title', $request->title);
        Session::put('total_questions', $request->total_questions);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'error' => $validator->messages()]);
        } else {
            return response()->json(['success' => 'true']);
        }
    }

    public function fetch_data(Request $request)
    {
        $title = Session::get('title');
        $total_questions = Session::get('total_questions');
        $department = Department::all();
        $category = Category::where('parent_id', null)->get();
        return view('custom_link', compact('title', 'total_questions', 'department', 'category'));
    }


    public function get_category(Request $request)
    {
        if ($request->deptID == 'all') {
            $categories = Category::select('category_name', 'id')->where('parent_id', null)->get();
            return response()->json(["categories" => $categories]);
        } else {
            $categories = Category::select('category_name', 'id')->where('department_id', $request->deptID)->where('parent_id', null)->get();
            return response()->json(["categories" => $categories]);
        }
    }

    public function get_sub_category(Request $request)
    {
        $categories = Category::select('category_name', 'id')->where('parent_id', $request->cateID)->get();
        return response()->json(["categories" => $categories]);
    }

    public function get_level(Request $request)
    {
        $level = quiz_main::where('category_id', $request->subCateID)->get();
        return response()->json(["level" => $level]);
    }

    public function no_questions(Request $request)
    {
        $Q_count = quiz_main::where('id', $request->q_id)->get();
        return response()->json(["Q_count" => $Q_count]);
    }

    public function add_link(Request $request)
    {
    // dd($request);
        // $this->validate($request, [
        //     'count[]'  => 'required'
        //     ]);



        $last_id = AssetMaster::create([
            'title' => $request->title,
            'total_questions' => $request->total_questions,
            'created_by' => Auth::user()->id,
        ]);
        $department = $request->dept;
        $category = $request->category;
        $sub_category = $request->sub_category;
        $level = $request->level;
        $count = $request->count;
        foreach ($department as $key => $dept) {
            // $data=quiz_main::where('department_id',$department[$key])->where('category_id',$level[$key])->value('id');
            $result = QuizSection::create([
                'asset_master_id' => $last_id->id,
                'quiz_main_id' => $level[$key],
                'no_of_questions' => $count[$key],
            ]);
        }
        if ($result) {
            return redirect('/home');
        }
    }

    public function search_title(Request $request)
    {
        $search = $request->search;
        $quiz_list = AssetMaster::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->paginate(5);

        $department = Department::all();
        $category = Category::select('category_name')->groupBy('category_name')->get();

        return view('quiz_dept', compact('quiz_list', 'department', 'category'));
    }

    // Category Page Filter
    public function category_filter(Request $request)
    {
        $department_where = $request->department_filter;
        $category_where = $request->category_filter;
        $sub_category_where = $request->sub_category_filter;
        $level_where = $request->level_filter;
        $data = Category::where('department_id', $department_where)->where('parent_id', $category_where)->where('id', $sub_category_where)->where('level', $level_where)->get();
    }

    public function get_level_list(Request $request)
    {
        $id = $request->catid;

        $get_level = quiz_main::where("category_id", $id)->pluck('level', 'id')->toArray();
        return response()->json(["get_level" => $get_level]);
    }

    public function get_report(Request $request)
    {
        $id = $request->id;
        $test_id = participator::where('id', $id)->value('department_id');

        $asset = AssetMaster::where('id', $test_id)->get();
        foreach ($asset as $assets) {
            $sections = QuizSection::where('asset_master_id', $assets->id)->get();
            foreach ($sections as $section) {
                $mains = quiz_main::where('id', $section->quiz_main_id)->get();
            }
        }
        $participant = participator::where('id', $id)->with('quiz_main', 'title')->get();
        $result = quiz_participant::where('participant_id', $id)->with('category', 'participator')->get();
        $link_gen = linkGen::where('participant_id', $id)->get();


        foreach ($participant as $key => $value) {
            foreach ($link_gen as $key => $val2) {
                $score = 0;
                $maxscore = 0;
                foreach ($result as $key => $val) {
                    if ($val2->id == $val->linkgen_id) {
                        $score = $score + $val->score;
                        $maxscore = $maxscore + $val->max_score;
                        $res[$val2->id]['id'] = $value->department_id;
                        $res[$val2->id]['name'] = $val->participator->name;
                        $res[$val2->id]['department'] = $value->title->title;
                        $res[$val2->id]['email'] = $val->participator->email;
                        $res[$val2->id]['mobile'] = $val->participator->Phone_no;
                        $res[$val2->id]['start_time'] = $val2->start_time;
                        $res[$val2->id]['score'] = $score;
                        $res[$val2->id]['max_score'] = $maxscore;
                    }
                }
            }
            $live = '';
        }
        $datas = collect($res);
        // $datas = $this->get($myCollectionObj);
        return response()->json(["asset" => $asset, "datas" => $datas]);
    }

    public function view_report(Request $request)
    {
        //id get from linkgen ID
        $id = $request->id;
        $linkgen = linkGen::with('participator')->where('id', $id)->get();
        $dept_id = linkGen::where('id', $id)->value('dept_id');
        $assets = AssetMaster::where('id', $dept_id)->value('id');
        $asset = AssetMaster::where('id', $dept_id)->get();
        $result = quiz_participant::with('category', 'participator')->where('linkgen_id', $id)->get();
        foreach ($linkgen as $linkgenerate) {
            $datetime1 = new DateTime($linkgenerate->start_time); //start time
            $datetime2 = new DateTime($linkgenerate->end_time); //end time
            $interval = $datetime1->diff($datetime2);
            $taken_time = $interval->format('%H hrs %i mins %s sec');
        }
        $score = 0;
        $maxscore = 0;

        foreach ($result as $key => $scores) {
            $score = $score + $scores->score;
            $maxscore = $maxscore + $scores->max_score;
        }
        $sections = QuizSection::with('quiz_main')->where('asset_master_id', $assets)->get();
        foreach ($sections as $key => $section) {
            foreach ($section->quiz_main as $sec) {
                $parent[] = $sec->category->parent_id;
            }
        }
        $parentid = array_unique($parent);
        foreach ($parentid as $parents) {

            $category[] = Category::where('id', $parents)->get()->toArray();
        }
        return view('Quiz_participants.report', compact('asset', 'linkgen', 'score', 'maxscore', 'id', 'sections', 'category', 'taken_time'));
    }

    public function report_download(Request $request)
    {
        //id get from linkgen ID
        $id = $request->id;
         //dd($id);
        $linkgen = linkGen::with('participator')->where('id', $id)->get();
        $dept_id = linkGen::where('id', $id)->value('dept_id');
        $assets = AssetMaster::where('id', $dept_id)->value('id');
        $asset = AssetMaster::where('id', $dept_id)->get();
        $result = quiz_participant::with('category', 'participator')->where('linkgen_id', $id)->get();
        foreach ($linkgen as $linkgenerate) {
            $datetime1 = new DateTime($linkgenerate->start_time); //start time
            $datetime2 = new DateTime($linkgenerate->end_time); //end time
            $interval = $datetime1->diff($datetime2);
            $taken_time = $interval->format('%H hrs %i mins %s sec');
        }
        $score = 0;
        $maxscore = 0;

        foreach ($result as $key => $scores) {
            $score = $score + $scores->score;
            $maxscore = $maxscore + $scores->max_score;
        }
        $sections = QuizSection::with('quiz_main')->where('asset_master_id', $assets)->get();
        foreach ($sections as $key => $section) {
            foreach ($section->quiz_main as $sec) {
                $parent[] = $sec->category->parent_id;
            }
        }
        $parentid = array_unique($parent);
        foreach ($parentid as $parents) {

            $category[] = Category::where('id', $parents)->get()->toArray();
        }

        return view('Quiz_participants.report_download', compact('asset', 'linkgen', 'score', 'maxscore', 'id', 'sections', 'category', 'taken_time'));
    }

    // This codes changes in live server
    public function forceDonwload(Request $request, $id)

    {

        $exe_url = "https://quiztool.colanapps.in/public/report_download/$id";

        $pathToFile = public_path('assets/pdf_test//');

        $name = time() . '.pdf';

        $filename = "assets/pdf_test/" . $name;

        $command = '/usr/bin/wkhtmltopdf --page-width 250 --page-height 300 -B 10 -L 10 -R 10 -T 10 --disable-smart-shrinking ' . $exe_url . ' ' . $filename;
        // $command = '/usr/bin/wkhtmltopdf --page-width 250 --page-height 300 -B 10 -L 10 -R 10 -T 10 --disable-smart-shrinking '.$exe_url.' '.$filename;

        exec($command);


        $headers = ['Content-Type: application/pdf'];


        return response()->download($pathToFile . $name, $name, $headers);
    }

    public function groupmail(Request $request)
    {
        // dd($request->group_email);
        // |ends_with:colanonline.com,colaninfotech.net,colaninfotech.in
        $validator = \Validator::make($request->all(), [
            'group_email' => 'required|ends_with:colanonline.com,colaninfotech.net,colaninfotech.in',
            'groupbtn' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["success" => false, 'errors' => $validator->errors()->all()]);
        } else {

            $id = $request->groupbtn;
            $mail = $request->group_email;

            $section1 = QuizSection::where('asset_master_id',$id)->get();
            $questions = null;
            foreach ($section1  as $key => $section) {
                if ($questions == null) {
                    $questions = quiz_questions::with('options')->where('quiz_id', $section->quiz_main_id)->where('archieved_status', null)->InRandomOrder()->limit($section->no_of_questions);
                } else {
                    $questions2 = quiz_questions::with('options')->where('quiz_id', $section->quiz_main_id)->where('archieved_status', null)->InRandomOrder()->limit($section->no_of_questions);
                    $questions->union($questions2);
                }
            }

            $quiz1 = $questions->get()->toArray();

            foreach ($quiz1 as $key => $question) {
                $ques_id[] = $question['id'];
            }
            $group_id_values = json_encode($ques_id);

            $result = Grouplink::create([
                'group_assetmaster_id' => $id,
                'group_question_id' => $group_id_values,
            ]);

            $mail_split = explode(",", $mail);
            $arr_filter = array_unique($mail_split);

            foreach ($arr_filter as  $mails) {
                $host = request()->getHttpHost();
                $url = url('/') . "/participant_register";

                $depts = DB::table('asset_master')
                    ->where('id', $id)->value('title');

                if (linkGen::whereSlug($slug = str_slug($depts))->exists()) {
                    $original = $slug;
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                    $rand = substr(str_shuffle(str_repeat($pool, 5)), 0, 7);
                    $count = 2;

                    if (linkGen::whereSlug($slug)->exists()) {
                        $slug = "{$original}_" . $count++ . $rand;
                    }
                }

                $data = new linkGen;
                $data->url = $url;
                $data->dept_id = $id;
                $data->slug = $slug;
                $data->group_id =$result['id'];
                $data->email =$mails;

                if ($data->save()) {
                    $new_url = $url . "/" . $slug;
                } else {
                    $new_url = "Url is not generated <br> Please try again";
                }


                $details = [
                    'URL'  => $new_url,
                    'mail' => $mails,
                ];

                \Mail::to($mails)->later(now()->addMinutes(10),new \App\Mail\GroupMail($details));
            }
            return response()->json(["success" => true]);
        }

    }
 public function test_request(Request $request)
 {
  $request_list=Test_request::orderBy('status','asc')->paginate(5);
 // dd($request_list);
 return view('Quiz_participants.test_request_from_skill_tracking',compact('request_list'));

 }
  public function submit_reply(Request $request)
 {
  $request_id=Crypt::decryptstring($request->request_id);
  $msg=$request->reply_msg;
  $user=Test_request::where('id',$request_id)->first();
  $update=Test_request::where('id',$request_id)->update([
  			'status'=>'read'
  ]);
   $details = [
                  'msg' => $msg,
                  'user'=>$user->user_email,
                   'skill'=> $user->skill_name
                ];
   \Mail::to($user->user_email)->send(new \App\Mail\Adminreplymail($details));
  Session::put('message','REPLY MESSAGE SENT SUCCESSFULLY');
 return redirect('/test_request');
 }
    public function clogout()
    {
        Session::flush();
        Auth::logout();
        return redirect('clogin');
    }

	public function quizdelete(Request $request,$id){
    $UpdateDetails = AssetMaster::where('id', $id)->first();
    $UpdateDetails->deleted_at = Carbon::now();
    $UpdateDetails->save();
    return redirect()->back();
    }
 	public function archive_question($dummy,$id)
 	{
    if($dummy==1){
 	quiz_questions::where('quiz_id',$id)
                ->update([
                    'archieved_status'=>'1'
                ]);
 	Session::put('message','Questions Archived Successfully');
    }else{
    quiz_questions::where('quiz_id',$id)
                ->update([
                    'archieved_status'=>null
                ]);
 	Session::put('message','Archived Questions Retreived Successfully');
    }
	return redirect()->back();
 }

}
