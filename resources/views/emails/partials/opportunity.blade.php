<p>
  {{ $opportunity->start_local->format(trans('opportunity.datetime_format')) }}
  - {{ trans('opportunity.minutes_options.'.$opportunity->minutes) }}
</p>

<address>{{ $opportunity->display_address }}</address>

<p>
  Kontaktperson {{ $opportunity->workplace->name }}:
  {{ $opportunity->display_contact_name }} {{ $opportunity->display_contact_phone }}
</p>