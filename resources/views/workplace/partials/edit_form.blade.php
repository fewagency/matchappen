{{
FluentForm::withAction(action('WorkplaceController@update', $workplace->getKey()))
->withValues($workplace, ['occupations' => $workplace->occupations->pluck('name')->toArray()], old())
->withErrors($errors)
->withLabels(trans('validation.attributes'))
->withToken(csrf_token())

->containingInputBlock('name')
->required()

->followedByCheckboxBlock('is_published')
->onlyDisplayedIf(!$workplace->isPublishRequested() and Gate::allows('publish', $workplace))
->checked($workplace->isPublished())
->withPrependedContent(new \FewAgency\FluentForm\HiddenInputElement('is_published', 0))

->followedByInputBlock('occupations')
->withInputAttribute('data-occupationsurl', action('OccupationController@index'))
->withLabel(trans('validation.attributes.workplace.occupations'))
->withDescription(trans('occupation.input.description'))

->followedByInputBlock('employees', 'number')
->withInputAttribute(['min'=>1, 'max'=>65535])
->required()

->followedByInputBlock('contact_name')
->withInputAttribute('placeholder', $workplace->fallback_contact_name)
->withDescription(trans('workplace.contact.description'))

->followedByInputBlock('email', 'email')
->withInputAttribute('placeholder', $workplace->fallback_email)

->followedByInputBlock('phone', 'tel')
->withInputAttribute('placeholder', $workplace->fallback_phone)

->followedByInputBlock('address', 'textarea')
->required()

->followedByInputBlock('description', 'textarea')
->withDescription(trans('workplace.description.description'))

->followedByInputBlock('homepage')

->followedByButtonBlock(trans('actions.save'))
}}