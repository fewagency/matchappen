{{
FluentForm::withAction(action('Auth\PasswordController@postReset'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->withHiddenInput('token', $token)
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))->required()
->followedByPasswordBlock()->withLabel(trans('auth.labels.desired_password'))->required()
->followedByPasswordBlock('password_confirmation')->withLabel(trans('auth.labels.password_confirmation'))->required()
->followedByButtonBlock(trans('auth.actions.reset_password'))
}}