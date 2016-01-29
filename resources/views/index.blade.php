@extends('layouts.master')

@section('content')

  <h1>{{ trans('general.appname') }}</h1>

  <a href="{{ action('WorkplaceController@index') }}">{{ trans_choice('workplace.workplace', \Matchappen\Workplace::published()->count()) }}</a>

  <a href="{{ action('OpportunityController@index') }}">{{ trans_choice('opportunity.opportunity', \Matchappen\Opportunity::published()->count()) }}</a>

  @include('partials.mega-nav-item', [
    'itemModifier' => 'companies',
    'headline' => 'Spännande företag',
    'introText' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => [
        [
          'headline' => 'AD Headline',
          'text' => 'AD Text',
          'href' => '#adhref'
        ],
  [
          'headline' => 'AD Headline 2',
          'text' => 'AD Text 2',
          'href' => '#adhref'
        ]
      ]
    ])

@endsection