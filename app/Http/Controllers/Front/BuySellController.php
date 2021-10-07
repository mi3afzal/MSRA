<?php

namespace App\Http\Controllers\Front;

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

class BuySellController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->bstype = config("constants.bstype");
        $this->property_type = config("constants.property_type");
        $this->promotional_flag = config("constants.promotional_flag");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // die("Buy and sell");
        $request->session()->forget(['jobtype', 'states', 'cities', 'suburb', 'profession', 'specialty']);
        $count = BuySell::orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            // $listings = BuySell::orderBy('created_at', 'desc')->first();
            $listings = BuySell::where("status", "1")->with("associatedImages", "associatedState", "associatedCity", "associatedSuburb")->orderBy('order', 'asc')->get();
            $sociallinks = SocialLink::where("status", "1")->first();
            $settings = Settings::orderBy("created_at", "desc")->first();
            $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
            $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
            $totalJobSeekers = User::where(["status" => "1", "role" => 2])->orderBy('created_at', 'desc')->count();
            $totalMedicalCenters = User::where(["status" => "1", "role" => 3])->orderBy('created_at', 'desc')->count();
            $totalDoctors = User::where(["status" => "1", "role" => 4])->orderBy('created_at', 'desc')->count();
            $states = State::where("status", "1")->get();
            $cities = City::where("status", "1")->get();
            $suburbs = Suburb::where("status", "1")->get();
            return view('front.buysell', compact("listings", "states", "cities", "suburbs", "sociallinks", "listings", "settings", "jobtypes", "professions", "totalJobSeekers", "totalMedicalCenters", "totalDoctors"));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuySell  $buySell
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuySell $buySell)
    {
        //
    }
}
