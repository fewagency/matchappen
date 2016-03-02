<?php

  $headline = (!empty($headline) ? $headline : trans_choice('opportunity.opportunity', 2));

  $intro_text = (empty($intro_text) ? '' : $intro_text);

?>

@include('partials.mega-nav-item', [
    'intro_type' => (isset($intro_type) ? $intro_type : false),
    'main_href' => action('OpportunityController@index'),
    'item_modifiers' => ['opportunities'],
    'cta_icon' => trans('assets.opportunities-icon'),
    'headline' => $headline,
    'intro_text' => $intro_text,
    'sub_items' => $opportunities,
    'use_fold_effect' => false
    ])