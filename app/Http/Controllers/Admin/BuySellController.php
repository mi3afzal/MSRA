<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\About;
use App\Models\SocialLink;
use App\Models\JobType;
use App\Models\Profession;
use App\Models\BuySell;
use App\Models\BuySellMedia;
use App\Models\State;
use App\Models\City;
use App\Models\Suburb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Settings;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class BuySellController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, BuySell $buySell)
    {
        $this->middleware('auth');
        $this->bstype = config("constants.bstype");
        $this->property_type = config("constants.property_type");
        $this->promotional_flag = config("constants.promotional_flag");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request, BuySell $buySell)
    {

        $request->session()->forget(['jobtype', 'states', 'cities', 'suburb', 'profession', 'specialty']);
        $bstype = $this->bstype;
        $property_type = $this->property_type;
        $promotional_flag = $this->promotional_flag;
        $title = "buy sell listing";
        $module = "buysell";

        $count = BuySell::orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $buysellrecords = BuySell::where("status", "1")->with("associatedImages")->orderBy('order', 'asc')->get();
            $users = User::where(["status" => "1"])->orderBy('created_at', 'desc')->get();
            $states = State::where("status", "1")->get();
            $cities = City::where("status", "1")->get();
            $suburbs = Suburb::where("status", "1")->get();
            return view('admin.buysell.index', compact("title", "module", "users", "states", "cities", "suburbs", "buysellrecords", "promotional_flag", "property_type"));
        } else {
            abort(404, 'No record found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buyselldata = BuySell::select('buy_sells.id', 'buy_sells.unique_code', 'buy_sells.user_id', 'buy_sells.type', 'buy_sells.property_type', 'buy_sells.promotional_flag', 'buy_sells.state_id', 'buy_sells.city_id', 'buy_sells.suburb_id', 'buy_sells.price', 'buy_sells.title', 'buy_sells.slug', 'buy_sells.description', 'buy_sells.number', 'buy_sells.email', 'buy_sells.rating', 'buy_sells.order', 'buy_sells.status', 'buy_sells.created_at', 'buy_sells.updated_at')->with("associatedImages")->get();

        $title = "buysell";
        $description = "buysell";
        $module = "buysell";
        $states = State::where("status", "1")->get();
        return view('admin.buysell.add', compact("title", "description", "states", "module"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BuySell $buySell)
    {
        if ($request->file('images')) {
            if (count($request->file('images')) > 3) {
                return redirect()->route('admin.buysell.create')->with('error', 'Maximum 3 images allowed.');
            }
        }

        // BuySellMedia
        $this->validate(
            $request,
            [
                'type' => 'required',
                'property_type' => 'required',
                'promotional_flag' => 'required',
                'state' => 'required',
                'city' => 'required',
                'suburb' => 'required',
                'price' => 'required',
                'title' => 'required|max:250',
                'number' => 'required',
                'email' => 'required|max:250',
                'description' => 'required|max:600',
            ]
        );

        // Insert brand data
        $buySell = new BuySell;
        $buySell->user_id = Auth::user()->id;
        $buySell->type = $request->input('type');
        $buySell->property_type = $request->input('property_type');
        $buySell->promotional_flag = $request->input('promotional_flag');
        $buySell->state_id = $request->input('state');
        $buySell->city_id = $request->input('city');
        $buySell->suburb_id = $request->input('suburb');
        $buySell->price = $request->input('price');
        $buySell->title = $request->input('title');
        $buySell->description = $request->input('description');
        $buySell->number = $request->input('number');
        $buySell->email = $request->input('email');
        $buySell->rating = $request->input('rating');
        $buySell->save();

        $str = "BYSLL";
        $uid = str_pad(
            $str,
            10,
            "0",
            STR_PAD_RIGHT
        ) . $buySell->id;

        $buySell->order = $buySell->id;
        $buySell->unique_code = $uid;
        $buySell->save();


        foreach ($request->file('images') as $key => $value) {
            $nam = ($request->input('state')) . "_" . ($request->input('city'));
            $name = $key . '_' . $nam . '_image_' . time() . '.' . $value->getClientOriginalExtension();
            $destinationPath = public_path('/images/buysell');
            $value->move($destinationPath, $name);

            // Insert Image into Buy media.
            $buySellMedia = new BuySellMedia;
            $buySellMedia->file = (isset($name)) ? $name : "default.png";
            $buySellMedia->type = "1";
            $buySellMedia->user_id = Auth::user()->id;
            $buySellMedia->buysell_id = $buySell->id;
            $buySellMedia->save();

            $str = "BYSLMD";
            $ubid = str_pad($str, 10, "0", STR_PAD_RIGHT) . $buySellMedia->id;

            $buySellMedia->unique_code = $ubid;
            $buySellMedia->save();
        }

        return redirect()->route('admin.buysell.create')->with('success', 'Property added successfully.');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request, BuySell $buySell)
    {
        // return Datatables::of(City::query())->make(true);

        $buyselldata = BuySell::select('buy_sells.id', 'buy_sells.unique_code', 'buy_sells.user_id', 'buy_sells.type', 'buy_sells.property_type', 'buy_sells.promotional_flag', 'buy_sells.state_id', 'buy_sells.city_id', 'buy_sells.suburb_id', 'buy_sells.price', 'buy_sells.title', 'buy_sells.slug', 'buy_sells.description', 'buy_sells.number', 'buy_sells.email', 'buy_sells.rating', 'buy_sells.order', 'buy_sells.status', 'buy_sells.created_at', 'buy_sells.updated_at')->with("associatedImages");

        return Datatables::of($buyselldata)
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.status', 'like', "%{$request->get('status')}%");
                    });
                }

                if ($request->has('state') && $request->get('state') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.state_id', '=', $request->get('state'));
                    });
                }

                if ($request->has('city') && $request->get('city') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.city_id', '=', $request->get('city'));
                    });
                }

                if ($request->has('suburb') && $request->get('suburb') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.suburb_id', '=', $request->get('suburb'));
                    });
                }

                if ($request->has('promotional_flag') && $request->get('promotional_flag') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.promotional_flag', '=', $request->get('promotional_flag'));
                    });
                }

                if ($request->has('property_type') && $request->get('property_type') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.property_type', '=', $request->get('property_type'));
                    });
                }

                if ($request->has('title') && $request->get('title') != '') {
                    $query->where(function ($q) use ($request) {
                        $q->where('buy_sells.title', 'like', "%{$request->get('title')}%");
                    });
                }
            })
            ->addColumn('title', function ($buyselldata) {
                return $title = ucwords($buyselldata->title);
            })
            ->addColumn('price', function ($buyselldata) {
                return $price = ucwords($buyselldata->price);
            })
            ->addColumn('number', function ($buyselldata) {
                return $number = ucwords($buyselldata->number);
            })
            ->addColumn('email', function ($buyselldata) {
                return $email = ucwords($buyselldata->email);
            })
            ->addColumn('rating', function ($buyselldata) {
                return $rating = ucwords($buyselldata->rating);
            })
            ->addColumn('order', function ($buyselldata) {
                return $order = ucwords($buyselldata->order);
            })
            ->addColumn('created_at', function ($buyselldata) {
                return $status = date("F j, Y, g:i a", strtotime($buyselldata->created_at));
            })
            ->addColumn('status', function ($buyselldata) {
                return $status = ($buyselldata->status == 1) ? 'Enabled' : 'Disabled';
            })
            ->addColumn('action', function ($buyselldata) {

                $link = '
                    <div class="btn-group">
                        <a href="' . route('buysell.delete', $buyselldata->id) . '" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Do you really want to delete the record?\');" ><i class="fas fa-trash-alt"></i></a>
                    </div>
                ';

                $activelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.buysell.enable', $buyselldata->id) . '" class="btn btn-sm btn-warning" title="Enable"><i class="fas fa-lock"></i></a>
                        </div>
                    ';
                $inactivelink = '
                        <div class="btn-group">
                            <a href="' . route('admin.buysell.disable', $buyselldata->id) . '" class="btn btn-sm btn-success" title="Disable"><i class="fas fa-lock-open"></i></a>
                        </div>
                    ';

                $detailslink = '
                    <div class="btn-group">
                        <a href="' . route('admin.buysell.show', $buyselldata->id) . '" class="btn btn-sm btn-primary" title="View Details" ><i class="fas fa-eye"></i></a>
                    </div>
                ';

                if (Gate::allows('isAdmin')) {
                    // $final = ($buyselldata->status == 1) ? $link . $inactivelink . $detailslink : $link . $activelink . $detailslink;
                    $final = ($buyselldata->status == 1) ? $link . $inactivelink  : $link . $activelink;
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
     * Enable the specified buySell in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuySell  $buySell
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, BuySell $buySell, $id)
    {
        $buysell = BuySell::findOrFail($id);
        $buysell->status = "1";
        $buysell->save();
        return redirect()->route('admin.buysell.list')->with('success', 'Buysell service enabled.');
    }

    /**
     * Disable the specified buySell in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuySell $buySell
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, BuySell $buySell, $id)
    {
        $buysell = BuySell::findOrFail($id);
        $buysell->status = "0";
        $buysell->save();
        return redirect()->route('admin.buysell.list')->with('warning', 'Buysell service disabled.');
    }

    /**
     * Remove the specified resource from storage ( Soft Delete ).
     *
     * @param  \App\Models\BuySell $buySell
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuySell $buySell, $id)
    {
        // $buySell = BuySell::where('id', $id)->withTrashed()->first();

        $buySell = BuySell::findOrFail($id);
        $buySell->delete();

        // Shows the remaining list of buySell.
        return redirect()->route('admin.buysell.list')->with('error', 'Buysell service removed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuySell  $buySell
     * @return \Illuminate\Http\Response
     */
    public function show(BuySell $buySell)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuySell  $buySell
     * @return \Illuminate\Http\Response
     */
    public function edit(BuySell $buySell)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuySell  $buySell
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuySell $buySell)
    {
        //
    }
}