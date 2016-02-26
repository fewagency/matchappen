{!!
FluentForm::withAction(action('Auth\AuthController@postLogin'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))
->followedByPasswordBlock()->withLabel(trans('auth.labels.your_password'))
->followedByButtonBlock(trans('auth.actions.login'))
!!}