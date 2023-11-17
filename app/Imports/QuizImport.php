<?php

namespace App\Imports;

use App\Models\Quiz;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\quiz_main;
use App\Models\quiz_questions;
use App\Models\quiz_options;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isNull;

class QuizImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows = $rows->filter(function($rows){
            return $rows[0] != null && $rows[1] != null && $rows[2] != null && $rows[3] != null && $rows[4] != null && $rows[5] != null && $rows[6] != null && $rows[7] != null && $rows[8] != null && $rows[9] != null;
        })->values();

        $current_array = $new_array = array();
        foreach ($rows as $key => $row) {

            echo "<pre>";
            // Skip title row in excell sheet
            if ($row[0]=="title") {
                 continue;
            }
          $current_array[$row[0]][] = $row;
        }

        foreach ($current_array as $depnamekey => $row1)
        {
            // Get Items count from Excel sheet for MAX TOTAL QUESTIONS count
            $no_of_question = count($row1);

            for ($i=0; $i < $no_of_question; $i++) {
                 // Create Department title to department table
                $departmentId =Department::where('department_name',$depnamekey)->first();
                if(!Department::where('department_name',$depnamekey)->exists()){
                    $departmentId=Department::create([
                        'department_name' =>$depnamekey,
                    ]);
                }

                // Create Category and Level to Category table
                $categoryId=null;
                if(!Category::where('category_name',$row1[$i][1])
                             ->where('department_id',$departmentId->id)->exists())
                {
                    $categoryId=Category::create([
                        'category_name' => $row1[$i][1],
                        'department_id' =>$departmentId->id,

                    ]);
                }else{
                 $categoryId=Category::where('category_name',$row1[$i][1])
                                    ->where('department_id',$departmentId->id)
                                    ->first();
                }

                if(!Category::where('category_name',$row1[$i][2])
                            ->where('department_id',$departmentId->id)
                            ->where('parent_id',$categoryId->id)->exists())
                {
                    $subcategoryId=Category::create([
                        'category_name' => $row1[$i][2],
                        'department_id' =>$departmentId->id,
                        'parent_id' =>$categoryId->id,
                   ]);

                }else{
                    $subcategoryId=Category::where('category_name',$row1[$i][2])
                                            ->where('department_id',$departmentId->id)
                                           ->first();
                }

                // Master table (DASHBOARD TABEL IN FRONTEND)
                $quizId=quiz_main::where('department_id',$subcategoryId->department_id)
                                     ->where('category_id',$subcategoryId->id)
                                     ->where('level',$row1[$i][3])
                                     ->first();

                if(!quiz_main::where('department_id',$subcategoryId->department_id)
                ->where('category_id',$subcategoryId->id)
                ->where('level',$row1[$i][3])
                ->exists()){

                // calculate max_number_questions and max_score for quiz_main table
                $max_number_questions=1;
                $max_score=$row1[$i][4];

                // create new data in quiz_main
                $quizId = quiz_main::create([
                        'department_id' => $departmentId->id,
                        'max_number_questions' => $max_number_questions,
                        'max_score' => $max_score,
                        'category_id' => $subcategoryId->id,
                        'level' => $row1[$i][3],
                        'user_id' => Auth::user()->id,
                    ]);
                }else{
                    // This filter is used for getting total quesions(MAX_NO_OF_QUESION)
                    $max_score=$row1[$i][4];
                    $no_of_question2 =  $quizId->max_number_questions+1;
                    $max_score1 = $max_score + $quizId->max_score;
                    $quizId->update([
                        'max_number_questions' => $no_of_question2,
                        'max_score' => $max_score1,
                    ]);
                }
            // }
                // This value get from Quiz_main table and send to quiz_question table(calculation for Questions and score)
                $max_ques=$quizId->max_number_questions;
                $max_mark=$quizId->max_score;

                $questionId= quiz_questions::where('question',$row1[$i][5])->first();

                if(!quiz_questions::where('question',$row1[$i][5])->exists())
                {
                    // Create question in quiz_question table
                    $questionId = quiz_questions::create([
                        'question' => $row1[$i][5],
                        'score' => $row1[$i][4],
                        'category_id' => $subcategoryId->id,
                        'quiz_id' => $quizId->id,
                         ]);

                        // Check correct answer from option(correct answer=1,other options=0)
                        $row11=count($row1[$i]);
                        for ($k=6; $k < $row11; $k++) {



                            if($row1[$i][9]==$rows[0][$k]) {

                                    $answer = "1";
                            }
                            else{
                                $answer = "0";

                            }

                            //Create Options and answers in quiz_options table
                            if ($k!=$row11-1) {
                                quiz_options::create([
                                    'option' => $row1[$i][$k],
                                    'answer' => $answer,
                                    'question_id' => $questionId->id,
                                ]);
                            }
                        }
                }else{
                    // Repeated question only are stored in seesion to show in Import page.
                    $skip[]=$questionId->question;
                    Session::put('skip', $skip);
                    $mark=$questionId->score;
                    $count_ques=count(array($questionId->question));

                    // Skipped repeated questions counts are reduced in quiz_main table
                    $quizId->update([
                        'max_number_questions' =>  $max_ques - $count_ques,
                        'max_score' => $max_mark - $mark,
                    ]);
                }
        }
    }

}
}

