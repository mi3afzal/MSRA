<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\City;
use App\Models\Suburb;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Profession;
use App\Models\Specialty;
use App\Models\User;
use App\Models\JobCategory;

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
        $professions = Profession::where(["status" => "1"])->count();
        $specialty = Specialty::where(["status" => "1"])->count();
        $jobcategories = JobCategory::where(["status" => "1"])->count();
        $jobs = Job::where(["status" => "1"])->count();
        $user = Auth::user();

        if ($user->role == 1) {
            $title = "dashboard";
            $module = "dashboard";
            return view('admin.home', compact("cities", "states", "suburbs", "jobtypes", "title", "module", "professions", "specialty", "jobcategories", "jobs"));
        } else {
            $title = "dashboard";
            $module = "jobseeker dashboard";
            return view('admin.jobseeker', compact("cities", "states", "suburbs", "jobtypes", "title", "module", "professions", "specialty", "jobcategories", "jobs"));
        }
    }
}
