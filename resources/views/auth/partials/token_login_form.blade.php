{!!
FluentForm::withAction(action('Auth\EmailTokenController@postLogin', $token))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))
->followedByButtonBlock(trans('auth.actions.login'))
!!}