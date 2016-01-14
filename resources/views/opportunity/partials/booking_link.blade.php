@if($opportunity->isBookable())
<a href="{{ action('OpportunityController@booking', $opportunity) }}">Boka!</a>
@endif