<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
class EmployeeController extends Controller
{
    public function index(){
        
        $employees = Employee::orderBy('id','DESC')->paginate(5);

        return view('employee.list',['employees' => $employees]);
     }

     public function create(){
        return view('employee.create');

    }

    public function store(Request $request){
        $validator  = Validator::make($request->all(),[
            'name'  => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg'
        ]);

       if ($validator->passes()){
        // save data here
               $employee = new Employee();
               $employee->name = $request->name;
               $employee->email = $request->email;
               $employee->address = $request->address;
               $employee->save();

        if ($request->image) {
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/employees/',$newFileName); // This will save file in a folder
                
                $employee->image = $newFileName;
                $employee->save();
                $request->session()->flash('success','Employee created successfully');
                return redirect()->route('employees.index');
            }
      
             
    }else {
        // return with errors
        return redirect()->route('employees.create')->withErrors($validator)->withInput();
            }
    }

   
    public function edit(Employee $employee) {
        //$employee = Employee::findOrFail($id);       
        return view('employee.edit',['employee' => $employee]);
}

public function update(Request $request, $employee) {
    $validator  = Validator::make($request->all(),[
        'name'  => 'required',
        'email' => 'required',
        'image' => 'sometimes|image:gif,png,jpeg,jpg'
    ]);

   if ($validator->passes()){
    // save data here
           $employee = Employee::find($employee);
           $employee->name = $request->name;
           $employee->email = $request->email;
           $employee->address = $request->address;
           $employee->save();

    if ($request->image) {
            $ext = $request->image->getClientOriginalExtension();
            $newFileName = time().'.'.$ext;
            $request->image->move(public_path().'/uploads/employees/',$newFileName); // This will save file in a folder
            
            $employee->image = $newFileName;
            $employee->save();
        }
        return redirect()->route('employees.index');
}else {
    // return with errors
    return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
}




public function destroy($id, Request $request ){
                     
    $employee = Employee::find($id);
    File::delete(public_path().'/uploads/employees/'.$employee->image);
    $employee->delete();        
    return redirect()->back()->with('success','Employee deleted successfully.');

}

}