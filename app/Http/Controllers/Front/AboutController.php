<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\About;
use App\Models\SocialLink;
use App\Models\JobType;
use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Settings;

class AboutController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['jobtype', 'states', 'cities', 'suburb', 'profession', 'specialty']);
        $count = About::orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $listings = About::orderBy('created_at', 'desc')->first();
            $sociallinks = SocialLink::where("status", "1")->first();
            $settings = Settings::orderBy("created_at", "desc")->first();
            $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
            $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
            $totalJobSeekers = User::where(["status" => "1", "role" => 2])->orderBy('created_at', 'desc')->count();
            $totalMedicalCenters = User::where(["status" => "1", "role" => 3])->orderBy('created_at', 'desc')->count();
            $totalDoctors = User::where(["status" => "1", "role" => 4])->orderBy('created_at', 'desc')->count();
            return view('front.aboutus', compact("sociallinks", "listings", "settings", "jobtypes", "professions", "totalJobSeekers", "totalMedicalCenters", "totalDoctors"));
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
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(About $about)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit(About $about)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, About $about)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(About $about)
    {
        //
    }
}
