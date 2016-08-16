@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>{{ trans('opportunity.create_opportunity_headline', ['workplace' => $workplace->name]) }}</h1>

  @include('opportunity.partials.edit_form')

@endsection