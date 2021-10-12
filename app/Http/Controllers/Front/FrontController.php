<?php

namespace App\Http\Controllers\Front;

use App\Models\Front;
use App\Models\State;
use App\Models\JobType;
use App\Models\Profession;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\SocialLink;
use App\Models\Settings;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget(['jobtype', 'states', 'cities', 'suburb', 'profession', 'specialty']);
        $states = State::where("status", "1")->orderBy('name', 'asc')->get();
        $professions = Profession::where("status", "1")->orderBy('profession', 'asc')->get();
        $jobtypes = JobType::where("status", "1")->orderBy('created_at', 'desc')->get();
        $specialties = Specialty::where("status", "1")->orderBy('specialty', 'asc')->skip(0)->take(7)->get();
        $sociallinks = SocialLink::where("status", "1")->first();
        $settings = Settings::orderBy("created_at", "desc")->first();
        return view('front.home', compact("jobtypes", "states", "sociallinks", "professions", "settings", "specialties"));
    }
}
