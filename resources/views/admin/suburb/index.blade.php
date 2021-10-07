@extends('layouts.app')

@section('content')

@include('partials._datatableAssets')
@include('partials._select2Assests')
<section class="content">
    <div class="card">
        <div class="card-header">
            <!-- <h3 class="card-title">
                <a href="{{ route('admin.city.create') }}" class="btn btn-primary">
                    <i class="right fas fa-angle-left fa-lg"></i>&nbsp;
                    Add State
                </a>
            </h3> -->
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row" style="margin-bottom:10px;">
                <div class="col-lg-12 text-muted">
                    <div class="col-lg-4">
                        <h3>FILTERS</h3>
                    </div>
                </div>

            </div>

            <div class="row col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Suburb Name </label>
                        <input type="text" name="name" id="name" placeholder="Suburb Name" class="form-control" autocomplete="off" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control select2" placeholder="Select Status">
                            <option value="">Select Status</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="suburb-table">
                    <thead>
                        <th>S.No</th>
                        <th>SSC Code</th>
                        <th>Suburb</th>
                        <th>Urban Area</th>
                        <th>Postcode</th>
                        <th>State</th>
                        <th>State Name</th>
                        <th>Type</th>
                        <th>Local Goverment Area</th>
                        <th>Status</th>
                        <th width="100">Action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>



<script>
    var oTable = $('#suburb-table').DataTable({
        processing: true,
        "searching": true,
        serverSide: true,
        ajax: {
            url: "{!! route('suburb.datatables') !!}",
            data: function(d) {
                d.status = $('#status').val();
                d.name = $('#name').val();
            }
        },

        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'ssc_code',
                name: 'ssc_code'
            },
            {
                data: 'suburb',
                name: 'suburb'
            },
            {
                data: 'urban_area',
                name: 'urban_area'
            },
            {
                data: 'postcode',
                name: 'postcode'
            },
            {
                data: 'state',
                name: 'state'
            },
            {
                data: 'state_name',
                name: 'state_name'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'local_goverment_area',
                name: 'local_goverment_area'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, full, meta) {
                    if (data == 'Enabled') {
                        return "<span class='right badge badge-success p-1'>" + data + "</span>";
                    } else {
                        return "<span class='right badge badge-danger p-1'>" + data + "</span>";
                    }
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [
            [0, 'asc']
        ],
        searching: false,
        // bLengthChange:false,
    });

    $('#status').on('change', function(e) {
        oTable.draw();
        e.preventDefault();
    });
    $('#name').on('keyup', function(e) {
        oTable.draw();
        e.preventDefault();
    });
</script>

@endsection