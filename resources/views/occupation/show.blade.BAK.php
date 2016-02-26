@extends('layouts.master')

@section('content')

  <div class="page-intro">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <h1>{{ $occupation->name }}</h1>

        </div>
      </div>
    </div>
  </div>

  @include('opportunity.partials.list', ['opportunities' => $occupation->opportunities()->viewable()->get() ])

  @include('workplace.partials.list', ['workplaces' => $occupation->workplaces()->published()->get() ])
@endsection