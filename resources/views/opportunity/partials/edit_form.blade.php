@inject('carbon', '\Carbon\Carbon')
<?php $datetime_local_format = 'Y-m-d\TH:i:s'; ?>
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues(['max_visitors' => 5])
->withValues($opportunity)
->withValues([
  'start_local' => $opportunity->start ?: $carbon->parse('+30 weekdays 15:00', \Matchappen\Opportunity::getTimezoneAttribute()),
  'registration_end' => $opportunity->registration_end ?: $carbon->parse('+20 weekdays', \Matchappen\Opportunity::getTimezoneAttribute()),
  'occupations' => $opportunity->occupations->implode('name', ','),
])
->withValues(old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])
->required()

->followedByInputBlock('start_local','datetime-local')
->withInputAttribute('value', function($input) use ($datetime_local_format) {
  $value = $input->getValue();
  if($value instanceof \DateTime) {
    $value = \Carbon\Carbon::instance($value);
  } elseif(strlen($value)) {
    try {
      $value = \Carbon\Carbon::parse($value, \Matchappen\Opportunity::getTimezoneAttribute());
    } catch(Exception $e) {
    }
  }
  if($value instanceof \Carbon\Carbon) {
    $value = $value->tz(\Matchappen\Opportunity::getTimezoneAttribute())->format($datetime_local_format);
  }
  return $value;
})
->withInputAttribute(['min'=>$opportunity->getEarliestStartTimeLocal()->format($datetime_local_format), 'max'=>$opportunity->getLatestStartTimeLocal()->format($datetime_local_format)])
->required()

->followedBySelectBlock('minutes', trans('opportunity.minutes_options'))
->required()

->followedByInputBlock('registration_end','datetime-local')
->withInputAttribute('value', function($input) {
  $value = $input->getValue();
  try {
    $value = \Carbon\Carbon::parse($value)->format(trans('opportunity.datetime_format'));
  } catch(Exception $e) {
  }
  return $value;
})
->withInputAttribute(['min'=>$opportunity->getEarliestStartTimeLocal()->format($datetime_local_format), 'max'=>$opportunity->getLatestStartTimeLocal()->format($datetime_local_format)])
->required()

->followedByInputBlock('occupations', 'textarea')
->withInputAttribute('data-occupationsurl', action('OccupationController@index'))

->followedByInputBlock('description', 'textarea')

->followedByInputBlock('address', 'textarea')
->withInputAttribute('placeholder', str_replace("\n", " ", $opportunity->fallback_address))

->followedByInputBlock('contact_name')
->withInputAttribute('placeholder', $opportunity->fallback_contact_name)

->followedByInputBlock('contact_phone', 'tel')
->withInputAttribute('placeholder', $opportunity->fallback_contact_phone)

->followedByButtonBlock(trans('actions.save'))
}}