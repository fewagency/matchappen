@extends('layouts.master')

@section('content')

  <h1>{{ trans_choice('opportunity.opportunity', \Matchappen\Opportunity::published()->count()) }}</h1>

  @include('opportunity.partials.list')

@endsection