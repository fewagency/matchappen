@if($workplace->isPublishRequested() and Gate::allows('publish', $workplace))
  <div class="warning">

    <form action="{{ action('WorkplaceController@approve', $workplace->getKey()) }}" method="POST">
      {!! csrf_field() !!}

      <p>{{ trans('workplace.not-approved') }}</p>

      <input type="submit" value="{{ trans('workplace.approve-btn-text') }}">
    </form>

  </div>
@endif