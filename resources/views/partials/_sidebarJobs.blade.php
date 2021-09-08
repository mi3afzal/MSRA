<div class="sidebar-job">
    <h4>Filter
        <a href="{{ route('front.job.clearsearch') }}">
            <span style="padding-left:55%; text-decoration:none;">Clear</span>
        </a>

    </h4>

    <form action="{{ route('front.job.search') }}" method="GET" enctype="multipart/form-data" id="job-filter-form">
        {{ method_field('GET') }}

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        JobType
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="innnerlist">
                            @if(isset($jobtypes))
                            @foreach($jobtypes as $jobt)
                            <li>
                                <a href="javascript:void(0);" class="js-filter" filter-name="jobtype" filter-val="{{ $jobt->id }}">{{ ucwords($jobt->jobtype) }}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Profession
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="innnerlist">
                            @if(isset($professions))
                            @foreach($professions as $profession)
                            <li>
                                <a href="javascript:void(0);" class="js-filter" filter-name="profession" filter-val="{{ $profession->id }}">{{ $profession->profession }}</a>
                            </li>
                            @endforeach
                            @endif
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
                            @if(isset($specialties))
                            @foreach($specialties as $specialty)
                            <li>
                                <a href="javascript:void(0);" class="js-filter" filter-name="specialty" filter-val="{{ $specialty->id }}">{{ $specialty->specialty }}</a>
                            </li>
                            @endforeach
                            @endif
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
                            @if(isset($states))
                            @foreach($states as $state)
                            <li>
                                <a href="javascript:void(0);" class="js-filter" filter-name="state" filter-val="{{ $state->id }}">{{ $state->name }}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="suburb" id="filter-suburb" val="" />
        <input type="hidden" name="cities" id="filter-cities" val="" />
        <input type="hidden" name="profession" id="filter-profession" val="" />
        <input type="hidden" name="specialty" id="filter-specialty" val="" />
        <input type="hidden" name="states" id="filter-state" val="" />
        <input type="hidden" name="jobtype" id="filter-jobtype" val="" />

    </form>
</div>
<script>
    $(document).ready(function() {
        $(".js-filter").click(function() {
            if ($(this).attr("filter-name") == "profession") {
                $("#filter-profession").val($(this).attr("filter-val"));
            } else if ($(this).attr("filter-name") == "specialty") {
                $("#filter-specialty").val($(this).attr("filter-val"));
            } else if ($(this).attr("filter-name") == "state") {
                $("#filter-state").val($(this).attr("filter-val"));
            } else if ($(this).attr("filter-name") == "jobtype") {
                $("#filter-jobtype").val($(this).attr("filter-val"));
            }

            document.getElementById("job-filter-form").submit();
        });

        // $(".js-filter").click(function() {
        //     if ($(this).attr("filter-name") == "profession") {
        //         localStorage.setItem("profession", $(this).attr("filter-val"));
        //         filterJobs("profession", $(this).attr("filter-val"));
        //     } else if ($(this).attr("filter-name") == "specialty") {
        //         localStorage.setItem("specialty", $(this).attr("filter-val"));
        //         filterJobs("specialty", $(this).attr("filter-val"));
        //     } else if ($(this).attr("filter-name") == "state") {
        //         localStorage.setItem("state", $(this).attr("filter-val"));
        //         filterJobs("state", $(this).attr("filter-val"));
        //     } else if ($(this).attr("filter-name") == "jobtype") {
        //         localStorage.setItem("jobtype", $(this).attr("filter-val"));
        //         filterJobs("jobtype", $(this).attr("filter-val"));
        //     }

        // });

        // function filterJobs(name, id) {
        //     const items = {
        //         ...localStorage
        //     };

        //     // console.log(items);
        //     return false;

        //     $.ajax({
        //         url: "{!! route('filterjobs') !!}",
        //         type: "POST",
        //         data: {
        //             name: name,
        //             id: id,
        //             _token: '{{csrf_token()}}'
        //         },
        //         // dataType: 'json',
        //         dataType: 'html',
        //         success: function(result) {
        //             // alert(result);
        //             console.log(result);
        //             $("#js-joblisting").html(result);
        //         }
        //     });
        // }

    });
</script>