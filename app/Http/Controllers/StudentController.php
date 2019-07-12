<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        DB::insert('insert into students (student_id, student_name, student_birthday, student_address, student_phone, student_major, student_status) values (?, ?, ?, ?, ?, ?, ?)',
                    [$request->input('id'), $request->input('name'), $request->input('birthday'), $request->input('address'), $request->input('phone'), $request->input('student_major'), $request->input('student_status')]);
        return response([
            'result' => 'success'
        ], 200);
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
        return DB::select('select * from students where student_id = ?', [$id]);
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
        $r_phone = $request->input('phone');
        DB::update('update students set student_phone = ? where students.student_id = ?', [$r_phone, $id]);
        return response([
            'result' => 'success'
        ], 200);
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

    public function get($code)
    {
        $result = DB::select('select * from users where code = ?', [$code]);
        if (count($result) == 0) return view('not-found-page');
        $result = DB::select('select * from students where student_id = ?', [$result[0]->id]);
        if (count($result) == 0) return view('not-found-user');
        $data = array(
            'studentId' => $result[0]->student_id,
            'studentName' => $result[0]->student_name,
        );
        return view('student.home')->with($data);;
    }
}
