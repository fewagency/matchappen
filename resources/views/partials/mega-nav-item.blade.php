<section class="mega-nav-item mega-nav-item--{{ $itemModifier }}">

  <div class="wrapper">

    <a href="#" class="mega-nav-item__link" data-fewaccordiontarget="few-paperfold-1">
      <div class="mega-nav-item__intro">
        <h2 class="mega-nav-item__intro-headline">{{ $headline }}</h2>
        <div class="mega-nav-item__intro-text">{{ $introText }}</div>
      </div>
    </a>

  </div>

  <ul class="mega-nav-item__sub-items few-paperfold-1">

    {{-- Make sure that the nr of sub items is an even number --}}
    @foreach($sub_items AS $sub_item)

      <li class="few-paperfold-item mega-nav-item__sub-item">
      <div class="mega-nav-item__sub-item-wrapper-1">
        <a href="{{ $sub_item['href'] }}" class="mega-nav-item__sub-item-link">
          <b class="mega-nav-item__sub-item-headline">{{ $sub_item['headline'] }}</b>
          {{ $sub_item['text'] }}
        </a>
      </div>
      </li>

    @endforeach

  </ul>

</section>