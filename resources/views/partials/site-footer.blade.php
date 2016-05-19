@inject('token_guard', 'Matchappen\Services\EmailTokenGuard')
<footer class="site-footer">
  <div class="container container--master">
    <div class="row">
      <div class="col-xs-12 col-md-offset-3 col-md-6">

        <nav class="site-footer-nav">

          <ul class="site-footer-nav__items">
            <li class="site-footer-nav__item site-footer-nav__item--workplaces">
              <a href="{{ action('WorkplaceController@index') }}" class="site-footer-nav__item-link">
                <span>{{ ucfirst(trans_choice('workplace.workplace', 2)) }}</span>
              </a>
            </li>
            <li class="site-footer-nav__item site-footer-nav__item--occupations">
              <a href="{{ action('OccupationController@index') }}" class="site-footer-nav__item-link">
                <span>{{ ucfirst(trans_choice('occupation.occupation', 2)) }}</span>
              </a>
            </li>
            <li class="site-footer-nav__item site-footer-nav__item--opportunities">
              <a href="{{ action('OpportunityController@index') }}" class="site-footer-nav__item-link">
                <span>{{ ucfirst(trans_choice('opportunity.opportunity', 2)) }}</span>
              </a>
            </li>

            @if(!Auth::check() and !$token_guard->check())

              <li class="site-footer-nav__item">
                <a href="{{ route('dashboard') }}" class="site-footer-nav__item-link">
                  <span>Logga in</span>
                </a>
              </li>

            @else

              <li class="site-footer-nav__item">
                <a href="{{ route('dashboard') }}" class="site-footer-nav__item-link">
                  <span>Mitt konto</span>
                </a>
              </li>
              <li class="site-footer-nav__item">

                @if($user = Auth::user())
                  <a href="{{ action('Auth\AuthController@getLogout') }}" class="site-footer-nav__item-link">
                    @elseif($token_email = $token_guard->email())
                      <a href="{{ action('Auth\EmailTokenController@getLogout') }}" class="site-footer-nav__item-link">
                        @endif
                        <span>Logga ut</span>
                      </a>
              </li>
            @endif

            <li class="site-footer-nav__item">
              <a href="{{ route('dashboard') }}" class="site-footer-nav__item-link">
                <span><a href="mailto:todo@malmo.se">todo@malmo.se</a></span>
              </a>
            </li>

          </ul>

        </nav>

      </div>
    </div>
  </div>
</footer>