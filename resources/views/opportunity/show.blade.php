@extends('layouts.master')

@section('content')
  <div class="content item-info opportunity-info">
    <div class="container container--master">
      <div class="row">
        <div class="col-xs-12">

          <h1 class="headline_1">{{ $opportunity->name }}</h1>

          @if($opportunity->description)
            <div class="text-block-2">{{ $opportunity->description }}</div>
        @endif

        @include('opportunity.partials.admin_edit_link')

        @include('opportunity.partials.booking_link')

        @include('partials.info-1', [
          'left_col_content' => trans('validation.attributes.minutes'),
          'right_col_content' => $opportunity->minutes . ' min.'
        ])

        @include('partials.category-list-1', [
          'block_modifier' => 'occupations',
          'headline' => trans_choice('occupation.occupation', count($opportunity->occupations)),
          'items' => $opportunity->occupations
        ])

        @include('partials.info-1', [
          'left_col_content' => trans('validation.attributes.address'),
          'right_col_content' => nl2br(e($opportunity->display_address))
        ])

        @include('partials.info-1', [
          'left_col_content' => trans('validation.attributes.contact_name'),
          'right_col_content' => e($opportunity->display_contact_name)
        ])

        @include('partials.info-1', [
          'left_col_content' => trans('validation.attributes.phone'),
          'right_col_content' => '<a href="tel:' . e($opportunity->display_contact_phone) . '">' . e($opportunity->display_contact_phone) . '</a>'
        ])

        @include('partials.info-1', [
          'left_col_content' => trans('validation.attributes.registration_end_local'),
          'right_col_content' => $opportunity->registration_end_local->format(trans('opportunity.datetime_format'))
        ])

        @include('partials.info-1', [
          'left_col_content' => 'Platser kvar',
          'right_col_content' => $opportunity->placesLeft() . ' av ' . $opportunity->max_visitors
        ])

        @include('partials.info-1', [
          'left_col_content' => 'Mer info om arbetsplatsen',
          'right_col_content' => '<a href="'.action('WorkplaceController@show', $opportunity->workplace).'">'.e($opportunity->workplace->name).'</a>'
        ])

        </div>
      </div>
    </div>
  </div>

@endsection