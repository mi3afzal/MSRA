<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\JobType;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\Profession;
use App\Models\Specialty;
use App\Models\State;
use App\Models\City;
use App\Models\Suburb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lists()
    {
        $title = "job lists";
        $module = "job";
        $jobtypes = JobType::where("status", "1")->get();
        $jobcategories = JobCategory::where("status", "1")->get();
        $medicalcenters = User::where(["status" => "1", "role" => 3])->get();
        $professions = Profession::where("status", "1")->get();
        $specialities = Specialty::where("status", "1")->get();
        $states = State::where("status", "1")->get();
        $data = Job::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.job.index', compact('data', 'title', 'module', "jobtypes", "jobcategories", "medicalcenters", "professions", "specialities", "states"));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(Job::query())->make(true);

        $jobdata = Job::select('jobs.id', 'jobs.job_type', 'jobs.job_category', 'jobs.medical_center', 'jobs.profession', 'jobs.speciality', 'jobs.state', 'jobs.status', 'jobs.created_at', 'jobs.updated_at')->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState");
        return Datatables::of($jobdata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('jobtype') && $request->get('jobtype') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.job_type', 'like', "%{$request->get('jobtype')}%");
                    });
                }

                if ($request->has('jobcategory') && $request->get('jobcategory') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.job_category', 'like', "%{$request->get('jobcategory')}%");
                    });
                }

                if ($request->has('medicalcenter') && $request->get('medicalcenter') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.medical_center', 'like', "%{$request->get('medicalcenter')}%");
                    });
                }
                if ($request->has('profession') && $request->get('profession') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.profession', 'like', "%{$request->get('profession')}%");
                    });
                }
                if ($request->has('speciality') && $request->get('speciality') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.speciality', 'like', "%{$request->get('speciality')}%");
                    });
                }
                if ($request->has('state') && $request->get('state') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('jobs.state', 'like', "%{$request->get('state')}%");
                    });
                }
            })
            ->addColumn('jobtype', function ($jobdata) {
                return $jobtype = ucwords($jobdata->associatedJobtype->jobtype);
            })
            ->addColumn('jobcategory', function ($jobdata) {
                return $jobcategory = ucwords($jobdata->jobcategory->name);
            })
            ->addColumn('medicalcenter', function ($jobdata) {
                return $medicalcenter = ucwords($jobdata->medicalcenter->name);
            })
            ->addColumn('profession', function ($jobdata) {
                return $profession = ucwords($jobdata->associatedProfession->profession);
            })
            ->addColumn('speciality', function ($jobdata) {
                return $speciality = ucwords($jobdata->associatedSpeciality->specialty);
            })
            ->addColumn('state', function ($jobdata) {
                return $state = ucwords($jobdata->associatedState->name);
            })
            ->addColumn('created_at', function ($jobdata) {
                return $created_at = date("F j, Y, g:i a", strtotime($jobdata->created_at));
            })
            ->addColumn('status', function ($jobdata) {
                return $status = ($jobdata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($jobdata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('job.delete', $jobdata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the job?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.job.enable', $jobdata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.job.disable', $jobdata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $detailslink = '
                    <div class="btn-group">
                        <a href="' . route('admin.job.show', $jobdata->id) . '" class="btn btn-sm btn-primary" title="View Details" ><i class="fas fa-eye"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    $final = ($jobdata->status == 1) ? $link . $inactivelink . $detailslink : $link . $activelink . $detailslink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            You are not an admin.
                        </span>
                    ';
                }

                return $final;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "create a job";
        $module = "job";
        $jobtypes = JobType::where("status", "1")->get();
        $jobcategories = JobCategory::where("status", "1")->get();
        $medicalcenters = User::where(["status" => "1", "role" => 3])->get();
        $professions = Profession::where("status", "1")->get();
        $specialities = Specialty::where("status", "1")->get();
        $states = State::where("status", "1")->get();
        // $cities = City::where("status", "1")->get();
        // $suburbs = Suburb::where("status", "1")->get();
        return view('admin.job.add', compact('title', 'module', "jobtypes", "jobcategories", "medicalcenters", "professions", "specialities", "states"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'job_type' => 'required',
                'job_category' => 'required',
                'medical_center' => 'required',
                'profession' => 'required',
                'speciality' => 'required',
                'state' => 'required',
                'city' => 'required',
                'suburb' => 'required',
                'rate' => 'required',
                'work_days' => 'required',
                'title' => 'required|max:500|unique:jobs',
                'from_date' => 'required',
                'to_date' => 'required',
                'address' => 'required|max:500',
                'description' => 'required',
                'practice_offer' => 'required',
                'essential_criteria' => 'required',
            ]
        );

        $job = new Job;
        $job->job_type = $request->input('job_type');
        $job->job_category = $request->input('job_category');
        $job->medical_center = $request->input('medical_center');
        $job->profession = $request->input('profession');
        $job->speciality = $request->input('speciality');
        $job->state = $request->input('state');
        $job->city = $request->input('city');
        $job->suburb = $request->input('suburb');
        $job->rate = $request->input('rate');
        $job->work_days = $request->input('work_days');
        $job->title = $request->input('title');
        $job->slug = $request->input('title');
        $job->from_date = $request->input('from_date');
        $job->to_date = $request->input('to_date');
        $job->address = $request->input('address');
        $job->description = $request->input('description');
        $job->practice_offer = $request->input('practice_offer');
        $job->essential_criteria = $request->input('essential_criteria');
        $job->user_id = Auth::user()->id;
        $job->save();

        $str = "JBPST";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $job->id;

        $job->unique_code = $uid;
        $job->save();

        return redirect()->route('admin.job.list')->with('success', 'Job created added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Job $job, $id)
    {
        $title = "Job Details";
        $module = "job";
        $job = Job::where(["status" => "1", "id" => $id])->with("createdby", "associatedJobtype", "jobcategory", "medicalcenter", "associatedProfession", "associatedSpeciality", "associatedState", "associatedCity", "associatedSuburb")->first();
        return view('admin.job.show', compact('title', 'module', 'job'));
    }

    /**
     * Enable the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Job $job, $id)
    {
        $job = Job::findOrFail($id);
        $job->status = "1";
        $job->save();
        return redirect()->route('admin.job.list')->with('success', 'Job enabled.');
    }

    /**
     * Disable the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Job $job, $id)
    {
        $job = Job::findOrFail($id);
        $job->status = "0";
        $job->save();
        return redirect()->route('admin.job.list')->with('warning', 'Job disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job, $id)
    {
        // $job = Job::where('id', $id)->withTrashed()->first();

        $job = Job::findOrFail($id);
        $job->delete();

        // Shows the remaining list of jobs.
        return redirect()->route('admin.job.list')->with('error', 'Job deleted successfully.');
    }
}