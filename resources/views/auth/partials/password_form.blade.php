{{
FluentForm::withAction(action('Auth\PasswordController@postEmail'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))->required()
->followedByButtonBlock(trans('auth.actions.send_password_reset_link'))
}}