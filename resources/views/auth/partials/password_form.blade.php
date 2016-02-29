{!!
FluentForm::withAction(action('Auth\PasswordController@postEmail'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))
->followedByButtonBlock('Send Password Reset Link')
!!}