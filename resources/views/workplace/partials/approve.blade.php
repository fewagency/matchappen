@if($workplace->isPublishRequested() and Gate::allows('publish', $workplace))

  <div style="border: solid 2px red; padding: 8px">

    <form action="{{ action('WorkplaceController@approve', $workplace->getKey()) }}" method="POST">
      {!! csrf_field() !!}

      <p>{{ trans('workplace.not-approved') }}</p>

      <input type="submit" value="{{ trans('workplace.approve-btn-text') }}">
    </form>

  </div>

@elseif(session('workplaceapprovedmsg'))

  <div style="border: solid 2px green; padding: 8px">
    {{ session('workplaceapprovedmsg') }}
  </div>

@endif