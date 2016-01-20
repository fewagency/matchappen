@if($workplace->isPublishRequested() && \Auth::user()->is_admin)

  <div style="border: solid 2px red; padding: 8px">

    <form action="{{ action('WorkplaceController@approve', $workplace->getKey()) }}" method="post">

      <p>{{ trans('workplace.not-approved') }}</p>

      <input type="submit" value="{{ trans('workplace.approve-btn-text') }}">

      {!! csrf_field() !!}

    </form>

  </div>

@elseif(session('workplaceapprovedmsg'))

  <div style="border: solid 2px green; padding: 8px">
    {{ session('workplaceapprovedmsg') }}
  </div>

@endif