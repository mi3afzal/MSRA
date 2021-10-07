<?php

namespace App\Http\Controllers\Admin;

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

class SuburbController extends Controller
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
    public function list()
    {
        $title = "suburb lists";
        $module = "suburb";
        $data = Suburb::where("status", "1")->orderBy('id', 'asc')->get();
        return view('admin.suburb.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(Suburb::query())->make(true);

        $suburbdata = Suburb::select('suburbs.id', 'suburbs.ssc_code', 'suburbs.suburb', 'suburbs.urban_area', 'suburbs.postcode', 'suburbs.state', 'suburbs.state_name', 'suburbs.type', 'suburbs.local_goverment_area', 'suburbs.statistic_area', 'suburbs.status');
        return Datatables::of($suburbdata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('suburbs.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('name') && $request->get('name') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('suburbs.suburb', 'like', "%{$request->get('name')}%");
                    });
                }
            })
            ->addColumn('ssc_code', function ($suburbdata) {
                return $name = ucwords($suburbdata->ssc_code);
            })
            ->addColumn('suburb', function ($suburbdata) {
                return $name = ucwords($suburbdata->suburb);
            })
            ->addColumn('urban_area', function ($suburbdata) {
                return $name = ucwords($suburbdata->urban_area);
            })
            ->addColumn('postcode', function ($suburbdata) {
                return $name = ucwords($suburbdata->postcode);
            })
            ->addColumn('state', function ($suburbdata) {
                return $name = ucwords($suburbdata->state);
            })
            ->addColumn('state_name', function ($suburbdata) {
                return $name = ucwords($suburbdata->state_name);
            })
            ->addColumn('type', function ($suburbdata) {
                return $name = ucwords($suburbdata->type);
            })
            ->addColumn('local_goverment_area', function ($suburbdata) {
                return $name = ucwords($suburbdata->local_goverment_area);
            })
            ->addColumn('statistic_area', function ($suburbdata) {
                return $name = ucwords($suburbdata->statistic_area);
            })
            ->addColumn('status', function ($suburbdata) {
                return $status = ($suburbdata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($suburbdata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('suburb.delete', $suburbdata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the state?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.suburb.enable', $suburbdata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.suburb.disable', $suburbdata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                if (Gate::allows('isAdmin')) {
                    $final = ($suburbdata->status == 1) ? $link . $inactivelink : $link . $activelink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            You are not an admin.
                        </span>
                    ';
                }

                // $link = '<a href="' . route('jobtype.delete', $suburbdata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
                return $final;
            })
            ->make(true);
    }


    /**
     * Enable the specified suburb in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Suburb $suburb, $id)
    {
        $suburb = Suburb::findOrFail($id);
        $suburb->status = "1";
        $suburb->save();
        return redirect()->route('admin.suburb.list')->with('success', 'Suburb service enabled.');
    }

    /**
     * Disable the specified Suburb in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suburb  $suburb
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Suburb $suburb, $id)
    {
        $suburb = Suburb::findOrFail($id);
        $suburb->status = "0";
        $suburb->save();
        return redirect()->route('admin.suburb.list')->with('warning', 'Suburb service disabled.');
    }
}
