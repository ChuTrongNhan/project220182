<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class TeacherController extends Controller
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
        DB::insert('insert into teachers
        (teacher_id, teacher_name, teacher_birthday, teacher_address, teacher_phone) values (?, ?, ?, ?, ?)',
        [$request->input('id'), $request->input('name'), $request->input('birthday'), $request->input('address'),  $request->input('phone'),]);
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
        return DB::select('select * from teachers where teacher_id=?',[$id]);
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
        DB::update('update teachers set teacher_phone = ? where teachers.teacher_id = ?', [$r_phone, $id]);
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
        $result = DB::select('select * from teachers where teacher_id = ?', [$result[0]->id]);
        if (count($result) == 0) return view('not-found-user');
        $data = array(
            'teacherId' => $result[0]->teacher_id,
            'teacherName' => $result[0]->teacher_name,
        );
        return view('teacher.home')->with($data);;
    }
}
