@inject('carbon', '\Carbon\Carbon')
<?php $datetime_local_format = 'Y-m-d\TH:i:s'; ?>
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues(['max_visitors' => 5])
->withValues($opportunity)
->withValues([
  'start' => $opportunity->start ?: $carbon->parse('+30 weekdays 15:00'),
  'registration_end' => $opportunity->registration_end ?: $carbon->parse('+20 weekdays'),
  'occupations' => $opportunity->occupations->implode('name', ','),
])
->withValues(old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])
->required()

->followedByInputBlock('start','datetime-local')
->withInputAttribute('value', function($input) {
  $value = $input->getValue();
  try {
    $value = \Carbon\Carbon::parse($value)->format(trans('opportunity.datetime_format'));
  } catch(Exception $e) {
  }
  return $value;
})
->withInputAttribute(['min'=>$opportunity->getEarliestStartTime()->format($datetime_local_format), 'max'=>$opportunity->getLatestStartTime()->format($datetime_local_format)])
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
->withInputAttribute(['min'=>$opportunity->getEarliestStartTime()->format($datetime_local_format), 'max'=>$opportunity->getLatestStartTime()->format($datetime_local_format)])
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