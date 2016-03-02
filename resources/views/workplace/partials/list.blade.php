<?php

  $headline = (!empty($headline) ? $headline : trans_choice('workplace.workplace', 2));

  $intro_text = (empty($intro_text) ? '' : $intro_text);

?>

@include('partials.mega-nav-item', [
    'intro_type' => (isset($intro_type) ? $intro_type : false),
    'main_href' => action('WorkplaceController@index'),
    'item_modifiers' => ['companies'],
    'cta_icon' => trans('assets.workplaces-icon'),
    'headline' => $headline,
    'intro_text' => $intro_text,
    'sub_items' => $workplaces,
    'use_fold_effect' => false
])