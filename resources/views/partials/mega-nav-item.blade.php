{{--

The sum of items in $sub_items + $extra_sub_items should be an even number

If you want to use the paperfold effect, make sure that you have set $use_fold_effect to true
and that $item_id has a value that is unique across all mega nav items on the page.

--}}

<?php

    $mega_nav_item_id = false;
    if(isset($item_id) && $item_id !== false) {
      $mega_nav_item_id = 'few-paperfold-' . $item_id;
    }

    $item_modifier_classes = '';
    if(!empty($item_modifiers)) {

      foreach($item_modifiers AS $item_modifier) {

        $item_modifier_classes .= ' mega-nav-item--' . $item_modifier;

      }

    }

    if(!isset($headline_level)) {
      $headline_level = '1';
    }

    if(isset($main_href) && $main_href !== false) {

    }

    if(isset($simple_intro) && $simple_intro === true) {

      $item_modifier_classes .= ' mega-nav-item--simple-intro';

    }

?>

<section class="mega-nav-item{{ $item_modifier_classes }}">

  @if(isset($simple_intro) && $simple_intro === true)

    <div class="container mega-nav-item__simple-intro">
      <div class="row">
        <div class="col-xs-12">
          <h{{ $headline_level }} class="mega-nav-item__intro-headline">{{ $headline }}</h{{ $headline_level }}>
        </div>
      </div>
    </div>

  @else

  <div class="container">
    <div class="row">
      <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">

        <a href="{{ $main_href }}" class="mega-nav-item__intro-wrapper"{!! ($use_fold_effect ? ' data-fewaccordiontarget="' . $mega_nav_item_id . '"' : '') !!}>
          <div class="mega-nav-item__intro">
            <?php require($cta_icon); ?>
            <h{{ $headline_level }} class="mega-nav-item__intro-headline">{{ $headline }}</h{{ $headline_level }}>
            <div class="mega-nav-item__intro-text">{{ ucfirst($intro_text) }}</div>
          </div>

          @if($use_fold_effect)
          <div class="mega-nav-item__cta">
            <?php include(base_path() . '/public/images/arrow-1-noun_256216.svg'); ?>
          </div>
          @endif
        </a>

      </div>
    </div>
  </div>

  @endif

  <div class="mega-nav-item__sub-items-wrapper few-paperfold-wrapper"{!! ($mega_nav_item_id !== false ? 'id="' . $mega_nav_item_id .'"' : '') !!}'>
    <ul class="mega-nav-item__sub-items">

      {{-- Make sure that the nr of sub items is an even number --}}
      @foreach($sub_items AS $sub_item)

        @include('partials.mega-nav-item-sub-item')

      @endforeach

    </ul>


    @if(isset($extra_sub_items))

      @foreach($extra_sub_items AS $extra_sub_item)
        <a href="{{ $extra_sub_item['href'] }}" class="few-paperfold-item mega-nav-item__extra-sub-item">{{ $extra_sub_item['text'] }}</a>
      @endforeach

    @endif

  </div>

</section>