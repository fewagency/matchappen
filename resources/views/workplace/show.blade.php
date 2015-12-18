@extends('layouts.master')

@section('content')

  <h1>{{ $workplace->name }}</h1>

  <p>{{ $workplace->description }}</p>

  <!-- TODO: link to edit workplace if permissions -->
@endsection