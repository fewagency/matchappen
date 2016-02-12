@include('partials.mega-nav-item', [
      'main_href' => action('WorkplaceController@index'),
      'item_modifiers' => ['companies'],
      'cta_icon' => trans('assets.workplaces-icon'),
      'headline' => trans_choice('workplace.workplace', 2),
      'intro_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      'sub_items' => $workplaces,
      'use_fold_effect' => false
      ])