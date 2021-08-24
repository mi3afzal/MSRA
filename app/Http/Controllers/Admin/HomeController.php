<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\City;
use App\Models\Suburb;
use App\Models\JobType;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cities = City::where(["status" => "1"])->count();
        $states = State::where(["status" => "1"])->count();
        $suburbs = Suburb::where(["status" => "1"])->count();
        $jobtypes = JobType::where(["status" => "1"])->count();
        return view('admin.home', compact("cities", "states", "suburbs", "jobtypes"));
    }
}
