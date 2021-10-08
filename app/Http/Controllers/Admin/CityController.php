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

class CityController extends Controller
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
        $title = "cities lists";
        $module = "city";
        $data = City::where("status", "1")->orderBy('created_at', 'desc')->get();
        return view('admin.city.index', compact('data', 'title', 'module'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        // return Datatables::of(City::query())->make(true);

        $citydata = City::select('cities.id', 'cities.name', 'cities.postcode', 'cities.state_code', 'cities.type', 'cities.status', 'cities.created_at', 'cities.updated_at');
        return Datatables::of($citydata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('cities.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('name') && $request->get('name') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('cities.name', 'like', "%{$request->get('name')}%");
                    });
                }

                if ($request->has('state_code') && $request->get('state_code') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('cities.state_code', 'like', "%{$request->get('state_code')}%");
                    });
                }

                if ($request->has('postcode') && $request->get('postcode') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('cities.postcode', '=', $request->get('postcode'));
                    });
                }
            })
            ->addColumn('name', function ($citydata) {
                return $name = ucwords($citydata->name);
            })
            ->addColumn('postcode', function ($citydata) {
                return $name = ucwords($citydata->postcode);
            })
            ->addColumn('state_code', function ($citydata) {
                return $name = ucwords($citydata->state_code);
            })
            ->addColumn('created_at', function ($citydata) {
                return $status = date("F j, Y, g:i a", strtotime($citydata->created_at));
            })
            ->addColumn('status', function ($citydata) {
                return $status = ($citydata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($citydata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('city.delete', $citydata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the record?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.city.enable', $citydata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.city.disable', $citydata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';
                $editlink = '
                    <div class="btn-group">
                        <a href="' . route('admin.city.edit', $citydata->id) . '" class="btn btn-sm  mt-1 mb-1 bg-pink" title="Edit" ><i class="fas fa-pencil-alt"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    $final = ($citydata->status == 1) ? $editlink . $link . $inactivelink : $editlink . $link . $activelink;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city, $id)
    {
        $count = City::where("id", $id)->orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $listings = City::where("id", $id)->orderBy('created_at', 'desc')->first();
            $title = "city";
            $module = "city";
            return view('admin.city.edit', compact('listings', 'title', 'module'));
        } else {
            abort(404, 'No record found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:40|unique:cities,name,' . $city->name,
                'postcode' => 'required|numeric',
            ]
        );

        // Update data
        $state = City::findOrFail($id);
        $state->name = $request->input("name");
        $state->postcode = $request->input("postcode");
        $state->save();

        return redirect()->route('admin.city.list')->with('success', 'Details Updated.');
    }


    /**
     * Enable the specified city in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, City $city, $id)
    {
        $city = City::findOrFail($id);
        $city->status = "1";
        $city->save();
        return redirect()->route('admin.city.list')->with('success', 'City service enabled.');
    }

    /**
     * Disable the specified city in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, City $city, $id)
    {
        $city = City::findOrFail($id);
        $city->status = "0";
        $city->save();
        return redirect()->route('admin.city.list')->with('warning', 'City service disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city, $id)
    {
        // $city = City::where('id', $id)->withTrashed()->first();

        $city = City::findOrFail($id);
        $city->delete();

        // Shows the remaining list of city.
        return redirect()->route('admin.city.list')->with('error', 'City service removed successfully.');
    }
}
