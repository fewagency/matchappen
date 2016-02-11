<li class="few-paperfold-item mega-nav-item__sub-item">
  <div>
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
  </div>
</li>