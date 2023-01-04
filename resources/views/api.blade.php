
@extends('ccv.base')

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
                        <input type="text" class="form-control" id="mspApiKey" name="api_key" placeholder="Enter MSP API Key"
                               value="{{$apiKey}}"
                        >
                    </div>
                    <div class="form-group pt-2">
                        <label for="mspENV" class="font-weight-bold">Environment:</label>
                        <select class="form-control" id="mspENV" name="environment">
                            @if($env === "Live")
                                <option value="Live" selected>Live</option>
                                <option value="Test">Test</option>
                            @else
                                <option value="Live">Live</option>
                                <option value="Test" selected>Test</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group pt-2">
                        @if($apiKey)
                            <label for="updatePaymethods" class="font-weight-bold">Update Gateways:</label>
                            <input type="checkbox" class="form-control" id="updatePaymethods" name="update_paymethods">
                        @else
                            <label for="updatePaymethods" class="font-weight-bold">Add Gateways:</label>
                            <input type="checkbox" class="form-control" id="updatePaymethods" name="update_paymethods" checked>
                        @endif
                    </div>
                    <div class="form-group pt-2">
                        <input type="hidden" class="form-control" id="publicKey" name="public_key" value="{{$publicKey}}">
                    </div>
                    <button type="submit" class="btn w-100 bg-multisafepay text-white">Install</button>
                </form>
            </div>
        </div>
    </div>
@stop
