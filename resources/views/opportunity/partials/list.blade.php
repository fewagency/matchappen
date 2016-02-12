@include('partials.mega-nav-item', [
    'main_href' => action('OpportunityController@index'),
    'item_modifiers' => ['opportunities'],
    'cta_icon' => trans('assets.opportunities-icon'),
    'headline' => trans_choice('opportunity.opportunity', 2),
    'intro_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    'sub_items' => $opportunities,
    'use_fold_effect' => false
    ])