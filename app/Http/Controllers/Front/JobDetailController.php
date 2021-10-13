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
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get(["id", "unique_code", "profession"]);
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get(["id", "unique_code", "specialty"]);
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        $states = State::where("status", "1")->get(["id", "name", "iso2", "latitude", "longitude"]);
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get(["id", "unique_id", "jobtype"]);

        return view('front.jobdetails', compact("sociallinks", "professions", "specialties", "states", "jobtypes", "settings"));
    }



    /**
     * Display the specified resource.
     *
     * @param $slug
     * @param  \App\Models\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function show(JobDetail $jobDetail, Request $request, $slug)
    {

        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get(["id", "unique_code", "profession"]);
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get(["id", "unique_code", "specialty"]);
        $sociallinks = SocialLink::where("status", "1")->first();
        $states = State::where("status", "1")->get(["id", "name", "iso2", "latitude", "longitude"]);
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get(["id", "unique_id", "jobtype"]);
        $settings = Settings::orderBy("created_at", "desc")->first();

        $count = Job::where(["status" => "1", "slug" => $slug])->count();
        if ($count > 0) {
            $job = Job::where(["status" => "1", "slug" => $slug])
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->first();

            return view('front.jobdetails', compact("sociallinks", "professions", "specialties", "states", "job", "jobtypes", "settings"));
        }
        abort("404", "Record not found.");
    }
}
