@extends('layouts.master')

@section('content')

  <div class="content item-info occupation-info">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          @include('partials.status')

          <h1 class="headline_1">{{ $occupation->name }}</h1>

          @if($occupation->description)
            <div class="row">
              <div class="col-md-9 text-block-2">
                {{ $occupation->description }}
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  @include('opportunity.partials.list',[
    'simple_intro' => true,
    'headline_level' => 2,
    'headline' => 'Tillfällen',
    'opportunities' => $occupation->opportunities
  ])

  @include('workplace.partials.list',[
    'simple_intro' => true,
    'headline_level' => 2,
    'headline' => 'Arbetsplatser',
    'workplaces' => $occupation->workplaces
  ])

@endsection