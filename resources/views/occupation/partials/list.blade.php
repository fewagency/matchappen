<?php

  $headline = (!empty($headline) ? $headline : trans_choice('occupation.occupation', 2));

  $intro_text = (empty($intro_text) ? '' : $intro_text);

?>

@include('partials.mega-nav-item', [
    'main_href' => action('OccupationController@index'),
    'item_modifiers' => ['occupations'],
    'cta_icon' => trans('assets.occupations-icon'),
    'headline' => $headline,
    'intro_text' => $intro_text,
    'sub_items' => $occupations,
    'use_fold_effect' => false
    ])