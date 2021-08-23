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
                <div class="sidebar-job">
                    <h4>Filter</h4>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Profession
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="innnerlist">
                                        <li>
                                            <a href="#">Allied Health Professionals</a>
                                        </li>
                                        <li>
                                            <a href="#">Doctor</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Healthcare Executives
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">Nurse</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Specialty
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="innnerlist">
                                        <li class=""><a href="#">Anesthetics</a></li>
                                        <li class=""><a href="#">Emergency Medicine</a></li>
                                        <li class=""><a href="#">General Practice</a></li>
                                        <li class=""><a href="#">Intensive care</a></li>
                                        <li class=""><a href="#">Medicine</a></li>
                                        <li class=""><a href="#">Obtetrics &amp; Gyneacology</a></li>
                                        <li class=""><a href="#">Pathologist</a></li>
                                        <li class=""><a href="#">Peadiatrics</a></li>
                                        <li class=""><a href="#">Psychiatry</a></li>
                                        <li class=""><a href="#">Radiology</a></li>
                                        <li class=""><a href="#">Surgery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Locations
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="innnerlist">

                                        <li><a href="#"> Victoria </a></li>
                                        <li><a href="#"> Queensland</a></li>
                                        <li><a href="#"> South Australia</a></li>
                                        <li><a href="#"> Tasmania</a></li>
                                        <li><a href="#"> New South Wales</a></li>
                                        <li><a href="#"> Australian Capital Territory</a></li>
                                        <li><a href="#"> Western Australia</a></li>
                                        <li><a href="#"> Northern Territory</a></li>
                                        <li><a href="#"> South Australia</a></li>
                                        <li><a href="#"> Queensland</a></li>
                                        <li><a href="#"> New South Wales</a></li>
                                        <li><a href="#"> Tasmania</a></li>
                                        <li><a href="#"> Queensland</a></li>
                                        <li><a href="#"> Victoria</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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


<section class="downloadapp">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h2>Download The App</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam possimus eaque magnam eum praesentium unde.</p>
                <ul class="list-unstyled">
                    <li><img src="images/appstore.png" alt=""></li>
                    <li><img src="images/googleplay.png" alt=""></li>
                </ul>
            </div>
        </div>
    </div>
</section>


@include('partials._footer')