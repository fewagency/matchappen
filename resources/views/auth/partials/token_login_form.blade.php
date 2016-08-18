{{
FluentForm::withAction(action('Auth\EmailTokenController@postLogin', $token))->withValues(compact('email'),old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))->required()
->followedByButtonBlock(trans('auth.actions.login'))
}}