Betyg: {{ $evaluation->rating }}
@if($evaluation->comment)
  <blockquote>{{ $evaluation->comment }}</blockquote>
@endif