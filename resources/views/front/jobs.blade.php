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
                <div class="joblisting">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card">
                                <div class="jobdate">
                                    <strong>15 APR</strong>
                                    <span>Job Id: RP001137</span>
                                </div>
                                <a href="#" class="card-tittle">Immediate Start GP Required *Busy Medical Practice * - Cannon Hill, QLD</a>
                                <span class="jobtype">
                                    Full Time
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        NON-DPA
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>70% / $140.00 Per Hour *
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        7 days a week
                                    </li>

                                </ul>
                                <p>Are you looking to hit the ground running ? Enjoy been kept busy with a influx of patients? Wanting to work for a practice with fully...
                                    <a href="#">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="#" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="#" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                            <div class="card">
                                <div class="jobdate">
                                    <strong>15 APR</strong>
                                    <span>Job Id: RP001137</span>
                                </div>
                                <a href="#" class="card-tittle">Immediate Start GP Required *Busy Medical Practice * - Cannon Hill, QLD</a>
                                <span class="jobtype">
                                    Full Time
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        NON-DPA
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>70% / $140.00 Per Hour *
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        7 days a week
                                    </li>

                                </ul>
                                <p>Are you looking to hit the ground running ? Enjoy been kept busy with a influx of patients? Wanting to work for a practice with fully...
                                    <a href="#">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="#" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="#" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                            <div class="card">
                                <div class="jobdate">
                                    <strong>15 APR</strong>
                                    <span>Job Id: RP001137</span>
                                </div>
                                <a href="#" class="card-tittle">Immediate Start GP Required *Busy Medical Practice * - Cannon Hill, QLD</a>
                                <span class="jobtype">
                                    Full Time
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        NON-DPA
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>70% / $140.00 Per Hour *
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        7 days a week
                                    </li>

                                </ul>
                                <p>Are you looking to hit the ground running ? Enjoy been kept busy with a influx of patients? Wanting to work for a practice with fully...
                                    <a href="#">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="#" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="#" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                            <div class="card">
                                <div class="jobdate">
                                    <strong>15 APR</strong>
                                    <span>Job Id: RP001137</span>
                                </div>
                                <a href="#" class="card-tittle">Immediate Start GP Required *Busy Medical Practice * - Cannon Hill, QLD</a>
                                <span class="jobtype">
                                    Full Time
                                </span>
                                <ul class="joblabels">
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        NON-DPA
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>70% / $140.00 Per Hour *
                                    </li>
                                    <li>
                                        <i class="far fa-clock"></i>
                                        7 days a week
                                    </li>

                                </ul>
                                <p>Are you looking to hit the ground running ? Enjoy been kept busy with a influx of patients? Wanting to work for a practice with fully...
                                    <a href="#">Read More</a>
                                </p>
                                <div class="bottombar">
                                    <a href="#" class="linkgreen">Quick Application</a>
                                    <span>|</span>
                                    <a href="#" class="linkblue">Apply Now</a>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>

                    </div>
                </div>
                <ul class="fixedbutton list-unstyled d-xl-none d-lg-none">
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
        </div>
    </div>
</section>


@include('partials._downloadApp', ['sociallinks' => $sociallinks])

@include('partials._footer', ['sociallinks' => $sociallinks])