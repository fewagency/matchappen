@extends('layouts.master')

@section('content')

  @include('partials.text-block-1', [
    'headline_level' => 'h1',
    'headline' => 'Hej!',
    'text' => '<p>Lorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
  ])

  @include('partials.mega-nav-item', [
    'main_href' => action('WorkplaceController@index'),
    'item_modifier' => 'companies',
    'cta_icon' => base_path() . '/public/images/portfolio.svg',
    'headline' => 'Spännande arbetsplatser',
    'intro_text' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => $workplaces,
    'extra_sub_items' => [
      [
        'href' => action('WorkplaceController@index'),
        'text' => 'Se fler spännande '.trans_choice('workplace.workplace', 2)
      ]
    ]
    ])

  @include('partials.mega-nav-item', [
    'main_href' => action('OccupationController@index'),
    'item_modifier' => 'occupations',
    'cta_icon' => base_path() . '/public/images/handshake-1-noun_153518.svg',
    'headline' => 'Spännande yrken',
    'intro_text' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => $occupations,
    'extra_sub_items' => [
      [
        'href' => action('OccupationController@index'),
        'text' => 'Se fler spännande '.trans_choice('occupation.occupation', 2)
      ]
    ]
  ])

  @include('partials.mega-nav-item', [
      'main_href' => action('OpportunityController@index'),
      'item_modifier' => 'opportunities',
      'cta_icon' => base_path() . '/public/images/speech-bubbles-1-noun_70008.svg',
      'headline' => trans_choice('opportunity.opportunity',2),
      'intro_text' => 'Läs om lorem ipsum dolor sit amet',
      'sub_items' => $opportunities,
      'extra_sub_items' => [
        [
          'href' => action('OpportunityController@index'),
          'text' => 'Se fler spännande '.trans_choice('opportunity.opportunity', 2)
        ]
      ]
    ])

@endsection