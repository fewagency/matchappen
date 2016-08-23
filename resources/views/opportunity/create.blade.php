@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>{{ trans('opportunity.create_opportunity_headline', ['workplace' => $workplace->name]) }}</h1>
  <p>
    Här annonserar du studiebesök på din arbetsplats.
    Beskriv kort vad eleverna får uppleva och lära under besöket.
    Bestäm datum och klockslag för besöket, sista anmälningsdag samt antal elever som kan delta i besöket.
  </p>

  @include('opportunity.partials.edit_form')

@endsection