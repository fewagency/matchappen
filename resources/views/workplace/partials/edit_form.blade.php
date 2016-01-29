<form method="POST" action="{{ action('WorkplaceController@update', $workplace->getKey()) }}">
  {!! csrf_field() !!}

  @if (count($errors) > 0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div>
    Namn
    <input type="text" name="name" value="{{ old('name', $workplace->name) }}">
  </div>


  @if(!$workplace->isPublishRequested() and Gate::allows('publish', $workplace))
    <div>
      Publicerat:
      <input type="hidden" name="is_published" value="0"/>
      <input type="checkbox" name="is_published" value="1" @if($workplace->isPublished()) checked="checked" @endif />
    </div>
  @endif

  <div>
    Yrken
    <textarea name="occupations" data-optionsurl="{{ action('OccupationController@getList') }}">{{ old('occupations', $workplace->occupations->implode('name', ',')) }}</textarea>
  </div>

  <div>
    Antal anställda
    <input type="number" name="employees" min="1" max="65535" value="{{ old('employees', $workplace->employees) }}">
  </div>

  <div>
    Kontaktperson
    <input type="text" name="contact_name" value="{{ old('contact_name', $workplace->contact_name) }}"
           placeholder="{{ $workplace->fallback_contact_name }}">
  </div>

  <div>
    Email
    <input type="email" name="email" value="{{ old('email', $workplace->email) }}"
           placeholder="{{ $workplace->fallback_email }}">
  </div>

  <div>
    Telefon
    <input type="tel" name="phone" value="{{ old('phone', $workplace->phone) }}"
           placeholder="{{ $workplace->fallback_phone }}">
  </div>

  <div>
    Adress
    <textarea name="address">{{ old('address', $workplace->address) }}</textarea>
  </div>

  <div>
    Beskrivning
    <textarea name="description">{{ old('description', $workplace->description) }}</textarea>
  </div>

  <div>
    Hemsida
    <input type="text" name="homepage" value="{{ old('homepage', $workplace->homepage) }}">
  </div>

  <div>
    <button type="submit">Spara</button>
  </div>
</form>