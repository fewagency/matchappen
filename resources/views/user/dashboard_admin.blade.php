@extends('layouts.master', ['use_master_container' => true])

@section('content')

  <h1>Välkommen admin!</h1>

  <p>Här på din hemsida listas opublicerade arbetsplatser. Alla publicerade arbetsplatser kan du hitta och redigera genom <a href="{{ action('WorkplaceController@index') }}">själva webbsidan</a>.</p>

  @if(count($new_workplaces))
    @include('workplace.partials.list', ['workplaces' => $new_workplaces, 'headline' => 'Opublicerade '.trans_choice('workplace.workplace', 2).' att godkänna', 'intro_text' => 'Dessa '.trans_choice('workplace.workplace', 2).' ska granskas och godkännas för att publiceras.'])
  @endif

  @if(count($unpublished_workplaces))
    @include('workplace.partials.list', ['workplaces' => $unpublished_workplaces, 'headline' => 'Opublicerade '. trans_choice('workplace.workplace', 2), 'intro_text' => 'Dessa '.trans_choice('workplace.workplace', 2).' är ej publika. Det kan vara för att du som admin inte godkände dem, eller för att arbetsplatsen själv valt att avpublicera sin information.'])
  @endif

@endsection