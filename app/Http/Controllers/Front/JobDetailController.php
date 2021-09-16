<?php

namespace App\Http\Controllers\Front;

use App\Models\Settings;
use App\Models\Job;
use App\Models\JobDetail;
use App\Models\JobType;
use App\Models\SocialLink;
use App\Models\Profession;
use App\Models\Specialty;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class JobDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        $states = State::where("status", "1")->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();

        return view('front.jobdetails', compact("sociallinks", "professions", "specialties", "states", "jobtypes", "settings"));
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
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function show(JobDetail $jobDetail, Request $request, $slug)
    {

        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $states = State::where("status", "1")->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
        $settings = Settings::orderBy("created_at", "desc")->first();

        $job = Job::where(["status" => "1", "slug" => $slug])
            ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            ->first();

        return view('front.jobdetails', compact("sociallinks", "professions", "specialties", "states", "job", "jobtypes", "settings"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(JobDetail $jobDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobDetail $jobDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobDetail $jobDetail)
    {
        //
    }
}
