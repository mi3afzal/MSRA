@include('partials._header')

<section class=" innerbanner text-center" style="background: url(images/dreamjobbg.png) top center no-repeat;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="borderbox">
          <h3>Immediate Start GP Required
            *Busy Medical Practice * - Cannon Hill, QLD</h3>


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
        <div class="topheadingbar p-1">
          <h3><a href="#" class="btn btn-primary ">Apply Now</a><a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary ml-2 ">View Exact Practice Location</a></h3>
          <!-- Button trigger modal -->

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel">View Exact Practice Location</h6>
                  <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
                </div>
                <div class="modal-body">
                  <img src="images/watermarked.png" alt="" class="img-fluid">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#exampleModal1">Submit</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <!-- Modal -->
          <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModal1Label">Apply Now</h6>
                  <button type="button" class="btnclose" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">First Name</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Last Name</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Contact Number</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Current Place of Work</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Current AHPRA Registration</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Location</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Suburb</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">State</label>
                          <input type="text" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Post Code</label>
                          <input type="number" class="form-control">
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </div>

          <ul class="sociallinks list-unstyled">
            <li>
              Share:
            </li>
            <li>
              <a href="<?php echo $sociallinks->facebook; ?>" class="facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="<?php echo $sociallinks->linkedin; ?>" class="linkedin">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </li>
            <li>
              <a href="<?php echo $sociallinks->twitter; ?>" class="twitter">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li>
              <a href="<?php echo $sociallinks->google; ?>" class="google">
                <i class="fab fa-google"></i>
              </a>
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
                <h3 class="card-tittle">Immediate Start GP Required *Busy Medical Practice * - Cannon Hill, QLD</h3>
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
                <ul class="contentlist">
                  <li>
                    We are looking for you!! Yes You!
                  </li>
                  <li>
                    We are looking for experienced General Practitioner to join our established friendly Chapel Hill Practice.
                  </li>
                  <li>
                    Located within a busy shopping district, offering a large patient data base.
                  </li>
                  <li> We are looking for the next Gp to join our team. Is that you? </li>
                </ul>

                <h4>
                  Practice Offer
                </h4>
                <ul class="contentlist">

                  <li>* QML Pathology Onsite </li>

                  <li>* Close to Private & Public Schools</li>

                  <li>* Close to Day Care Services</li>

                  <li>* Close to Mt Cootha walking tracks & Botanical Gardens</li>

                  <li>* Bulk Billing</li>

                  <li>* Open 7 days (8.00 am – 5.00pm)</li>

                  <li>* 70% or $140.00 per Hour for first 3 Months</li>

                  <li>* Full time Nursing support</li>

                  <li>* Comprehensive allied health services on-site</li>

                  <li>* Flexible working hours</li>

                  <li>* Best Practice software with online booking</li>

                  <li>* Nursing support to assist with the delivery of treatment plans, wound care, vaccines, immunization, ear syringing, and health assessments</li>

                  <li>* Fully supported by reception & admin staff</li>



                </ul>
                <h4>Essential Criteria</h4>

                <ul class="contentlist">

                  <li>* VR GP with FRACGP/FACRRM </li>

                  <li>* GP registrars with eligibility for limited/provisional registration with AHPRA </li>

                  <li>* MBBS </li>

                  <li>* Transfer DPAs available for restricted or Locum GPs to rotate till the moratorium is over. </li>

                  <li>* Working in afterhours home visiting under the AMDS also available to make extra income. </li>

                  <li>* Relocation allowance considered for interstate candidates. We can help with arrangements. </li>

                  <li>* Strong verbal and written communication skills </li>

                  <li>* Passion and commitment to providing a high level of care to patients </li>

                  <li>* Attention to Detail, empathy & the upmost patience. </li>

                </ul>
                <div class="btmbar">
                  <ul>
                    <li>
                      <a href="#" class="btn btn-primary">Quick Application</a>
                    </li>
                    <li>
                      <a href="#" class="btn btn-default">Apply Now</a>
                    </li>
                  </ul>
                </div>


              </div>

              <div class="card text-center pb-0 contactdetails">
                <h5>
                  *If you need any information regarding this position or any other positions available in Australia, Please contact MSRA (Med Staff Recruitment Australia)*
                </h5>
                <a href="#" class="weblink">
                  <span>
                    <img src="images/web.png" alt="">
                  </span>
                  www.msra.com.au
                </a>
                <br>
                <a href="#" class="phonelink">
                  <span>
                    <img src="images/phonebg.png" alt="">
                  </span>
                  0410 863 301
                </a>
                <div class="btmbar">
                  <p>* Please Note That No Applications Will Be Entertained From Those Who Are Living Outside Australia.</p>
                </div>
              </div>

              <div class="bluecard">
                <h4>Contact Us</h4>
                <p>If you need any other details about this job, please get in touch with us either via email or contact number as below</p>
                <ul class="buttonlist">
                  <li>
                    <a href="#" class="btn btn-default">enquiries@msra.com.au</a>

                  </li>
                  <li> <a href="#" class="btn btn-default">+61 410 863 301</a></li>
                </ul>
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

@include('partials._footer',['sociallinks' => $sociallinks])