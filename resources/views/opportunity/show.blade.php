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
              'right_col_content' => nl2br(e($opportunity->display_address))
            ])

            @include('partials.info-1', [
              'left_col_content' => 'Kontaktperson',
              'right_col_content' => $opportunity->display_contact_name
            ])

            @include('partials.info-1', [
              'left_col_content' => 'Telefon',
              'right_col_content' => '<a href="tel:' . $opportunity->display_contact_phone . '">' . $opportunity->display_contact_phone . '</a>'
            ])

            @include('partials.info-1', [
              'left_col_content' => 'Sista anmälan',
              'right_col_content' => date('Y-m-d H:i', strtotime($opportunity->registration_end))
            ])

            @include('partials.info-1', [
              'left_col_content' => 'Platser kvar',
              'right_col_content' => $opportunity->placesLeft() . ' av ' . $opportunity->max_visitors
            ])

                <!-- TODO: länka till arbetsplatens sida här i matchappen för mer info och andra tillfällen! -->

        </div>
      </div>
    </div>
  </div>

@endsection