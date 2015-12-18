@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.workplaces') }}</h1>

  @include('workplace.partials.workplace_list')

@endsection