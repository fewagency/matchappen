@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <a href="{{ action('WorkplaceController@show', $workplace) }}">Hur ser din arbetsplats ut för andra?</a>

  <!-- TODO: link to add opportunity -->
  <!-- TODO: display active opportunities to workplace user -->

  @include('workplace.partials.admin_edit_link')

@endsection