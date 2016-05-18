{{
FluentForm::withAction(action('Auth\AuthController@postLogin'))->withValues(old())->withErrors($errors)
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel(trans('auth.labels.your_email'))->required()
->followedByPasswordBlock()->withLabel(trans('auth.labels.your_password'))->required()
->followedByButtonBlock(trans('auth.actions.login'))
}}