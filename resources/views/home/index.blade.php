@extends('layouts.main')

@section('header')

@section('title', 'TCGplayer Card Wiki')

@section('body')
    <center>
        <h1>Card Wiki</h1>
    </center>
    <p>
        This is a simple example project utilizing TCGplayer API integration. Inside you will find a lot of practical applications for the API.
    </p>
    <p>
        The project utilizes vue.js, the Laravel framework for PHP including blade templating, and a TCGplayer API package. It is all bundled up using Browserify and gulp and installed by npm.
    </p>
    <p>
        Search for a card:
        {{ Form::open(array('url' => 'card')) }}
            {{ Form::token() }}
            {{ Form::select('category', $categories) }}
            {{ Form::text('cardName', 'Card Name') }}
        {{ Form::close() }}
    </p>
@endsection
