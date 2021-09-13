<?php

namespace App\Http\Controllers\Front;

use App\Models\Front;
use App\Models\State;
use App\Models\JobType;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\SocialLink;
use App\Models\Settings;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['jobtype', 'states', 'cities', 'suburb', 'profession', 'specialty']);
        $states = State::where("status", "1")->orderBy('name', 'asc')->get();
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->pluck("jobtype", "id");
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        return view('front.home', compact("jobtypes", "states", "sociallinks", "professions", "settings"));
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
     * @param  \App\Models\Front  $front
     * @return \Illuminate\Http\Response
     */
    public function show(Front $front)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Front  $front
     * @return \Illuminate\Http\Response
     */
    public function edit(Front $front)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Front  $front
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Front $front)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Front  $front
     * @return \Illuminate\Http\Response
     */
    public function destroy(Front $front)
    {
        //
    }
}
