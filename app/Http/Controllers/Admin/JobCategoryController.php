<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class JobCategoryController extends Controller
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
        $title = "jobcategory lists";
        $module = "jobcategory";
        $data = JobCategory::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.jobcategory.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(JobCategory::query())->make(true);

        $jobcategorydata = JobCategory::select('job_categories.id', 'job_categories.name', 'job_categories.status', 'job_categories.created_at', 'job_categories.updated_at');
        return Datatables::of($jobcategorydata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_categories.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('name') && $request->get('name') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('job_categories.name', 'like', "%{$request->get('name')}%");
                    });
                }
            })
            ->addColumn('name', function ($jobcategorydata) {
                return $name = ucwords($jobcategorydata->name);
            })
            ->addColumn('created_at', function ($jobcategorydata) {
                return $status = date("F j, Y, g:i a", strtotime($jobcategorydata->created_at));
            })
            ->addColumn('status', function ($jobcategorydata) {
                return $status = ($jobcategorydata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($jobcategorydata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('jobcategory.delete', $jobcategorydata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the jobcategory?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobcategory.enable', $jobcategorydata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';

                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.jobcategory.disable', $jobcategorydata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $editlink = '
                    <div class="btn-group">
                        <a href="' . route('admin.jobcategory.edit', $jobcategorydata->id) . '" class="btn btn-sm  mt-1 mb-1 bg-pink" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    $final = ($jobcategorydata->status == 1) ? $editlink . $link . $inactivelink : $editlink . $link . $activelink;
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
        $title = "add job category";
        $module = "jobcategory";
        return view('admin.jobcategory.add', compact('title', 'module'));
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
                'name' => 'required|max:30|unique:job_categories',
            ]
        );

        $jobcategory = new JobCategory;
        $jobcategory->name = ($request->input('name'));
        $jobcategory->user_id = Auth::user()->id;
        $jobcategory->save();

        $str = "JBCAT";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $jobcategory->id;

        $jobcategory->unique_code = $uid;
        $jobcategory->save();

        return redirect()->route('admin.jobcategory.list')->with('success', 'Job Category added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobCategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(JobCategory $jobcategory, $id)
    {
        $count = JobCategory::where("id", $id)->orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $listings = JobCategory::where("id", $id)->orderBy('created_at', 'desc')->first();
            $title = "jobcategory";
            $module = "jobcategory";
            return view('admin.jobcategory.edit', compact('listings', 'title', 'module'));
        } else {
            abort(404, 'No record found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobCategory $jobcategory, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:40|unique:job_categories,name,' . $jobcategory->name,
            ]
        );

        // Update data
        $jobCategory = JobCategory::find($id);
        $jobCategory->name = $request->input("name");
        $jobCategory->save();

        return redirect()->route('admin.jobcategory.list')->with('success', 'Details Updated.');
    }

    /**
     * Enable the specified jobcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCategory  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, JobCategory $jobtype, $id)
    {
        $jobcategory = JobCategory::findOrFail($id);
        $jobcategory->status = "1";
        $jobcategory->save();
        return redirect()->route('admin.jobcategory.list')->with('success', 'JobCategory enabled.');
    }

    /**
     * Disable the specified jobcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobCategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, JobCategory $jobcategory, $id)
    {
        $jobcategory = JobCategory::findOrFail($id);
        $jobcategory->status = "0";
        $jobcategory->save();
        return redirect()->route('admin.jobcategory.list')->with('warning', 'JobCategory disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\JobCategory  $jobcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobCategory $jobcategory, $id)
    {
        // $jobtype = JobType::where('id', $id)->withTrashed()->first();

        $jobcategory = JobCategory::findOrFail($id);
        $jobcategory->delete();

        // Shows the remaining list of jobcategory.
        return redirect()->route('admin.jobcategory.list')->with('error', 'JobCategory deleted successfully.');
    }
}
