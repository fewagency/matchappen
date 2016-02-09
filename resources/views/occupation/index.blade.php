@extends('layouts.master')

@section('content')

  <h1>{{ trans_choice('occupation.occupation', $occupations->count()) }}</h1>

  @include('occupation.partials.list')

@endsection