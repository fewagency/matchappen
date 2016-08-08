@inject('carbonator', '\FewAgency\Carbonator\Carbonator')
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues(['max_visitors' => 5])
->withValues($opportunity)
->withValues([
  'start_local' => $opportunity->start_local ?: $carbonator->parse('+30 weekdays 15:00', \Matchappen\Opportunity::getTimezoneAttribute()),
  'registration_end_local' => $opportunity->registration_end_local ?: $carbonator->parse('+20 weekdays', \Matchappen\Opportunity::getTimezoneAttribute()),
  'occupations' => $opportunity->occupations->implode('name', ','),
])
->withValues(old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])
->required()

->followedByInputBlock('start_local', 'datetime-local')
->withInputAttribute('value', function($input) use ($carbonator) {
  return $carbonator->parseToDatetimeLocal($input->getValue(), \Matchappen\Opportunity::getTimezoneAttribute());
})
->withInputAttribute([
'min'=>$carbonator->parseToDatetimeLocal($opportunity->getEarliestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
'max'=>$carbonator->parseToDatetimeLocal($opportunity->getLatestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
])
->required()

->followedBySelectBlock('minutes', trans('opportunity.minutes_options'))
->required()

->followedByInputBlock('registration_end_local', 'datetime-local')
->withInputAttribute('value', function($input) use ($carbonator) {
  return $carbonator->parseToDatetimeLocal($input->getValue(), \Matchappen\Opportunity::getTimezoneAttribute());
})
->withInputAttribute([
'min'=>$carbonator->parseToDatetimeLocal($opportunity->getEarliestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
'max'=>$carbonator->parseToDatetimeLocal($opportunity->getLatestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
])
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