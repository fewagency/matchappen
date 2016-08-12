@inject('carbonator', '\FewAgency\Carbonator\Carbonator')
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues(['max_visitors' => 5])
->withValues($opportunity)
->withValues(old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])
->required()

->followedByFieldset()->inline()->withClass('form-block-container--required')
->withLegend(trans('validation.attributes.start_local'))
->containingSelectBlock('start_local_day', array_combine(array_map(function($day) { return str_pad($day,2,'0', STR_PAD_LEFT);},range(1,31)),range(1,31)))->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_month', trans('datetime.month_options'))->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_year', $opportunity->getStartTimeYearOptions())->withClass('form-block--hidden-label')
->withAppendedContent(trans('datetime.at_time'))
->followedBySelectBlock('start_local_hour', $opportunity->getStartTimeHourOptions())->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_minute', $opportunity->getStartTimeMinuteOptions())->withClass('form-block--hidden-label')
->getControlBlockContainer()

->followedBySelectBlock('minutes', trans('opportunity.minutes_options'))
->required()

->followedByInputBlock('registration_end_local', 'datetime-local')
->withInputAttribute('value', function($input) use ($carbonator) {
  return $carbonator->parseToDatetimeLocal($input->getValue(), \Matchappen\Opportunity::getTimezoneAttribute(), \Matchappen\Opportunity::getTimezoneAttribute()) ?: $input->getValue();
})
->withInputAttribute([
'min'=>$carbonator->parseToDatetimeLocal($opportunity->getEarliestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
'max'=>$carbonator->parseToDatetimeLocal($opportunity->getLatestStartTimeLocal(), \Matchappen\Opportunity::getTimezoneAttribute()),
])
->required()

->followedByInputBlock('occupations')
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