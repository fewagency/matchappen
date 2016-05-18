{!!
FluentForm::withAction(action('Auth\PasswordController@postReset'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))
->followedByPasswordBlock()->withLabel(trans('auth.labels.your_password'))
->followedByPasswordBlock('password_confirmation')->withLabel(trans('auth.labels.password_confirmation'))
->followedByButtonBlock('Reset Password')
!!}