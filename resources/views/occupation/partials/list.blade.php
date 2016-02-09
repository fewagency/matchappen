<ul>
  @foreach($occupations as $occupation)
    <li>
      @include('occupation.partials.card')
    </li>
  @endforeach
</ul>