@extends('layouts.master', ['use_master_container' => true])

@section('content')
  <h1>Validera din inloggningslänk</h1>
  @include('auth.partials.token_login_form')
@endsection