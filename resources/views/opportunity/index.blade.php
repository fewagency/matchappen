@extends('layouts.master')

@section('content')

  <h1>{{ trans_choice('opportunity.opportunity', $opportunities->count()) }}</h1>

  @include('opportunity.partials.list')

@endsection