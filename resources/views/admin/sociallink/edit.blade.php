@extends('layouts.app')

@section('content')
<?php
// echo "<pre>";
// print_r($listings->facebook);
// die;
?>
<form action="{{ route('admin.sociallink.update', $listings->id) }}" method="POST" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    @csrf
    <section class="content">
        <div class="card ">
            <div class="card-header">
                <h3 class="card-title">
                    &nbsp;
                </h3>

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
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" name="facebook" id="facebook" class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" value="{{ old('facebook', $listings->facebook) }}" placeholder="Facebook" autocomplete="off" />
                            @if($errors->has('facebook'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('facebook') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" name="twitter" value="{{ old('twitter', $listings->twitter) }}" id="twitter" class="form-control {{ $errors->has('twitter') ? 'is-invalid' : '' }}" placeholder="Twitter" autocomplete="off" />
                            @if($errors->has('twitter'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('twitter') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="linkedin">LinkedIn</label>
                            <input type="text" name="linkedin" value="{{ old('linkedin', $listings->linkedin) }}" id="linkedin" class="form-control {{ $errors->has('linkedin') ? 'is-invalid' : '' }}" placeholder="LinkedIn" autocomplete="off" />
                            @if($errors->has('linkedin'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('linkedin') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $listings->instagram) }}" id="instagram" class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" placeholder="Instagram" autocomplete="off" />
                            @if($errors->has('instagram'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('instagram') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="google">Google</label>
                            <input type="text" name="google" value="{{ old('google', $listings->google) }}" id="google" class="form-control {{ $errors->has('google') ? 'is-invalid' : '' }}" placeholder="Google" autocomplete="off" />
                            @if($errors->has('google'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('google') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="google_play">Google Play</label>
                            <input type="text" name="google_play" value="{{ old('google_play', $listings->google_play) }}" id="google_play" class="form-control {{ $errors->has('google_play') ? 'is-invalid' : '' }}" placeholder="Google Play" autocomplete="off" />
                            @if($errors->has('google_play'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('google_play') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="apple_store">Apple Store</label>
                            <input type="text" name="apple_store" value="{{ old('apple_store', $listings->apple_store) }}" id="apple_store" class="form-control {{ $errors->has('apple_store') ? 'is-invalid' : '' }}" placeholder="Apple Store" autocomplete="off" />
                            @if($errors->has('apple_store'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('apple_store') }}</strong>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>

        </div>
    </section>
</form>

@endsection