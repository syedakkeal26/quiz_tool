<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\quiz_main;
use App\Models\Category;
use DB;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Str;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department=Department::paginate(5);

        // dd($quiz_main);
        return view('department.department_list', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.create_department');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->department_name);
        $storeData = $request->validate([
            'department_name' => 'required|max:255',
        ]);

        $department_name=$request->department_name;

        // dd($department_name);
        if(!Department::where('department_name',$department_name)->exists()){
            $departmentId=Department::create([
                'department_name' =>$department_name,
            ]);

            return redirect('/department')->with('success', 'Department created successfully!');

        }
        else
        {

            return redirect('/department')->with('warning', 'Department Already Exists' );
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department, $id)
    {
        //
    }
    public function edit($id)
    {
        // dd($id);
        $department=Department::where('id',$id)->first();
        // dd($department);
        return view('department.edit_department',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateData = $request->validate([
            'department_name' => 'required',
        ]);

        $department_name=$request->department_name;

        $update_department=Department::where('id',$id)->first();

        if(!Department::where('department_name',$department_name)->where('id','!=',$id)->exists()){


            $update_department->update([
                'department_name' => $department_name,
            ]);

            return redirect('/department')->with('success', 'Department Updated successfully');


        }
        else
        {
           return redirect('/department')->with('warning','Department Already Exists');

        }
        // dd('success');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // dd($id);
         // dd($delete);
         if(!quiz_main::where('department_id',$id)->exists())
         {
            $delete=Department::where('id',$id)->delete();
            return redirect('/department')->with('success', 'Record has been deleted successfully');

         }
         else
         {
            return redirect()->back()->with('warning','Cannot delete!.. Department in use');
        }
    }


}
