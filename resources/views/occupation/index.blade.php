@extends('layouts.master')

@section('content')

  <h1>{{ trans_choice('general.occupation', $occupations->count()) }}</h1>

  @include('occupation.partials.list')

@endsection