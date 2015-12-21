@extends('layouts.master')

@section('content')

  <p>{{ $opportunity->description }}</p>

  @include('opportunity.partials.admin_edit_link')

@endsection