<ul>
  @foreach($opportunities as $opportunity)
    <li>
      @include('opportunity.partials.card')
    </li>
  @endforeach
</ul>