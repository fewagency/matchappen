@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.opportunities') }}</h1>

  @include('opportunity.partials.list')

@endsection