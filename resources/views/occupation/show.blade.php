@extends('layouts.master')

@section('content')

  <div class="content item-info occupation-info">
    <div class="container container--master">
      <div class="row">
        <div class="col-xs-12">

          @include('partials.status')

          <h1 class="headline_1">{{ ucfirst(trans_choice('occupation.occupation',1)) }}: {{ $occupation->name }}</h1>

          @if($occupation->description)
            <div class="text-block-2">
              {{ $occupation->description }}
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  @if(count($occupation->upcomingOpportunities))
    @include('opportunity.partials.list',[
      'intro_type' => 1,
      'headline_level' => 2,
      'headline' => trans_choice('opportunity.opportunity', count($occupation->upcomingOpportunities)),
      'opportunities' => $occupation->upcomingOpportunities
    ])
  @endif

  @if(count($occupation->workplaces))
    @include('workplace.partials.list',[
      'intro_type' => 1,
      'headline_level' => 2,
      'headline' => trans_choice('workplace.workplace', count($occupation->workplaces)),
      'workplaces' => $occupation->workplaces
    ])
  @endif

@endsection