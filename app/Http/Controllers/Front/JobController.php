<?php

namespace App\Http\Controllers\Front;

use App\Models\Job;
use App\Models\JobType;
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
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
        $jobs = Job::where("status", "1")->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")->get();
        return view('front.jobs', compact("jobtypes", "sociallinks", "professions", "specialties", "states", "jobs"));
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
        $jobtype = (int) $request->input("jobtype");
        $state = (int) $request->input("states");
        $city = (int) $request->input("cities");
        $suburb = (int) $request->input("suburb");
        $profession = (int) $request->input("profession");
        $specialty = (int) $request->input("specialty");


        if (!empty($jobtype)) {
            $request->session()->put('jobtype', $jobtype);
        }

        if (!empty($state)) {
            $request->session()->put('states', $state);
        }

        if (!empty($city)) {
            $request->session()->put('cities', $city);
        }

        if (!empty($suburb)) {
            $request->session()->put('suburb', $suburb);
        }

        if (!empty($profession)) {
            $request->session()->put('profession', $profession);
        }

        if (!empty($specialty)) {
            $request->session()->put('specialty', $specialty);
        }

        $data = $request->session()->all();

        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $states = State::where("status", "1")->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();

        if (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && !empty($request->session()->get('cities')) && !empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states'),
                    "city" => $request->session()->get('cities'),
                    "suburb" => $request->session()->get('suburb')
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && !empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states'),
                    "city" => $request->session()->get('cities')
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states')
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "state" => $request->session()->get('states')
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states'),
                    "profession" => $request->session()->get('profession'),
                    "speciality" => $request->session()->get('specialty'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "state" => $request->session()->get('states'),
                    "profession" => $request->session()->get('profession'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "state" => $request->session()->get('states'),
                    "profession" => $request->session()->get('profession'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "profession" => $request->session()->get('profession'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "profession" => $request->session()->get('profession'),
                    "speciality" => $request->session()->get('specialty'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype'),
                    "speciality" => $request->session()->get('specialty'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "state" => $request->session()->get('states'),
                    "speciality" => $request->session()->get('specialty'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "profession" => $request->session()->get('profession'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } elseif (empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "speciality" => $request->session()->get('specialty'),
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        } else {
            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $request->session()->get('jobtype')
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();
        }

        return view('front.jobsearch', compact("sociallinks", "professions", "specialties", "states", "jobs", "jobtypes"));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function filterjobs(Request $request, Job $job)
    {

        if ($request->ajax()) {
            if ($_POST['name'] == "jobtype") {
                $jobtype = isset($_POST["name"]) ? (int) $_POST["name"] : "";
                $profession = "";
                $specialty = "";
                $state = "";
            } else if ($_POST['name'] == "profession") {
                $profession = isset($_POST["name"]) ? (int) $_POST["name"] : "";
                $specialty = "";
                $state = "";
                $jobtype = "";
            } else if ($_POST['name'] == "specialty") {
                $specialty = isset($_POST["name"]) ? (int) $_POST["name"] : "";
                $state = "";
                $jobtype = "";
                $profession = "";
            } else if ($_POST['name'] == "state") {
                $state = isset($_POST["name"]) ? (int) $_POST["name"] : "";
                $jobtype = "";
                $profession = "";
                $specialty = "";
            }

            // if (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && !empty($request->session()->get('cities')) && !empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states'),
            //             "city" => $request->session()->get('cities'),
            //             "suburb" => $request->session()->get('suburb')
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && !empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states'),
            //             "city" => $request->session()->get('cities')
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states')
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "state" => $request->session()->get('states')
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states'),
            //             "profession" => $request->session()->get('profession'),
            //             "speciality" => $request->session()->get('specialty'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "state" => $request->session()->get('states'),
            //             "profession" => $request->session()->get('profession'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "state" => $request->session()->get('states'),
            //             "profession" => $request->session()->get('profession'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "profession" => $request->session()->get('profession'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "profession" => $request->session()->get('profession'),
            //             "speciality" => $request->session()->get('specialty'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (!empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype'),
            //             "speciality" => $request->session()->get('specialty'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (empty($request->session()->get('jobtype')) && !empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "state" => $request->session()->get('states'),
            //             "speciality" => $request->session()->get('specialty'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && !empty($request->session()->get('profession')) && empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "profession" => $request->session()->get('profession'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } elseif (empty($request->session()->get('jobtype')) && empty($request->session()->get('states')) && empty($request->session()->get('cities')) && empty($request->session()->get('suburb')) && empty($request->session()->get('profession')) && !empty($request->session()->get('specialty'))) {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "speciality" => $request->session()->get('specialty'),
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // } else {
            //     $jobs = Job::where(
            //         [
            //             "status" => "1",
            //             "job_type" => $request->session()->get('jobtype')
            //         ]
            //     )
            //         ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
            //         ->get();
            // }

            $jobs = Job::where(
                [
                    "status" => "1",
                    "job_type" => $jobtype,
                    "state" => $state,
                    "speciality" => $specialty,
                    "profession" => $profession
                ]
            )
                ->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")
                ->get();

            return view('ajax.joblisting', compact("jobs"));
        }
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
    public function clearsearch(Request $request, Job $job)
    {
        $request->session()->forget('jobtype');
        $request->session()->forget('states');
        $request->session()->forget('cities');
        $request->session()->forget('suburb');
        $request->session()->forget('profession');
        $request->session()->forget('specialty');
        return redirect()->route('job');
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
