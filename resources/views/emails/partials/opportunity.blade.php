{{ $opportunity->start_local->format(trans('opportunity.datetime_format')) }} - {{ trans('opportunity.minutes_options.'.$opportunity->minutes) }}

{{ $opportunity->workplace->name }}
{{ $opportunity->display_address }}

{{ $opportunity->display_contact_name }} {{ $opportunity->display_contact_phone }}