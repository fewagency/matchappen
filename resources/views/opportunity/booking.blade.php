@extends('layouts.master', ['use_master_container' => true])

@section('content')
  <h1>{{ ucfirst(trans('opportunity.actions.book') . ' ' . $opportunity->name) }}</h1>
  @include('opportunity.partials.booking_form')
@endsection