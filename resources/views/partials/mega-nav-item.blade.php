{{--

The sum of items in $sub_items + $extra_sub_items should be an even number

--}}

<?php
  $mega_nav_item_id = 'few-paperfold-' . $item_modifier;
?>

<section class="mega-nav-item mega-nav-item--{{ $item_modifier }}">

  <div class="container">
    <div class="row">
      <div class="col-lg-offset-1 col-lg-10">

        <a href="{{ $main_href }}" class="mega-nav-item__link" data-fewaccordiontarget="{{ $mega_nav_item_id }}">
          <div class="mega-nav-item__intro">
            <?php require($cta_icon); ?>
            <h2 class="mega-nav-item__intro-headline">{{ $headline }}</h2>
            <div class="mega-nav-item__intro-text">{{ $intro_text }}</div>
          </div>
          <div class="mega-nav-item__cta">
            <?php include(base_path() . '/public/images/arrow-1-noun_256216.svg'); ?>
          </div>
        </a>

      </div>
    </div>
  </div>

  <div class="mega-nav-item__sub-items-wrapper few-paperfold-wrapper" id="{{ $mega_nav_item_id }}">
    <ul class="mega-nav-item__sub-items">

      {{-- Make sure that the nr of sub items is an even number --}}
      @foreach($sub_items AS $sub_item)

        <li class="few-paperfold-item mega-nav-item__sub-item">
          <a href="{{ $sub_item['href'] }}" class="mega-nav-item__sub-item-link">
            <div class="mega-nav-item__sub-item-wrapper-1">
                <div class="mega-nav-item__sub-item-text-wrapper">
                  <b class="mega-nav-item__sub-item-headline">{{ $sub_item['headline'] }}</b>
                  <div class="mega-nav-item__sub-item-text">{{ $sub_item['text'] }}</div>
                </div>
                <div class="mega-nav-item__sub-item-cta">
                  <?php include(base_path() . '/public/images/arrow-1-noun_256216.svg'); ?>
                </div>
            </div>
          </a>
        </li>

      @endforeach

    </ul>


    @if(isset($extra_sub_items))

      @foreach($extra_sub_items AS $extra_sub_item)
        <a href="{{ $extra_sub_item['href'] }}" class="few-paperfold-item mega-nav-item__extra-sub-item">{{ $extra_sub_item['text'] }}</a>
      @endforeach

    @endif

  </div>

</section>