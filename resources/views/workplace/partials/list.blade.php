<ul>
  @foreach($workplaces as $workplace)
    <li>
      @include('workplace.partials.card')
    </li>
  @endforeach
</ul>