@extends('layouts.master')

@section('content')

  <h1>{{ $occupation->name }}</h1>

  <h2>{{ trans_choice('opportunity.opportunity', 2) }}</h2>
  @include('opportunity.partials.list', ['opportunities' => $occupation->opportunities()->viewable()->get() ])

  <h2>{{ trans_choice('workplace.workplace', 2) }}</h2>
  @include('workplace.partials.list', ['workplaces' => $occupation->workplaces()->published()->get() ])
@endsection