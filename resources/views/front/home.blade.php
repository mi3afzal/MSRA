@include('partials._header')



<section class="top-banner" style="background: url(images/dreamjobbg.png) top center no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <form action="{{ route('front.job.search') }}" method="GET" enctype="multipart/form-data">
                    {{ method_field('GET') }}
                    @csrf
                    <input type="hidden" name="profession" id="filter-profession" val="" />
                    <input type="hidden" name="specialty" id="filter-specialty" val="" />
                    <div class="borderbox">
                        <h2>GP Requirements in Australia</h2>
                        <ul>
                            <li>
                                <div class="form-group">
                                    <select name="jobtype" id="jobtype" class="form-control">
                                        <option value="">Select Job Type</option>
                                        @foreach($jobtypes as $id => $jobtype)
                                        <option value="{{ $id }}">{{ ucwords($jobtype) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="form-group">
                                    <select name="states" id="states" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach($states as $key => $value)
                                        <option value="{{ $value->id }}">{{ ucwords($value->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div id="city_div">
                                    <div class="form-group">
                                        <select name="cities" id="cities" class="form-control">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div id="suburb_div">
                                    <div class="form-group">
                                        <select name="suburbs" id="suburbs" class="form-control">
                                            <option value="">Select Suburb</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="btnbar">
                            <button class="btn btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<section class="joblocation">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-12">
                <h2>MSRA Provide You</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>


        </div>
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <div class="bluebox">
                    <h3>Find GP <strong>Jobs Australia</strong></h3>
                    <div id="map"></div>
                    <h4>Permanent / Locum / AfterHours
                        / Full Time / Part Time </h4>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="practicebox">
                    <h3>Practice <strong>Acquisition</strong></h3>
                    <ul class="btnlist list-unstyled">
                        <li>
                            <a href="javascript:void(0);">Buy</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Sell</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Startup</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">manage</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">license</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="btn btn-default">
                                more
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="healthcarestaff">
                    <h3><strong>Healthcare</strong> Staff</h3>
                    <ul class="healthlist list-unstyled">
                        <li>
                            <a href="javascript:void(0);">Nurses</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Allied Health</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Practice manager</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">Recruitment</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-md-12">
                <div class="practiceowners">
                    <h3>Practice Owners</h3>
                    <a href="javascript:void(0);" class="btn btn-primary">Cleaning</a>
                    <a href="javascript:void(0);" class="btn btn-primary">DM</a>
                    <a href="javascript:void(0);" class="btn btn-primary">Acounting</a>
                </div>
                <div class="servicesbox">
                    <h3>Services</h3>
                    <ul class="serviceslist">
                        <li><a href="javascript:void(0);">Service-1</a></li>
                        <li><a href="javascript:void(0);">Service-2</a></li>
                        <li><a href="javascript:void(0);">Service-3</a></li>
                        <li><a href="javascript:void(0);">Service-4</a></li>
                        <li><a href="javascript:void(0);">Service-5</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._downloadApp', ['sociallinks' => $sociallinks])

<script>
    $(document).ready(function() {
        var states_id = $("#states").val();

        $('#states').on('change', function() {
            var state_id = this.value;
            getcities(state_id);
            getasuburbs(state_id);
        });

        function getcities(state_id) {
            $.ajax({
                url: "{!! route('getcities') !!}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'html',
                success: function(result) {
                    $("#city_div").html(result);
                }
            });
        }

        function getasuburbs(state_id) {
            $.ajax({
                url: "{!! route('getasuburbs') !!}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'html',
                success: function(result) {
                    $("#suburb_div").html(result);
                }
            });
        }
    });
</script>

@include('partials._footer', ['sociallinks' => $sociallinks])