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

class StateController extends Controller
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
    public function getcities()
    {
        $cities_count = City::where(["status" => "1", "state_id" => $_POST["state_id"]])->count();
        if ($cities_count > 0) {
            $cities = City::where(["status" => "1", "state_id" => $_POST["state_id"]])->get()->toArray();

            if ((isset($_POST["label"])) && ($_POST["label"] == 1)) {
                return view('ajax.labelstatecities', compact('cities'));
            } else {
                return view('ajax.statecities', compact('cities'));
            }
        } else {
            return view('ajax.defaultstatecities');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getasuburbs()
    {
        $suburb_count = Suburb::where(["status" => "1", "state_id" => $_POST["state_id"]])->count();
        if ($suburb_count > 0) {
            $suburbs = Suburb::where(["status" => "1", "state_id" => $_POST["state_id"]])->get()->toArray();
            if (isset($_POST["label"]) && ($_POST["label"] == 1)) {
                return view('ajax.labelsuburb', compact('suburbs'));
            } else {
                return view('ajax.suburb', compact('suburbs'));
            }
        } else {
            return view('ajax.defaultsuburb');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register_getcities()
    {
        $cities_count = City::where(["status" => "1", "state_id" => $_POST["state_id"]])->count();
        if ($cities_count > 0) {
            $cities = City::where(["status" => "1", "state_id" => $_POST["state_id"]])->get()->toArray();
            return view('ajax.register-statecities', compact('cities'));
        } else {
            return view('ajax.default-register-statecities');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register_getasuburbs()
    {
        $suburb_count = Suburb::where(["status" => "1", "state_id" => $_POST["state_id"]])->count();
        if ($suburb_count > 0) {
            $suburbs = Suburb::where(["status" => "1", "state_id" => $_POST["state_id"]])->get()->toArray();
            return view('ajax.register-suburb', compact('suburbs'));
        } else {
            return view('ajax.default-register-suburb');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lists()
    {
        $title = "states lists";
        $module = "state";
        $data = State::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.state.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(State::query())->make(true);

        $statedata = State::select('states.id', 'states.name', 'states.iso2', 'states.status', 'states.created_at', 'states.updated_at');
        return Datatables::of($statedata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('states.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('name') && $request->get('name') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('states.name', 'like', "%{$request->get('name')}%");
                    });
                }
            })
            ->addColumn('name', function ($namedata) {
                return $name = ucwords($namedata->name);
            })
            ->addColumn('created_at', function ($statedata) {
                return $status = date("F j, Y, g:i a", strtotime($statedata->created_at));
            })
            ->addColumn('status', function ($statedata) {
                return $status = ($statedata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($statedata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('state.delete', $statedata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the state?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.state.enable', $statedata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.state.disable', $statedata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                if (Gate::allows('isAdmin')) {
                    $final = ($statedata->status == 1) ? $link . $inactivelink : $link . $activelink;
                } else {
                    $final = '
                        <span class="bg-warning p-1">
                            You are not an admin.
                        </span>
                    ';
                }

                // $link = '<a href="' . route('jobtype.delete', $statedata->id) . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a> ';
                return $final;
            })
            ->make(true);
    }


    /**
     * Enable the specified state in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, State $state, $id)
    {
        $state = State::findOrFail($id);
        $state->status = "1";
        $state->save();
        return redirect()->route('admin.state.list')->with('success', 'State service enabled.');
    }

    /**
     * Disable the specified state in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, State $state, $id)
    {
        $state = State::findOrFail($id);
        $state->status = "0";
        $state->save();
        return redirect()->route('admin.state.list')->with('warning', 'State service disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state, $id)
    {
        // $state = state::where('id', $id)->withTrashed()->first();

        $state = State::findOrFail($id);
        $state->delete();

        // Shows the remaining list of states.
        return redirect()->route('admin.state.list')->with('error', 'state service removed successfully.');
    }
}
