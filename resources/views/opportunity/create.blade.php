@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>{{ trans('opportunity.create_opportunity_headline') }}</h1>

  @include('opportunity.partials.edit_form')

@endsection