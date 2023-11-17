<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\quiz_main;
use App\Models\Category;
use DB;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $get_level =quiz_main::where("category_id",$id)->pluck('level');
        $category=Category::with('department')->paginate(5);
        $department=Department::all();
        $parent_category=Category::where('parent_id',null)->get();
        $sub_category=Category::where('parent_id','!=',null)->get();
        return view('category.category_list', compact('category','parent_category','department','sub_category'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_category=Category::where('parent_id',null)->get();
        $department=Department::all();
        return view('category.create_category', compact('department','parent_category'));
    }

    public function store(Request $request)
    {
        // dd($request->category_name,$request->level,$request->department_name);

        $storeData = $request->validate([
            'category_name' => 'required|max:255',
            'department' => 'required',

        ]);

        $department_id=$request->department;
        $category_name=$request->category_name;
        $parent=$request->parent_name;
        // if($parent){
        //     $category_name=Strtolower($request->parent);
        // }
        $level=$request->level;

        if(Category::where('department_id',$department_id)->where('category_name',$category_name)->exists())
        {
            return redirect('/category')->with('warning','Category Already Exists');
        }
        else
        {
            $category = Category::create([
                'category_name' => $category_name,
                'parent_id'=>$parent,
                'department_id' => $department_id,

        ]);
            return redirect('/category')->with('success', 'Category has been Created!');

        }

    }

    public function show(Department $department, $id)
    {
        //
    }
    public function edit($id)
    {
        // dd($id);
        $parent_category=Category::where('parent_id',null)->get();
        $category=Category::where('id',$id)->first();
        $department=Department::all();
        // dd($department);
        return view('category.edit_category',compact('category','department','parent_category'));
    }

    public function update(Request $request, $id)
    {
        $updateData = $request->validate([
            'department_id' => 'required',
        ]);

        $category_name=$request->category_name;
        $sub_category_name=$request->subcategory_name;
        $department_id=$request->department_id;
        if($sub_category_name){
            $result=Category::where('department_id',$department_id)->where('category_name',$sub_category_name)->value('parent_id');
            if(!$result)
            {
                $update_category=Category::where('id',$id)->first();
                $update_category->update([
                    'category_name' => $sub_category_name,
                    'department_id' => $department_id,
                ]);
            return redirect('/category')->with('success', 'Sub Category updated successfully');
            }else{
                return redirect('/category')->with('warning','Sub Category already exists');
            }
        }else{
            if(!Category::where('department_id',$department_id)->where('category_name',$category_name)->where('id','!=',$id)->exists())
            {
                $update_category=Category::where('id',$id)->first();
                $update_category->update([
                    'category_name' => $category_name,
                    'department_id' => $department_id,
                ]);
            return redirect('/category')->with('success', 'Category updated successfully');
            }else{
                return redirect('/category')->with('warning','Category already exists');
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //  dd($id);
        //  dd($delete);
        //  $category_ques="";
        $category_ques=quiz_main::where('category_id',$id)->value('max_number_questions');
         $result=Category::where('parent_id',$id)->get();
         if($result){

            foreach ($result as $results) {
                $id=$results->id;
                $category_ques=quiz_main::where('category_id',$id)->value('max_number_questions');

            }
        }
            // dd($category_ques);
            // exit;
         if($category_ques==0)
         {
            $delete=Category::where('id',$id)->delete();
            $del_quiz_main=quiz_main::where('category_id',$id)->delete();
            return redirect('/category')->with('success', 'Record has been deleted successfully');

         }
         else if(!quiz_main::where('category_id',$id)->exists())
         {
            $delete=Category::where('id',$id)->delete();
            return redirect('/category')->with('success', 'Record has been deleted successfully');

         }
         else
         {
            return redirect()->back()->with('warning','Cannot delete!.. Category in use');
        }
    }
// Category Page Filter
    public function category_filter(Request $request)
    {
        $query = Category::query();
        $department_where=$request->department_filter;
        $category_where=$request->category_filter;
        $sub_category_where=$request->sub_category_filter;
        if($department_where!=null){
            $query->where('department_id',$department_where);
        }
        if($category_where!=null){
            $query->where('parent_id',$category_where)->Orwhere('id',$category_where);
        }
        if($sub_category_where!=null){
            $query->where('id',$sub_category_where);
        }
        $category=$query->paginate(5);
        $department=Department::all();
        $parent_category=Category::where('parent_id',null)->get();
        $sub_category=Category::where('parent_id','!=',null)->get();
        return view('category.category_list', compact('category','parent_category','department','sub_category'));
    }
}
