<ul>
  @foreach($workplaces as $workplace)
    <li>
      @include('workplace.partials.workplace_card')
    </li>
  @endforeach
</ul>