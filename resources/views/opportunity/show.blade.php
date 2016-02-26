@extends('layouts.master')

@extends('layouts.master')

@section('content')

  <div class="content item-info workplace-info">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">

          @include('partials.status')

          <h1 class="headline_1">{{ $workplace->name }}</h1>

          @include('workplace.partials.approve')

          @include('workplace.partials.admin_edit_link')

          @if($workplace->description)
            <div class="row">
              <div class="col-md-9 text-block-2">
                {{ $workplace->description }}
              </div>
            </div>
          @endif

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

        </div>
      </div>
    </div>
  </div>

  @include('opportunity.partials.list',[
    'simple_intro' => true,
    'headline_level' => 2,
    'headline' => 'Tillfällen',
    'opportunities' => $workplace->opportunities
  ])

@endsection


{{--
@section('content')

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

@endsection
--}}