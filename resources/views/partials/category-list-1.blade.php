<?php

$pills_html = '<ul class="category-list-1 category-list-1--' . $block_modifier . '">';

foreach($items as $item) {

  $pills_html .= '<li role="presentation"><a href="' . $item['href'] . '">' . $item['name'] . '</a></li>';
}

$pills_html .= '</ul>';

?>

@include('partials.info-1', [
  'block_modifiers' => ['category-list-1-wrapper'],
  'left_col_content' => $headline,
  'right_col_content' => $pills_html
])