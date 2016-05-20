@if($opportunity->isBookable())
  @inject('token_guard', 'Matchappen\Services\EmailTokenGuard')
  {{
    FluentForm::withAction(action('BookingController@store', $opportunity))
    ->withValues([
      $token_guard->checkSupervisor() ? 'supervisor_email' : 'email' => $token_guard->email(),
    ])
    ->withValues(old())
    ->withLabels(trans('validation.attributes'))
    ->withErrors($errors)
    ->withToken(csrf_token())

    ->containingInputBlock('name')
    ->withLabel(trans('validation.attributes.user.name'))
    ->required()

    ->followedByInputBlock('visitors','number')
    ->onlyDisplayedIf($token_guard->checkSupervisor())
    ->withInputAttribute('max', $opportunity->placesLeft())
    ->withInputAttribute('min', 1)
    ->required()

    ->followedByInputBlock('email', 'email')
    ->withLabel($token_guard->checkSupervisor() ? trans('opportunity.labels.student_email') : trans('auth.labels.your_email'))
    ->required(!$token_guard->checkSupervisor())
    ->withDescription($token_guard->checkSupervisor() ? '(om du bokar till 1 elev)' : null)

    ->followedByInputBlock('supervisor_email','email')
    ->readonly($token_guard->checkSupervisor())
    ->required()
    ->withLabel($token_guard->checkSupervisor() ? trans('auth.labels.your_email') : trans('opportunity.labels.supervisor_email'))
    ->withDescription($token_guard->checkSupervisor() ? '' : '(mentor eller SYV går också bra)')

    ->followedByInputBlock('phone','tel')
    ->withLabel(trans('opportunity.labels.your_mobile_phone'))
    ->withDescription('(frivilligt)')

    ->followedByButtonBlock(trans('opportunity.actions.book'))
  }}
  <!-- TODO: lägg till årskurs i bokningsformuläret -->
  <!-- TODO: lägg till skola i bokningsformuläret om vi inte kan läsa ut det från elevens epostadress -->

  @if(!$token_guard->checkSupervisor())
    <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Vill du boka som {{ trans('general.edu-staff') }}?</a>
  @endif

@endif