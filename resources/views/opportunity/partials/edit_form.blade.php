<form method="POST"
      action="{{ $opportunity->exists() ? action('OpportunityController@update', $opportunity->getKey()) : action('OpportunityController@store') }}"
>
  {!! csrf_field() !!}

  @if (count($errors) > 0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div>
    Beskrivning
    <textarea name="description">{{ old('description', $opportunity->description) }}</textarea>
  </div>

  <div>
    Antal platser
    <input type="number" name="max_visitors" min="1" max="{{ \Matchappen\Opportunity::MAX_VISITORS }}"
           value="{{ old('max_visitors', $opportunity->max_visitors) }}">
  </div>

  <div>
    <button type="submit">Spara</button>
  </div>
</form>