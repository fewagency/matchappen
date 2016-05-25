@extends('layouts.master')

@section('content')

  @include('partials.text-block-1', [
    'headline_level' => 'h1',
    'headline' => 'Hej!',
    'text' =>
    'Här hittar du intressanta yrken och arbetsplatser i Malmö och kan boka möten till studiebesök.
<br>
Om du vill erbjuda studiebesök på din arbetsplats kan du <a href="'.action('Auth\AuthController@getLogin').'">logga in här</a>.'
  ])

  @if(count($workplaces))
    @include('partials.mega-nav-item', [
      'main_href' => action('WorkplaceController@index'),
      'item_modifiers' => ['companies'],
      'item_id' => 'companies',
      'use_fold_effect' => true,
      'cta_icon' => trans('assets.workplaces-icon'),
      'headline' => 'Arbetsplatser',
      'headline_level' => 2,
      'intro_text' => 'Kolla vilka arbetsplatser du kan besöka.',
      'sub_items' => $workplaces,
      'extra_sub_items' => [
        [
          'href' => action('WorkplaceController@index'),
          'text' => 'Se fler '.trans_choice('workplace.workplace', 2)
        ]
      ]
      ])
  @endif

  @if(count($occupations))
    @include('partials.mega-nav-item', [
      'main_href' => action('OccupationController@index'),
      'item_modifiers' => ['occupations'],
      'item_id' => 'occupations',
      'use_fold_effect' => true,
      'cta_icon' => trans('assets.occupations-icon'),
      'headline' => 'Yrken',
      'headline_level' => 2,
      'intro_text' => 'Bläddra bland yrken.',
      'sub_items' => $occupations,
      'extra_sub_items' => [
        [
          'href' => action('OccupationController@index'),
          'text' => 'Se fler '.trans_choice('occupation.occupation', 2)
        ]
      ]
    ])
  @endif

  @if(count($opportunities))
    @include('partials.mega-nav-item', [
        'main_href' => action('OpportunityController@index'),
        'item_modifiers' => ['opportunities'],
        'item_id' => 'opportunities',
        'use_fold_effect' => true,
        'cta_icon' => trans('assets.opportunities-icon'),
        'headline' => trans_choice('opportunity.opportunity',2),
        'headline_level' => 2,
        'intro_text' => 'Boka in ditt studiebesök.',
        'sub_items' => $opportunities,
        'extra_sub_items' => [
          [
            'href' => action('OpportunityController@index'),
            'text' => 'Se fler '.trans_choice('opportunity.opportunity', 2)
          ]
        ]
      ])
  @endif

@endsection