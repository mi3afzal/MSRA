<?php

namespace App\Http\Controllers\Admin;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class SocialLinkController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "add social links";
        $module = "sociallink";
        return view('admin.sociallink.add', compact('title', 'module'));
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
     * @param  \App\Models\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function show(SocialLink $socialLink)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLink $socialLink)
    {
        $count = SocialLink::orderBy('created_at', 'desc')->count();
        if ($count > 0) {
            $listings = SocialLink::orderBy('created_at', 'desc')->first();

            $title = "social link";
            $module = "SocialLink";
            return view('admin.sociallink.edit', compact('listings', 'title', 'module'));
        } else {
            return redirect()->route('admin.dashboard')->with('success', 'No record found.');
            // abort(404, 'No record found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialLink $socialLink, $id)
    {
        $this->validate($request, [
            'facebook' => 'required',
            'twitter' => 'required',
            'linkedin' => 'required',
            'instagram' => 'required',
            'google' => 'required',
        ]);

        // Update data
        $sociallink = SocialLink::find($id);
        $sociallink->facebook = $request->input("facebook");
        $sociallink->twitter = $request->input('twitter');
        $sociallink->linkedin = $request->input('linkedin');
        $sociallink->instagram = $request->input('instagram');
        $sociallink->google = $request->input('google');
        $sociallink->google_play = $request->input('google_play');
        $sociallink->apple_store = $request->input('apple_store');
        $sociallink->save();

        return redirect()->route('admin.sociallink.edit')->with('success', 'Details Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialLink  $socialLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialLink $socialLink)
    {
        //
    }
}
