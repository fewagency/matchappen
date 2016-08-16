@can('update', $workplace)
<p>
  <a href="{{ action('WorkplaceController@edit', $workplace->getKey()) }}">Redigera informationen om {{ $workplace->name }}</a>
</p>
@endcan