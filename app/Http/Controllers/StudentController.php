<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Foundation\Console\StubPublishCommand;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::all("id","chName","enName", "phone");

        // return Student::where('enName', 'like', '%Lynn%')->get();
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
        
        $student = $request->validate([
            'chineseName' => 'required|min:2',
            'englishName' => 'required|min:3',
            'birth' => 'required|date_format:Y-m-d|after:2000-01-01',
            'phone' => 'required|size:10|regex:/^09[0-9]{8}$/',
            'address' => 'required|min:10',
        ]);

        Student::factory()->state([
            'chName' => $student['chineseName'],
            'enName' => $student['englishName'],
            'birth' => $student['birth'],
            'phone' => $student['phone'],
            'address' => $student['address'],
        ])->create();

        return response("",204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $student = Student::findOrFail($id);
       
        return $student;
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
        //

        $data = $request->validate([
            'chName' => 'required|min:2',
            'enName' => 'required|min:3',
            'phone' => 'required|size:10|regex:/^09[0-9]{8}$/',
            'address' => 'required|min:10'
        ]);

        Student::findOrFail($id)->update($data);

        return response("",204);
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
