<?php

namespace App\Http\Controllers\Jobseeker;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Middleware\IsJobSeeker;

class TestimonialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', "jobseeker"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "testimonial lists";
        $module = "testimonial";
        return view('jobseeker.testimonial.add', compact('title', 'module'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lists()
    {
        $title = "testimonial lists";
        $module = "testimonial";
        $data = Testimonial::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('jobseeker.testimonial.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(Testimonial::query())->make(true);

        $testimonialdata = Testimonial::select('testimonials.id', 'testimonials.unique_code', 'testimonials.user_id', 'testimonials.title', 'testimonials.slug', 'testimonials.notes', 'testimonials.rating', 'testimonials.status', 'testimonials.created_at', 'testimonials.updated_at', 'testimonials.deleted_at')->where("user_id", Auth::user()->id);
        return Datatables::of($testimonialdata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('testimonials.status', '=', $request->get('status'));
                    });
                }

                if ($request->has('title') && $request->get('title') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('testimonials.title', 'like', "%{$request->get('title')}%");
                    });
                }
            })
            ->addColumn('title', function ($testimonialdata) {
                return $title = ucwords($testimonialdata->title);
            })
            ->addColumn('created_at', function ($testimonialdata) {
                return $created_at = date("F j, Y, g:i a", strtotime($testimonialdata->created_at));
            })
            ->addColumn('status', function ($testimonialdata) {
                return $status = ($testimonialdata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($testimonialdata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('testimonial.delete', $testimonialdata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the profession?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('jobseeker.testimonial.enable', $testimonialdata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('jobseeker.testimonial.disable', $testimonialdata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                if (Gate::allows('isJobseeker')) {
                    $final = ($testimonialdata->status == 1) ? $link . $inactivelink : $link . $activelink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            Feature is only for Job Seeker.
                        </span>
                    ';
                }
                // $link = '<a href="' . route('profession.delete', $professiondata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
                return $final;
            })
            ->make(true);
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
                'title' => 'required|max:100',
                'notes' => 'required|max:500',
            ]
        );

        $testimonial = new Testimonial;
        $testimonial->title = $this->sanitizeString($request->input('title'));
        $testimonial->notes = $this->sanitizeString($request->input('notes'));
        $testimonial->user_id = Auth::user()->id;
        $testimonial->save();

        $str = "TSTNL";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $testimonial->id;

        $testimonial->unique_code = $uid;
        $testimonial->save();
        die("Added Successfully");
        return redirect()->route('jobseeker.testimonial.list')->with('success', 'Testimonial added successfully.');
    }

    /**
     * Enable the specified testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Testimonial $testimonial, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = "1";
        $testimonial->save();
        return redirect()->route('jobseeker.testimonial.list')->with('success', 'Testimonial enabled.');
    }

    /**
     * Disable the specified testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Testimonial $testimonial, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->status = "0";
        $testimonial->save();
        return redirect()->route('jobseeker.testimonial.list')->with('warning', 'Testimonial disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial, $id)
    {
        // $testimonial = Testimonial::where('id', $id)->withTrashed()->first();

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        // Shows the remaining list of testimonials.
        return redirect()->route('jobseeker.testimonial.list')->with('error', 'Testimonial deleted successfully.');
    }
}