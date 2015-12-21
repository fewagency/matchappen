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
    Antal platser
    <input type="number" name="max_visitors" min="1" max="{{ \Matchappen\Opportunity::MAX_VISITORS }}"
           value="{{ old('max_visitors', $opportunity->max_visitors) }}">
  </div>

  <div>
    Start
    <input type="datetime-local" name="start" value="{{ old('start', $opportunity->start->toW3cString()) }}">
  </div>

  <div>
    Längd
    <select name="minutes">
      @foreach(trans('opportunity.minutes_options') as $minutes => $string)
        <option value="{{ $minutes }}" @if($minutes == $opportunity->minutes) selected @endif >{{ $string }}</option>
      @endforeach
    </select>
  </div>

  <div>
    Anmälan fram till
    <input type="datetime-local" name="registration_end" value="{{ old('registration_end', $opportunity->registration_end->toW3cString()) }}">
  </div>

  <div>
    Beskrivning
    <textarea name="description">{{ old('description', $opportunity->description) }}</textarea>
  </div>

  <div>
    Adress
    <textarea name="address" placeholder="{{ $opportunity->fallback_address }}">{{ old('address', $opportunity->address) }}</textarea>
  </div>

  <div>
    Kontaktperson
    <input type="text" name="contact_name" value="{{ old('contact_name', $opportunity->contact_name) }}" placeholder="{{ $opportunity->fallback_contact_name }}">
  </div>

  <div>
    Telefon
    <input type="text" name="contact_phone" value="{{ old('contact_phone', $opportunity->contact_phone) }}" placeholder="{{ $opportunity->fallback_contact_phone }}">
  </div>

  <div>
    <button type="submit">Spara</button>
  </div>
</form>