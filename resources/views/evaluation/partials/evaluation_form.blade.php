{{
  FluentForm::withAction(action('OpportunityEvaluationController@store', $opportunity))
  ->withValues(old())
  ->withLabels(trans('validation.attributes'))
  ->withErrors($errors)
  ->withToken(csrf_token())

  //TODO: switch dropdown to rating radio-buttons
  ->containingSelectBlock('rating', array_combine(range(1,5), range(1,5)))
  ->followedByInputBlock('comment','textarea')

  ->followedByButtonBlock(trans('evaluation.actions.send'))
}}