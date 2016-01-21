@extends('layouts.master')

@section('content')

  <h1>{{ trans_choice('workplace.workplace', \Matchappen\Workplace::published()->count()) }}</h1>

  @include('workplace.partials.list')

@endsection