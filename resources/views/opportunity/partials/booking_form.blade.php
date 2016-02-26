@if($opportunity->isBookable())
@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')
{!!
  FluentForm::withAction(action('BookingController@store', $opportunity))
  ->withValues(['email'=>$token_guard->email()])
  ->withValues(old())
  ->withErrors($errors)
  ->withToken(csrf_token())
  ->containingInputBlock('name')
  ->required()
  ->followedByInputBlock('visitors','number')
  ->onlyDisplayedIf($token_guard->checkSupervisor())
  ->withInputAttribute('max',$opportunity->placesLeft())
  ->required()
  ->followedByInputBlock('email', 'email')
  ->withLabel($token_guard->checkSupervisor() ? 'Elevens epost' : trans('auth.labels.your_email'))
  ->required(!$token_guard->checkSupervisor())
  ->withDescription($token_guard->checkSupervisor() ? '(om du bokar till 1 elev)' : null)
  ->followedByInputBlock('supervisor_email','email')
  ->readonly($token_guard->checkSupervisor())
  ->required()
  ->withLabel($token_guard->checkSupervisor() ? trans('auth.labels.your_email') : 'Din lärares epostadress')
  ->withDescription($token_guard->checkSupervisor() ? '' : '(mentor eller SYV går också bra)')
  ->followedByInputBlock('phone','tel')
  ->withLabel('Ditt mobilnummer')
  ->withDescription('(frivilligt)')
  ->followedByButtonBlock('Boka')
!!}
<!-- TODO: lägg till årskurs i bokningsformuläret -->
<!-- TODO: lägg till skola i bokningsformuläret om vi inte kan läsa ut det från elevens epostadress -->

@if(!$token_guard->checkSupervisor())
  <a href="{{ action('Auth\EmailTokenController@getEmail') }}">Vill du boka som {{ trans('general.edu-staff') }}?</a>
@endif

@endif