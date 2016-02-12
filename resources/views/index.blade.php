@extends('layouts.master')

@section('content')

  @include('partials.text-block-1', [
    'headline_level' => 'h1',
    'headline' => 'Hej!',
    'text' => '<p>Lorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'
  ])

  @include('partials.mega-nav-item', [
    'main_href' => action('WorkplaceController@index'),
    'item_modifiers' => ['companies'],
    'item_id' => 'companies',
    'use_fold_effect' => true,
    'cta_icon' => trans('assets.workplaces-icon'),
    'headline' => 'Spännande arbetsplatser',
    'headline_level' => 2,
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
    'item_modifiers' => ['occupations'],
    'item_id' => 'occupations',
    'use_fold_effect' => true,
    'cta_icon' => trans('assets.occupations-icon'),
    'headline' => 'Spännande yrken',
    'headline_level' => 2,
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
      'item_modifiers' => ['opportunities'],
      'item_id' => 'opportunities',
      'use_fold_effect' => true,
      'cta_icon' => trans('assets.opportunities-icon'),
      'headline' => trans_choice('opportunity.opportunity',2),
      'headline_level' => 2,
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