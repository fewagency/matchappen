@can('update', $workplace)
<a href="{{ action('WorkplaceController@edit', $workplace->getKey()) }}">Redigera</a>
@endcan