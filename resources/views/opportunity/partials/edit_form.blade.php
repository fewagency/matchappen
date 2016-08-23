@inject('carbonator', '\FewAgency\Carbonator\Carbonator')
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues($opportunity)
->withValues(['occupations' => $opportunity->occupations->pluck('name')->toArray()])
->withValues(old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])

->followedByFieldset()->inline()
->withLegend(trans('validation.attributes.start_local'))
->containingSelectBlock('start_local_day', array_combine(array_map(function($day) { return str_pad($day,2,'0', STR_PAD_LEFT);},range(1,31)),range(1,31)))->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_month', trans('datetime.month_options'))->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_year', $opportunity->getStartTimeYearOptions())->withClass('form-block--hidden-label')
->withAppendedContent(trans('datetime.at_time'))
->followedBySelectBlock('start_local_hour', $opportunity->getStartTimeHourOptions())->withClass('form-block--hidden-label')
->followedBySelectBlock('start_local_minute', $opportunity->getStartTimeMinuteOptions())->withClass('form-block--hidden-label')
->getControlBlockContainer()

->followedBySelectBlock('minutes', trans('opportunity.minutes_options'))

->followedBySelectBlock('registration_end_weekdays_before', trans('opportunity.registration_end_weekdays_before_options'))

->followedByInputBlock('occupations')
->withInputAttribute('data-occupationsurl', action('OccupationController@index'))
->withDescription(trans('opportunity.occupations.description'), trans('occupation.input.description'))

->followedByInputBlock('description', 'textarea')

->followedByInputBlock('address', 'textarea')
->withInputAttribute('placeholder', str_replace("\n", " ", $opportunity->fallback_address))

->followedByInputBlock('contact_name')
->withInputAttribute('placeholder', $opportunity->fallback_contact_name)

->followedByInputBlock('contact_phone', 'tel')
->withInputAttribute('placeholder', $opportunity->fallback_contact_phone)

->followedByButtonBlock(trans('actions.save'))
}}