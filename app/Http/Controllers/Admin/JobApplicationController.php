<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobApplication;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class JobApplicationController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lists()
    {
        $title = "job application lists";
        $module = "jobapplication";
        $jobtypes = JobType::where("status", "1")->get();
        $jobcategories = JobCategory::where("status", "1")->get();
        $medicalcenters = User::where(["status" => "1", "role" => 3])->get();
        $professions = Profession::where("status", "1")->get();
        $specialities = Specialty::where("status", "1")->get();
        $states = State::where("status", "1")->get();
        // $cities = City::where("status", "1")->get();
        // $suburbs = Suburb::where("status", "1")->get();
        return view('admin.jobapplications.index', compact("jobtypes", "title", "module"));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(JobApplication::query())->make(true);

        $jobapplicationdata = JobApplication::select('job_applications.id', 'job_applications.unique_code', 'job_applications.job_id', 'job_applications.job_type', 'job_applications.email', 'job_applications.message', 'job_applications.cv', 'job_applications.status', 'job_applications.quickapply', 'job_applications.created_at', 'job_applications.updated_at')->with("createdby", "jobtypedetails");
        return Datatables::of($jobapplicationdata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_applications.status', 'like', $request->get('status'));
                    });
                }

                if ($request->has('jobtype') && $request->get('jobtype') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_applications.job_type', '=', $request->get('jobtype'));
                    });
                }

                if ($request->has('jobapplication') && $request->get('jobapplication') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_applications.quickapply', '=', $request->get('jobapplication'));
                    });
                }
            })
            ->addColumn('jobtype', function ($jobapplicationdata) {
                return $jobtype = ucwords($jobapplicationdata->jobtypedetails->jobtype);
            })
            ->addColumn('email', function ($jobapplicationdata) {
                return $email = ucwords($jobapplicationdata->email);
            })
            ->addColumn('cv', function ($jobapplicationdata) {
                return $cv = ucwords($jobapplicationdata->cv);
            })
            ->addColumn('created_at', function ($jobapplicationdata) {
                return $created_at = date("F j, Y, g:i a", strtotime($jobapplicationdata->created_at));
            })
            ->addColumn('status', function ($jobapplicationdata) {
                return $status = ($jobapplicationdata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('quickapply', function ($jobapplicationdata) {
                return $quickapply = ($jobapplicationdata->quickapply == 1) ? 'YES' : 'NO';
            })
            ->addColumn('action', function ($jobapplicationdata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('jobapplication.delete', $jobapplicationdata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete this entry?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobapplication.enable', $jobapplicationdata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobapplication.disable', $jobapplicationdata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $detailslink = '
                    <div class="btn-group">
                        <a href="' . route('admin.jobapplication.show', $jobapplicationdata->id) . '" class="btn btn-sm btn-primary" title="View Details" ><i class="fas fa-eye"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    $final = ($jobapplicationdata->status == 1) ? $link . $inactivelink . $detailslink : $link . $activelink . $detailslink;

                    // if ($jobapplicationdata->quickapply != 1) {
                    //     $final = ($jobapplicationdata->status == 1) ? $link . $inactivelink . $detailslink : $link . $activelink . $detailslink;
                    // } else {
                    //     $final = ($jobapplicationdata->status == 1) ? $link . $inactivelink : $link . $activelink;
                    // }
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
     * Display the specified resource.
     *
     * @param  \App\Models\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function show(JobApplication $jobApplication, $id)
    {
        $title = "job application detail";
        $module = "jobapplication";
        $jobapplication = JobApplication::where('id', $id)->with("jobtypedetails", "jobdetails")->first();
        return view('admin.jobapplications.show', compact("title", "module", "jobapplication"));
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  \App\Models\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function myapplications(JobApplication $jobApplication)
    {
        $title = "my job application";
        $module = "jobapplication";
        $user = User::where("id", Auth::user()->id)->first();
        $myemail = $user->email;

        $myapplications = JobApplication::where('email', $myemail)->with("jobtypedetails", "jobdetails")->first();
        if (!isset($myapplications)) {
            abort(404);
        }
        return view('admin.jobapplications.myapplications', compact("title", "module", "myapplications"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApplication  $jobApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        //
    }

    /**
     * Enable the specified JobApplication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApplication  $jobapplication
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, JobApplication $jobapplication, $id)
    {
        $jobapplication = JobApplication::findOrFail($id);
        $jobapplication->status = "1";
        $jobapplication->save();
        return redirect()->route('admin.jobapplication.list')->with('success', 'Job Application enabled.');
    }

    /**
     * Disable the specified jobapplication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobApplication  $jobapplication
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, JobApplication $jobapplication, $id)
    {
        $jobapplication = JobApplication::findOrFail($id);
        $jobapplication->status = "0";
        $jobapplication->save();
        return redirect()->route('admin.jobapplication.list')->with('warning', 'Job Application disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\JobApplication  $jobapplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobApplication $jobapplication, $id)
    {
        // $jobapplication = JobApplication::where('id', $id)->withTrashed()->first();

        $jobapplication = JobApplication::findOrFail($id);
        $jobapplication->delete();

        // Shows the remaining list of job application.
        return redirect()->route('admin.jobapplication.list')->with('error', 'Job Application deleted successfully.');
    }
}
