@can('update', $opportunity)
<a href="{{ action('OpportunityController@edit', $opportunity->getKey()) }}">Redigera</a>
@endcan