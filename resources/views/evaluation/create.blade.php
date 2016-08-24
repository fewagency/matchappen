@extends('layouts.master', ['use_master_container' => true])

@section('content')
  <h1>{{ trans('evaluation.opportunity_evaluation_headline', ['opportunity' => $opportunity->name]) }}</h1>
  @include('evaluation.partials.evaluation_form')
@endsection