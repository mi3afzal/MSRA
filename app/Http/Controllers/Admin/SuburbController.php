<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use App\Models\City;
use App\Models\Suburb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SuburbController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function show(Suburb $suburb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function edit(Suburb $suburb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suburb $suburb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suburb $suburb)
    {
        //
    }
}
