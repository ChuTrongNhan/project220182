<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return DB::select('select * from users');
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
        DB::insert('insert into users (id, username, password, email, type, code) values (?, ?, ?, ?, ?, ?)',
                    [$request->input('id'), $request->input('username'), $request->input('password'), $request->input('email'), $request->input('type'), 'N']);
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
        return DB::select('select * from users where id=?',[$id]);
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
        $r_name = $request->input('name');
        $r_password = $request->input('password');
        $r_code = $request->input('code');
        $r_email = $request->input('email');

        if ($r_name !== '_')
                DB::update('update users set username = ? where users.id = ?', [$r_name, $id]);

        if ($r_password !== '_')
                DB::update('update users set password = ? where users.id = ?', [$r_password, $id]);

        if ($r_email !== '_')
                DB::update('update users set email = ? where users.id = ?', [$r_email, $id]);

        if ($r_code !== '_')
                DB::update('update users set code = ? where users.id = ?', [$r_code, $id]);

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
}
