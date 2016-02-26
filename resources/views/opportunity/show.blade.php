@extends('layouts.master')

@section('content')

  <div class="content item-info opportunity-info">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <h1 class="headline_1">{{ $opportunity->name }}</h1>

          @if($opportunity->description)
            <div class="row">
              <div class="col-md-9 text-block-2">
                {{ $opportunity->description }}
              </div>
            </div>
          @endif

          @include('partials.btn-xxl', [
            'href' => '#',
            'text' => 'Boka besök'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Längd',
            'right_col_content' => (strtotime($opportunity->end) - strtotime($opportunity->start))/60 . ' min.'
          ])

          @include('partials.category-list-1', [
            'block_modifier' => 'occupations',
            'headline' => 'Yrken',
            'items' => $opportunity->occupations
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Adress',
            'right_col_content' => nl2br(e($opportunity->workplace->address))
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Kontaktperson',
            'right_col_content' => $opportunity->workplace->display_contact_name
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Epost',
            'right_col_content' => '<a href="mailto:' . $opportunity->workplace->display_email . '">' . $opportunity->workplace->display_email . '</a>'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Telefon',
            'right_col_content' => '<a href="mailto:' . $opportunity->workplace->display_phone . '">' . $opportunity->workplace->display_phone . '</a>'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Sista anmälan',
            'right_col_content' => date('Y-m-d H:i', strtotime($opportunity->registration_end))
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Platser kvar',
            'right_col_content' => ' av ' . $opportunity->max_visitors
          ])

          @if($opportunity->workplace->homepage)

            @include('partials.info-1', [
              'left_col_content' => 'Hemsida',
              'right_col_content' => '<a href="' . $opportunity->workplace->homepage . '">' . $opportunity->workplace->homepage . '</a>'
            ])

          @endif

          {{--

          @if(!$workplace->isPublished() and Gate::allows('publish', $workplace))

            @include('partials.info-1', [
              'left_col_content' => 'Publicerad',
              'right_col_content' => $workplace->isPublished() ? 'Ja' : 'Nej'
            ])

          @endif

          @include('partials.category-list-1', [
            'block_modifier' => 'occupations',
            'headline' => 'Yrken',
            'items' => $workplace->occupations
          ])

          @if($workplace->homepage)

            @include('partials.info-1', [
              'left_col_content' => 'Hemsida',
              'right_col_content' => '<a href="' . $workplace->homepage . '">' . $workplace->homepage . '</a>'
            ])

          @endif

          @include('partials.info-1', [
            'left_col_content' => 'Anställda',
            'right_col_content' => $workplace->employees
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Kontaktperson',
            'right_col_content' => $workplace->display_contact_name
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Epost',
            'right_col_content' => '<a href="mailto:' . $workplace->display_email . '">' . $workplace->display_email . '</a>'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Telefon',
            'right_col_content' => '<a href="tel:' . substr(str_replace(' ', '', $workplace->display_phone), 1) . '">' . $workplace->display_phone . '</a>'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Adress',
            'right_col_content' => nl2br(e($workplace->address))
          ])

          --}}

        </div>
      </div>
    </div>
  </div>

  {{--
  @include('opportunity.partials.list',[
    'simple_intro' => true,
    'headline_level' => 2,
    'headline' => 'Tillfällen',
    'opportunities' => $workplace->opportunities
  ])
  --}}

@endsection


{{--


  <section class="page-intro">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          <h1>{{ $opportunity->name }}</h1>

          @include('opportunity.partials.booking_link')

          @include('opportunity.partials.admin_edit_link')

          @if($opportunity->description)
            <p>Beskrivning: {{ $opportunity->description }}</p>
          @endif

          <p>Längd: {{ $opportunity->minutes }} minuter</p>

          <address>{!! nl2br(e($opportunity->display_address)) !!}</address>
          <p>Kontaktperson: {{ $opportunity->display_contact_name }}</p>
          <p>Telefon: {{ $opportunity->display_contact_phone }}</p>
          <p>Sista anmälan: {{ $opportunity->registration_end->format('j/n') }}</p>
          <p>Platser kvar: {{ $opportunity->placesLeft() }}/{{ $opportunity->max_visitors }}</p>

        </div>
      </div>
    </div>
  </section>

  @include('occupation.partials.list', ['occupations' => $opportunity->occupations ])


--}}