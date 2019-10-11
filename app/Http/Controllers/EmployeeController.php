<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::all();


        return response()->json([
            'employees' => $employees
        ],200);
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
        $exploded = explode(',',$request->profile_pic);

        $decoded = base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extesion = 'jpg';
        }
        else{
            $extesion = 'png';
        }
        //
        $fileName = str_random().'.'.$extesion;

        $path = public_path().'/images/employees/'.$fileName;

        file_put_contents($path,$decoded);

        $employee = Employee::create(
            [
            'firstname' => $request->firstname,
            'middleinitial' => $request->middleinitial,
            'lastname' => $request->lastname,
            'position' => $request->position,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'city' => $request->city,
            'landmark' => $request->landmark,
            'zip' => $request->zip,
            'profile_pic' => $fileName,
            ]
        );

        $schedule = Schedule::create(['user_id' => $employee['id'],'start_time' => $request->start_time ,'end_time' => $request->end_time]);

        $directory =  public_path() . '/public/images/models/' . $employee->employee_id . '-' . $employee->firstname;

        File::makeDirectory($directory,0777,true);

        $images = $request->images;

        $i = 1;
        foreach ($images as $img) {
            // code
            $exploded = explode(',',$img);

            $decoded = base64_decode($exploded[1]);

            if(str_contains($exploded[0],'jpeg')){
                $extesion = 'jpg';
            }
            else{
                $extesion = 'png';
            }
            //
            $fileName = $i.'.'.$extesion;

            $path = $directory . '/' . $fileName;
            
            file_put_contents($path,$decoded);

            $i++;
        }


        return response()->json([
            'employee' => $employee,
            'schedule' => $employee->id
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee_id)
    {
        //
        $employee = Employee::find($employee_id)->delete();

        return response()->json([
            'employee' => $employee
        ],200);

    }
}
