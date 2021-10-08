<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class SpecialtyController extends Controller
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
    public function lists()
    {
        $title = "specialty lists";
        $module = "specialty";
        $data = Specialty::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.specialty.index', compact('data', 'title', 'module'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "add specialty";
        $module = "specialty";
        return view('admin.specialty.add', compact('title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(Specialty::query())->make(true);

        $specialtydata = Specialty::select('specialties.id', 'specialties.specialty', 'specialties.status', 'specialties.created_at', 'specialties.updated_at');
        return Datatables::of($specialtydata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('specialties.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('specialty') && $request->get('specialty') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('specialties.specialty', 'like', "%{$request->get('specialty')}%");
                    });
                }
            })
            ->addColumn('specialty', function ($specialtydata) {
                return $specialty = ucwords($specialtydata->specialty);
            })
            ->addColumn('created_at', function ($specialtydata) {
                return $status = date("F j, Y, g:i a", strtotime($specialtydata->created_at));
            })
            ->addColumn('status', function ($specialtydata) {
                return $status = ($specialtydata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($specialtydata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('specialty.delete', $specialtydata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the specialty?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.specialty.enable', $specialtydata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.specialty.disable', $specialtydata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $editlink = '
                    <div class="btn-group">
                        <a href="' . route('admin.specialty.edit', $specialtydata->id) . '" class="btn btn-sm  mt-1 mb-1 bg-pink" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    $final = ($specialtydata->status == 1) ? $editlink . $link . $inactivelink : $editlink . $link . $activelink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            You are not an admin.
                        </span>
                    ';
                }

                // $link = '<a href="' . route('specialty.delete', $specialtydata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
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
                'specialty' => 'required|max:40|unique:specialties',
            ]
        );

        $specialty = new Specialty;
        $specialty->specialty = $this->sanitizeString($request->input('specialty'));
        $specialty->description = $this->sanitizeString($request->input('description'));
        $specialty->user_id = Auth::user()->id;
        $specialty->save();

        $str = "SPETY";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $specialty->id;

        $specialty->unique_code = $uid;
        $specialty->save();

        return redirect()->route('admin.specialty.list')->with('success', 'Specialty added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialty $specialty, $id)
    {
        $count = Specialty::where("id", $id)->orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $listings = Specialty::where("id", $id)->orderBy('created_at', 'desc')->first();
            $title = "specialty";
            $module = "specialty";
            return view('admin.specialty.edit', compact('listings', 'title', 'module'));
        } else {
            abort(404, 'No record found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialty $specialty, $id)
    {
        $this->validate(
            $request,
            [
                'specialty' => 'required|max:40|unique:specialties,specialty,' . $specialty->specialty,
            ]
        );

        // Update data
        $specialty = Specialty::find($id);
        $specialty->specialty = $request->input("specialty");
        $specialty->save();

        return redirect()->route('admin.specialty.list')->with('success', 'Details Updated.');
    }

    /**
     * Enable the specified specialty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Specialty $specialty, $id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->status = "1";
        $specialty->save();
        return redirect()->route('admin.specialty.list')->with('success', 'Specialty enabled.');
    }

    /**
     * Disable the specified specialty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Specialty $specialty, $id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->status = "0";
        $specialty->save();
        return redirect()->route('admin.specialty.list')->with('warning', 'Specialty disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty, $id)
    {
        // $specialty = Specialty::where('id', $id)->withTrashed()->first();

        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        // Shows the remaining list of specialtys.
        return redirect()->route('admin.specialty.list')->with('error', 'Specialty deleted successfully.');
    }
}
