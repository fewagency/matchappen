<?php

  $modifier_classes_string = '';

  if(isset($block_modifiers) && is_array($block_modifiers)) {

    foreach($block_modifiers AS $block_modifier) {

      $modifier_classes_string .= ' info-1--' . $block_modifier;

    }

  }

?>

<div class="info-1{{ $modifier_classes_string }}">

  <div class="row">

    <div class="col-md-3">
      <span class="info-1__headline">{{ $left_col_content }}:</span>
    </div>
    <div class="col-md-6">
      {!! $right_col_content !!}
    </div>

  </div>

</div>