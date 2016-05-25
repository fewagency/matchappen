@extends('layouts.master', [
  'body_class' => 'list-view'
])

@section('content')

  @include('opportunity.partials.list', [
    'intro_type' => 2,
    'intro_text' => "Just nu finns det ".$number_of_bookable_opportunities." ".trans_choice('opportunity.opportunity', $number_of_bookable_opportunities)." som du kan boka.",
  ])

@endsection