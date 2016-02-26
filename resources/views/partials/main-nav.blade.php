{{--

@todo Set main-nav__item--activeon correct item

--}}

@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')
<div class="main-nav-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">

        <nav class="main-nav">

          <ul class="main-nav__items">
            <li class="main-nav__item main-nav__item--workplaces">
              <a href="{{ action('WorkplaceController@index') }}"
                 class="main-nav__item-link"><?php include(trans('assets.workplaces-icon-stripped')) ?>
                <span>{{ ucfirst(trans_choice('workplace.workplace', 2)) }}</span>
              </a>
            </li>
            <li class="main-nav__item main-nav__item--occupations">
              <a href="{{ action('OccupationController@index') }}"
                 class="main-nav__item-link"><?php include(trans('assets.occupations-icon-stripped')) ?>
                <span>{{ ucfirst(trans_choice('occupation.occupation', 2)) }}</span>
              </a>
            </li>
            <li class="main-nav__item main-nav__item--opportunities">
              <a href="{{ action('OpportunityController@index') }}"
                 class="main-nav__item-link"><?php include(trans('assets.opportunities-icon-stripped')) ?>
                <span>{{ ucfirst(trans_choice('opportunity.opportunity', 2)) }}</span>
              </a>
            </li>

            @if(!Auth::check() and !$token_guard->check())

              <li class="main-nav__item main-nav__item--log-in">
                <a href="{{ route('dashboard') }}"
                   class="main-nav__item-link"><?php include(trans('assets.log-in-icon')) ?>
                  <span>Logga in</span>
                </a>
              </li>

            @else

              <li class="main-nav__item main-nav__item--my-account">
                <a href="{{ route('dashboard') }}"
                  class="main-nav__item-link"><?php include(trans('assets.account-icon')) ?>
                  <span>Mitt konto</span>
                </a>
              </li>
              <li class="main-nav__item main-nav__item--log-out">

                @if($user = Auth::user())
                  <a href="{{ action('Auth\AuthController@getLogout') }}" class="main-nav__item-link">
                @elseif($token_email = $token_guard->email())
                  <a href="{{ action('Auth\EmailTokenController@getLogout') }}" class="main-nav__item-link">
                @endif
                    <?php include(trans('assets.log-out-icon')) ?>
                  <span>Logga ut</span>
                </a>
              </li>
            @endif
          </ul>

        </nav>

      </div>
    </div>
  </div>
</div>