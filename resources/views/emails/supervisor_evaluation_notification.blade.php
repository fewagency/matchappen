<div>
  Betyg: {{ $evaluation->rating }}
</div>
@if($evaluation->comment)
  <blockquote>{{ $evaluation->comment }}</blockquote>
@endif

<div>
  Kontaktuppgifter till {{ $opportunity->workplace->name }}:<br>
  {{ $opportunity->display_contact_name }}<br>
  {{ $opportunity->display_contact_phone }}<br>
  {{ $opportunity->workplace->display_email }}
  <address>
    {{ nl2br($opportunity->display_address) }}
  </address>
</div>