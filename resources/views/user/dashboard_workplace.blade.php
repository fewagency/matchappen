@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <a href="{{ action('WorkplaceController@show', $workplace) }}">Hur ser din arbetsplats ut för andra?</a>

  <!-- TODO: display workplace info to workplace user -->
  <!-- TODO: link to edit workplace -->

  <!-- TODO: display active opportunities to workplace user -->
  <!-- TODO: link to add opportunity -->
@endsection