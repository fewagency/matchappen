@if($opportunity->isBookable())
  @include('partials.btn-xxl', [
            'href' => action('OpportunityController@booking', $opportunity),
            'text' => 'Boka besök'
          ])
@endif