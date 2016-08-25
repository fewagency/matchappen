@if($opportunity->isBookable())
  @include('partials.btn-xxl', [
            'href' => action('BookingController@create', $opportunity),
            'text' => 'Boka besök'
          ])
@endif