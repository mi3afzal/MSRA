@include('partials._header')

<section class=" innerbanner text-center" style="background: url(images/dreamjobbg.png) top center no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="borderbox">
                    <h3>General Practice</h3>


                </div>
            </div>
        </div>
    </div>
</section>


<section class="latestjob">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Latest Jobs</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">

                @include('partials._sidebarJobs',
                [
                'professions' => $professions,
                'specialties' => $specialties,
                'states' => $states,
                'jobtypes' => $jobtypes,
                ])

                <ul class="fixedbutton list-unstyled d-none  d-xl-block d-lg-block">
                    <li>
                        <a href="#">
                            <span><img src="images/jobalert.png" alt="" class="img-fluid"></span>
                            <h5>
                                Job Alert
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span><img src="images/phoneicon.png" alt="" class="img-fluid"></span>
                            <h5>
                                Call Me
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span><img src="images/inviteicon.png" alt="" class="img-fluid"></span>
                            <h5>
                                Refer & Earn
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="topheadingbar">
                    <h3>Job Type</h3>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Permanent</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Locum</button>
                        </li>

                    </ul>

                </div>
                <div class="joblisting" id="js-joblisting">
                    <div class="tab-content" id="myTabContent">
                        @if(count($jobs) > 0 )

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @foreach($jobs as $job )
                            @if($job->job_type == 1)
                            <div class="card">
                                <div class="jobdate">
                                    <strong>{{ date('d M', strtotime($job->created_at)); }}</strong>
                                    <span>Job Id: {!! $job->unique_code !!}</span>
                                </div>
                                <a href="{{route('jobdetails', [$job->slug])}}" class="card-tittle">{!! $job->title !!}</a>
                                <span class="jobtype">
                                    {!! $job->associatedJobtype->jobtype !!}
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {!! $job->jobcategory->name !!}
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>{!! $job->rate !!}
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        {!! $job->work_days !!}
                                    </li>

                                </ul>
                                <p>
                                    {!! Str::limit($job->description, $limit = 250, $end = '...') !!}
                                    <a href="{{route('jobdetails', [$job->slug])}}">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="javascript:void(0);" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="javascript:void(0);" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                            @endif
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @foreach($jobs as $job )
                            @if($job->job_type == 2)
                            <div class="card">
                                <div class="jobdate">
                                    <strong>{{ date('d M', strtotime($job->created_at)); }}</strong>
                                    <span>Job Id: {!! $job->unique_code !!}</span>
                                </div>
                                <a href="{{route('jobdetails', [$job->slug])}}" class="card-tittle">{!! $job->title !!}</a>
                                <span class="jobtype">
                                    {!! $job->associatedJobtype->jobtype !!}
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {!! $job->jobcategory->name !!}
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>{!! $job->rate !!}
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        {!! $job->work_days !!}
                                    </li>

                                </ul>
                                <p>{!! Str::limit($job->description, $limit = 250, $end = '...') !!}
                                    <a href="{{route('jobdetails', [$job->slug])}}">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="javascript:void(0);" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="javascript:void(0);" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <div class=" card text-muted text-center">
                            <h3> <strong>CURRENTY NO JOB OPENING </strong></h3>
                        </div>
                        @endif

                    </div>
                </div>
                <ul class="fixedbutton list-unstyled d-xl-none d-lg-none">
                    <li>
                        <a href="javascript:void(0);">
                            <span><img src="images/jobalert.png" alt="" class="img-fluid"></span>
                            <h5>
                                Job Alert
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span><img src="images/phoneicon.png" alt="" class="img-fluid"></span>
                            <h5>
                                Call Me
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span><img src="images/inviteicon.png" alt="" class="img-fluid"></span>
                            <h5>
                                Refer & Earn
                                <small>Lorem ipsum dolor sit amet, consectetur adipiscing </small>
                            </h5>
                        </a>
                    </li>
                </ul>
            </div>

            <div id="job_ajax">

            </div>
        </div>
    </div>
</section>


@include('partials._downloadApp', ['sociallinks' => $sociallinks])

@include('partials._footer', ['sociallinks' => $sociallinks])