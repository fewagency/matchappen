@extends('layouts.master')

@section('content')
  <div class="content item-info opportunity-info">
    <div class="container container--master">
      <div class="row">
        <div class="col-xs-12">

          <h1 class="headline_1">{{ $opportunity->name }}</h1>

          @if($opportunity->description)
            <div class="text-block-2">
              {{ $opportunity->description }}
            </div>
          @endif

          @include('opportunity.partials.admin_edit_link')

          @include('opportunity.partials.booking_link')

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
            'right_col_content' => '<a href="tel:' . $opportunity->workplace->display_phone . '">' . $opportunity->workplace->display_phone . '</a>'
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Sista anmälan',
            'right_col_content' => date('Y-m-d H:i', strtotime($opportunity->registration_end))
          ])

          @include('partials.info-1', [
            'left_col_content' => 'Platser kvar',
            'right_col_content' => $opportunity->placesLeft() . ' av ' . $opportunity->max_visitors
          ])

          <!-- TODO: ska vi ta bort hemsida från besöksinfon? Vi vill inte leda besökare bort från denna sidan. -->
          @if($opportunity->workplace->homepage)

            @include('partials.info-1', [
              'left_col_content' => 'Hemsida',
              'right_col_content' => '<a href="' . $opportunity->workplace->homepage . '">' . $opportunity->workplace->homepage . '</a>'
            ])

          @endif

          <!-- TODO: länka till arbetsplatens sida här i matchappen för mer info och andra tillfällen! -->

        </div>
      </div>
    </div>
  </div>

@endsection