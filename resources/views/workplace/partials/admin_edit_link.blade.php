@can('update', $workplace)
<p>
  <a href="{{ action('WorkplaceController@edit', $workplace->getKey()) }}">Redigera</a>
</p>
@endcan