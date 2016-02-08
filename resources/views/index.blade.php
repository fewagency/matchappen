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
    'headline' => 'Spännande företag',
    'intro_text' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => [
        [
          'headline' => 'AD Headline',
          'text' => 'AD Lorem ipsum dolor sit amet. Vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.',
          'href' => '#adhref'
        ],
        [
          'headline' => 'Web Developer',
          'text' => 'Excepteur sint occaecat cupidatat non proident, web developsum.',
          'href' => '#webdevhref'
        ],
        [
          'headline' => 'Creative Director',
          'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, CD.',
          'href' => '#cdhref'
        ],
        [
          'headline' => 'CEO',
          'text' => 'Nemo enim CEO ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Nemo enim CEO ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.',
          'href' => '#ceohref'
        ],
        [
          'headline' => 'Copywriter',
          'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, copy.',
          'href' => '#copyhref'
        ]
      ],
      'extra_sub_items' => [
      [
        'href' => action('WorkplaceController@index'),
        'text' => 'Se fler spännande företag'
      ]
    ]
    ])

  @include('partials.mega-nav-item', [
    'main_href' => '#', //action('OccupationController@index'),
    'item_modifier' => 'occupations',
    'cta_icon' => base_path() . '/public/images/handshake-1-noun_153518.svg',
    'headline' => 'Spännande yrken',
    'intro_text' => 'Läs om lorem ipsum dolor sit amet',
    'sub_items' => [
      [
        'headline' => 'AD Headline',
        'text' => 'AD Lorem ipsum dolor sit amet. Vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.',
        'href' => '#adhref'
      ],
      [
        'headline' => 'Web Developer',
        'text' => 'Excepteur sint occaecat cupidatat non proident, web developsum.',
        'href' => '#webdevhref'
      ],
      [
        'headline' => 'Creative Director',
        'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, CD.',
        'href' => '#cdhref'
      ],
      [
        'headline' => 'CEO',
        'text' => 'Nemo enim CEO ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.',
        'href' => '#ceohref'
      ],
      [
        'headline' => 'Copywriter',
        'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, copy.',
        'href' => '#copyhref'
      ]
    ],
    'extra_sub_items' => [
      [
        'href' => '#', //action('OccupationController@index'),
        'text' => 'Se fler spännande yrken'
      ]
    ]
  ])

  @include('partials.mega-nav-item', [
      'main_href' => action('OpportunityController@index'),
      'item_modifier' => 'opportunities',
      'cta_icon' => base_path() . '/public/images/speech-bubbles-1-noun_70008.svg',
      'headline' => 'Mötestider',
      'intro_text' => 'Läs om lorem ipsum dolor sit amet',
      'sub_items' => [
        [
          'headline' => 'AD Headline',
          'text' => 'AD Lorem ipsum dolor sit amet. Vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.',
          'href' => '#adhref'
        ],
        [
          'headline' => 'Web Developer',
          'text' => 'Excepteur sint occaecat cupidatat non proident, web developsum.',
          'href' => '#webdevhref'
        ],
        [
          'headline' => 'Creative Director',
          'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, CD.',
          'href' => '#cdhref'
        ],
        [
          'headline' => 'CEO',
          'text' => 'Nemo enim CEO ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.',
          'href' => '#ceohref'
        ],
        [
          'headline' => 'Copywriter',
          'text' => 'Reprehenderit qui in ea voluptate velit esse quam nihil molestiae, copy.',
          'href' => '#copyhref'
        ]
      ],
      'extra_sub_items' => [
        [
          'href' => action('OpportunityController@index'),
          'text' => trans_choice('opportunity.opportunity', \Matchappen\Opportunity::published()->count())
        ]
      ]
    ])

@endsection