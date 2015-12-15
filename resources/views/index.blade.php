@extends('layouts.master')

@section('content')

  <h1>Index</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans('general.workplaces') }}</a>

@endsection