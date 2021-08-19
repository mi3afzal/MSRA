<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;

class JobTypeController extends Controller
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
        $title = "jobtype lists";
        $module = "jobtype";
        $data = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.jobtype.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(JobType::query())->make(true);

        $jobtypedata = JobType::select('job_types.id', 'job_types.jobtype', 'job_types.status', 'job_types.created_at', 'job_types.updated_at');
        return Datatables::of($jobtypedata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_types.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('jobtype') && $request->get('jobtype') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_types.jobtype', 'like', "%{$request->get('jobtype')}%");
                    });
                }
            })
            ->addColumn('jobtype', function ($jobtypedata) {
                return $jobtype = ucwords($jobtypedata->jobtype);
            })
            ->addColumn('created_at', function ($jobtypedata) {
                return $status = date("F j, Y, g:i a", strtotime($jobtypedata->created_at));
            })
            ->addColumn('status', function ($jobtypedata) {
                return $status = ($jobtypedata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($jobtypedata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('jobtype.delete', $jobtypedata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the jobtype?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobtype.enable', $jobtypedata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobtype.disable', $jobtypedata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $final = ($jobtypedata->status == 1) ? $link . $inactivelink : $link . $activelink;
                // $link = '<a href="' . route('jobtype.delete', $jobtypedata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
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
        $title = "add job type";
        $module = "jobtype";
        return view('admin.jobtype.add', compact('title', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate(
            $request,
            [
                'jobtype' => 'required|max:30|unique:job_types',
            ]
        );

        $jobtype = new JobType;
        $jobtype->jobtype = $this->sanitizeString($request->input('jobtype'));
        $jobtype->user_id = Auth::user()->id;
        $jobtype->save();

        $str = "JBTP";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $jobtype->id;

        $jobtype->unique_id = $uid;
        $jobtype->save();

        return redirect()->route('admin.jobtype.list')->with('success', 'Job Type added successfully.');
    }



    /**
     * Enable the specified jobtype in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobType  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, JobType $jobtype, $id)
    {
        $jobtype = JobType::findOrFail($id);
        $jobtype->status = "1";
        $jobtype->save();
        return redirect()->route('admin.jobtype.list')->with('success', 'JobType enabled.');
    }

    /**
     * Disable the specified jobtype in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobType  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, JobType $jobtype, $id)
    {
        $jobtype = JobType::findOrFail($id);
        $jobtype->status = "0";
        $jobtype->save();
        return redirect()->route('admin.jobtype.list')->with('warning', 'JobYype disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\JobType  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobType $jobtype, $id)
    {
        // $jobtype = JobType::where('id', $id)->withTrashed()->first();

        $jobtype = JobType::findOrFail($id);
        $jobtype->delete();

        // Shows the remaining list of jobtypes.
        return redirect()->route('admin.jobtype.list')->with('error', 'JobType deleted successfully.');
    }
}
