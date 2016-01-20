@extends('layouts.master')

@section('content')

  <h2>Nya företag</h2>

  @include('workplace.partials.list', ['workplaces' => $new_workplaces])

@endsection