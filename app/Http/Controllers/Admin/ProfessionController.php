<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class ProfessionController extends Controller
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
        $title = "profession lists";
        $module = "profession";
        $data = Profession::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.profession.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(Profession::query())->make(true);

        $professiondata = Profession::select('professions.id', 'professions.profession', 'professions.status', 'professions.created_at', 'professions.updated_at');
        return Datatables::of($professiondata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('professions.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('profession') && $request->get('profession') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('professions.profession', 'like', "%{$request->get('profession')}%");
                    });
                }
            })
            ->addColumn('profession', function ($professiondata) {
                return $profession = ucwords($professiondata->profession);
            })
            ->addColumn('created_at', function ($professiondata) {
                return $status = date("F j, Y, g:i a", strtotime($professiondata->created_at));
            })
            ->addColumn('status', function ($professiondata) {
                return $status = ($professiondata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($professiondata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('profession.delete', $professiondata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the profession?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.profession.enable', $professiondata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.profession.disable', $professiondata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                if (Gate::allows('isAdmin')) {
                    $final = ($professiondata->status == 1) ? $link . $inactivelink : $link . $activelink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            You are not an admin.
                        </span>
                    ';
                }
                // $link = '<a href="' . route('profession.delete', $professiondata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
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
        $title = "add profession";
        $module = "profession";
        return view('admin.profession.add', compact('title', 'module'));
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
                'profession' => 'required|max:30|unique:professions',
            ]
        );

        $profession = new Profession;
        $profession->profession = $this->sanitizeString($request->input('profession'));
        $profession->description = $this->sanitizeString($request->input('description'));
        $profession->user_id = Auth::user()->id;
        $profession->save();

        $str = "PROFS";
        $uid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $profession->id;

        $profession->unique_code = $uid;
        $profession->save();

        return redirect()->route('admin.profession.list')->with('success', 'Profession added successfully.');
    }

    /**
     * Enable the specified profession in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Profession $profession, $id)
    {
        $profession = Profession::findOrFail($id);
        $profession->status = "1";
        $profession->save();
        return redirect()->route('admin.profession.list')->with('success', 'Profession enabled.');
    }

    /**
     * Disable the specified profession in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Profession $profession, $id)
    {
        $profession = Profession::findOrFail($id);
        $profession->status = "0";
        $profession->save();
        return redirect()->route('admin.profession.list')->with('warning', 'Profession disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profession $profession, $id)
    {
        // $profession = Profession::where('id', $id)->withTrashed()->first();

        $profession = Profession::findOrFail($id);
        $profession->delete();

        // Shows the remaining list of professions.
        return redirect()->route('admin.profession.list')->with('error', 'Profession deleted successfully.');
    }
}
