
@extends('Lightspeed.base')

@section('content')
    @parent
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(session('success'))
        <div class="alert alert-success container text-center">
            {{session('success')}}
        </div>
    @endif
    <div class="offset-md-3 col-md-6 col-sm-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div>
                    <p class="block text-base font-medium text-gray-700 my-1 font-weight-bold"> Thank you for installing the
                        MultiSafepay
                        Payments app! </p>
                    <p class="block text-sm font-small text-gray-700 my-1 mb-2">
                        Before we can get started we need some more info about you and your MultiSafepay
                        details.
                    </p>
                </div>
                <form method="POST" action="{{route('ccv.setup.install')}}">
                    @method('PUT')
                    @csrf

                    <div class="form-group pt-2">
                        <p class="block text-base font-medium text-gray-700 my-1 font-weight-bold">API Settings</p>
                        <label for="mspApiKey" class="font-weight-bold">MultiSafepay API key:</label>
                        <input type="text" class="form-control" id="mspApiKey" name="api_key" placeholder="Enter MSP API Key">
                    </div>
                    <div class="form-group pt-2">
                        <input type="hidden" class="form-control" id="mspApiKey" name="public_key" value="{{$apiKey}}">
                    </div>
                    <button type="submit" class="btn w-100 bg-multisafepay text-white">Install</button>
                </form>
            </div>
        </div>
    </div>
@stop
