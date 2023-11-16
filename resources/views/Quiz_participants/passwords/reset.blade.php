@if (session()->has('number'))
@extends('layouts.app')
@section('content')
<style>
    .invalid{
        color: red;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-10">
                        {{ __('Reset Password') }}
                        </div>
                        <div class="col-sm-2">
                            <a href="{{ url()->previous() }}" class="btn btn-primary back-btn">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">                  
                    <form  method="POST" action="{{ route('otp_verification') }}" >
                        @csrf

                        <div class="row mb-3">                          
                            <label for="otp" class="col-md-4 col-form-label text-md-end">{{ __('OTP') }}</label>
                            <div class="col-md-6">
                                <input id="otp" type="number" class="form-control @error('otp') is-invalid @enderror" name="otp">
                                <input type="hidden" name="slug" value="{{ $slug }}">

                                @if(session()->has('error'))
                                <div class="invalid">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            @if(session()->has('success'))
                            <div class="invalid">
                                {{ session()->get('success') }}
                            </div>
                              @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify OTP') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@else
<script>
window.location.href = "/forget_password/{{ $slug }}"</script>
@endif