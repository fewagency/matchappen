@extends('layouts.master')

@section('content')

  @include('partials.mega-nav-item', [
      'main_href' => action('OpportunityController@index'),
      'item_modifiers' => ['occupations'],
      'cta_icon' => base_path() . '/public/images/handshake-1-noun_153518.svg',
      'headline' => trans_choice('occupation.occupation', 2),
      'intro_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      'sub_items' => $occupations,
      'use_fold_effect' => false
      ])

@endsection