@inject('carbon', '\Carbon\Carbon')
{{
FluentForm::withAction($opportunity->exists ? action('OpportunityController@update', $opportunity) : action('OpportunityController@store'))
->withValues(
  ['max_visitors' => 5],
  $opportunity,
  [
    'start' => $carbon->parse($opportunity->start ?: $carbon->parse('+30 weekdays 15:00'))->toW3cString(),
    'registration_end' => $carbon->parse($opportunity->registration_end ?: $carbon->parse('+20 weekdays'))->toW3cString(),
    'occupations' => $opportunity->occupations->implode('name', ',')
  ],
  old()
 )
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('max_visitors','number')
->withInputAttribute(['min'=>1, 'max'=>\Matchappen\Opportunity::MAX_VISITORS])
->required()

->followedByInputBlock('start','datetime-local')
->required()

->followedBySelectBlock('minutes', trans('opportunity.minutes_options'))
->required()

->followedByInputBlock('registration_end','datetime-local')
->required()

->followedByInputBlock('occupations', 'textarea')
->withInputAttribute('data-occupationsurl', action('OccupationController@index'))

->followedByInputBlock('description', 'textarea')

->followedByInputBlock('address', 'textarea')
//TODO: this replace of newlines may not be needed
->withInputAttribute('placeholder', str_replace("\n", " ", $opportunity->fallback_address))

->followedByInputBlock('contact_name')
->withInputAttribute('placeholder', $opportunity->fallback_contact_name)

->followedByInputBlock('contact_phone', 'tel')
->withInputAttribute('placeholder', $opportunity->fallback_contact_phone)

->followedByButtonBlock(trans('actions.save'))
}}