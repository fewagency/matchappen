{!!
FluentForm::withAction(action('Auth\AuthController@postLogin'))->withValues(old())->withErrors($errors->getMessageBag())
->withToken(csrf_token())
->containingInputBlock('email','email')->withLabel('Din epostadress')
->followedByPasswordBlock('password')->withLabel('Ditt lösenord')
->followedByButtonBlock('Login')
!!}