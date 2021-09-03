<?php

namespace App\Http\Controllers\Front;

use App\Models\Job;
use App\Models\SocialLink;
use App\Models\Profession;
use App\Models\Specialty;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
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
        $states = State::where("status", "1")->get();
        $jobs = Job::where("status", "1")->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")->get();
        return view('front.jobs', compact("sociallinks", "professions", "specialties", "states", "jobs"));
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
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Job $job)
    {

        $jobtype = $request->input("jobtype");
        $state = (int) $request->input("states");
        $city = (int) $request->input("cities");
        $suburb = (int) $request->input("suburb");

        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $states = State::where("status", "1")->get();

        if (!empty($jobtype) && !empty($state) && !empty($city) && !empty($suburb)) {
            $jobs = Job::where(["status" => "1", "job_type" => $jobtype, "state" => $state, "city" => $city, "suburb" => $suburb])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($jobtype) && !empty($state) && !empty($city) && empty($suburb)) {
            $jobs = Job::where(["status" => "1", "job_type" => $jobtype, "state" => $state, "city" => $city])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($jobtype) && !empty($state) && empty($city) && empty($suburb)) {
            $jobs = Job::where(["status" => "1", "job_type" => $jobtype, "state" => $state])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($jobtype) && !empty($state) && empty($city) && empty($suburb)) {
            $jobs = Job::where(["status" => "1", "state" => $state])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } else {
            $jobs = Job::where(["status" => "1", "job_type" => $jobtype])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        }

        return view('front.jobsearch', compact("sociallinks", "professions", "specialties", "states", "jobs"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}
