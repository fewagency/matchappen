@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>Redigera {{ $opportunity->name }}</h1>

  @include('opportunity.partials.edit_form')

@endsection