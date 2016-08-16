@can('update', $workplace)
<p>
  <a href="{{ action('WorkplaceController@edit', $workplace->getKey()) }}">Redigera {{ $workplace->name }}</a>
</p>
@endcan