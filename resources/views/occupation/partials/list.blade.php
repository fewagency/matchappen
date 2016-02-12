@include('partials.mega-nav-item', [
    'main_href' => action('OccupationController@index'),
    'item_modifiers' => ['occupations'],
    'cta_icon' => trans('assets.occupations-icon'),
    'headline' => trans_choice('occupation.occupation', 2),
    'intro_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'sub_items' => $occupations,
    'use_fold_effect' => false
    ])