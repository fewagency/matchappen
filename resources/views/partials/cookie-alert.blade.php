<?php

/**
 * Complicated stuff...
 * We dont want to hide this element intially and then display it using JS since JS may be turned off.
 * We dont want to rely on jQuery since we dont want to be forced to include jQuery and if we are, we may not
 * want to wait until jQuery have loaded until we display the alert.
 * So... lets use some Vanilla JS™ and script tags to do what we want.
 */

$cookie_name = 'matchappen-cookies-okd';

?>

<div id="cookie-alert">

  <script>
    var fewtureCookieAlertElm = document.getElementById('cookie-alert');
    if(document.cookie.indexOf('{{$cookie_name}}=1') !== -1) {
      fewtureCookieAlertElm.style.display = "none";
    }
  </script>

  <div class="container container--master">
    <div class="row">
      <div class="col-xs-12">
        <div>

          {!! trans('messages.cookie-alert-message') !!}

        </div>

        <noscript>{!! trans('messages.cookie-alert-noscript-message') !!}</noscript>

        <a href="#" class="btn btn-default" id="fewture-cookie-alert__ok-trigger">{{ trans('messages.cookie-alert-button-text') }}</a>

      </div>
    </div>
  </div>
</div>

<script>
  if(document.cookie.indexOf('{{$cookie_name}}=1') === -1) {
    var exDate = new Date();
    exDate.setDate(exDate.getDate() + 365);
    document.getElementById('fewture-cookie-alert__ok-trigger').onclick = function() {
      fewtureCookieAlertElm.style.display = "none";
      document.cookie = '{{$cookie_name}}=1; expires=' + exDate.toUTCString() + '; path=/; domain={{Request::getHttpHost()}}';
      return false;
    };
  }
</script>