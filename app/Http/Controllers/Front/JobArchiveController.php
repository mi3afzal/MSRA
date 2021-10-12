<?php

namespace App\Http\Controllers\Front;

use App\Models\Job;
use App\Models\JobType;
use App\Models\SocialLink;
use App\Models\Profession;
use App\Models\Specialty;
use App\Models\State;
use App\Models\JobArchive;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobArchive = new JobArchive;
        $jobArchive->setConnection('mysql2');
        $jobarchives = JobArchive::orderBy("id", "desc")->with("associatedJobtype", "associatedProfession", "associatedSeniority", "associatedSpeciality", "associatedState", "associatedCity", "associatedCountry")->paginate(10);
        $jobarchivecount = JobArchive::orderBy("id", "desc")->count();
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        $states = State::where("status", "1")->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();

        return view('front.jobarchive', compact("jobtypes", "jobarchives", "settings", "professions", "specialties", "sociallinks", "states"));
    }



    /**
     * Display the specified resource.
     * 
     * @param $slug
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobArchive  $jobArchive
     * @return \Illuminate\Http\Response
     */
    public function show(JobArchive $jobArchive, Request $request, $slug)
    {
        $jobArchive = new JobArchive;
        $jobArchive->setConnection('mysql2');
        $settings = Settings::orderBy("created_at", "desc")->first();
        $sociallinks = SocialLink::where("status", "1")->first();
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        $states = State::where("status", "1")->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
        $jobdetail = JobArchive::orderBy("id", "desc")->where("slug", $slug)->with("associatedJobtype", "associatedProfession", "associatedSeniority", "associatedSpeciality", "associatedState", "associatedCity", "associatedCountry")->first();
        return view('front.jobarchivedetail', compact("jobdetail", "jobtypes", "states", "specialties", "professions", "settings", "sociallinks"));
    }
}
