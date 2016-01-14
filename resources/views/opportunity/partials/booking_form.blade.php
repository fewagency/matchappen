@if($opportunity->isBookable())
  <form method="POST" action="{{ action('BookingController@store', $opportunity) }}">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif

    <div>
      Ditt namn
      <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
      Din epost
      <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
      Din lärares epost (mentor eller SYV går också bra)
      <input type="email" name="supervisor_email" value="{{ old('supervisor_email') }}">
    </div>

    <div>
      Ditt mobilnummer (frivilligt)
      <input type="tel" name="phone" value="{{ old('phone') }}">
    </div>

    <!-- TODO: lägg till årskurs i bokningsformuläret -->
    <!-- TODO: lägg till skola i bokningsformuläret om vi inte kan läsa ut det från elevens epostadress -->

    <div>
      <button type="submit">Boka</button>
    </div>
  </form>
@endif