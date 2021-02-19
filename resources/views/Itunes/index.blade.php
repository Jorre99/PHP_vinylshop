@extends('layouts.template')

@section('title', 'ITunes')

@section('main')
    <h1>iTunes {{ $titel }}</h1>
    <div class="row equal">
        @foreach($resultaten as $resultaat)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3 ">
                <div class="card mb-3 shadow">
                    <img class="card-img-top" src="{{ $resultaat['artworkUrl100']}}" alt=" {{ $resultaat['artistName'] }} - {{ $resultaat['name']}}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $resultaat['artistName'] }}</h5>
                        <p class="card-subtitle mb-2 text-muted">{{ $resultaat['name']}}</p>
                        <hr>
                        <p>
                            <span class="text-muted">Genre</span>: {{ $resultaat['genres'][0]['name']}}<br>
                            <span class="text-muted">Artist URL</span>: <a href="{{ $resultaat['artistUrl']}}" target="_blank">{{ $resultaat['artistName'] }} </a><br>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <p>Last updated: {{ Carbon\Carbon::parse($update)->format('F j Y') }}</p>

@endsection
