FewPaperfold = {

  init: function() {

    this.initPaperfold();

  },

  initPaperfold: function() {

    $('[data-fewaccordiontarget]').each(function() {

      $(this).data('status', 'closed');

      var $targetElm = $('#' + $(this).attr('data-fewaccordiontarget'));

      $('.mega-nav-item__sub-item-text', $targetElm).each(function() {

        $(this).dotdotdot({
          watch: "window"
        });

      });

      var paperfold = $targetElm.paperfold({
        duration: 300,
        folds: ($('.few-paperfold-item', $targetElm).length / 2)
      });

      $(this).on('click', function(event) {

        event.preventDefault();

        var $eventTriggerElm = $(this);

        var status = $eventTriggerElm.data('status');

        if(status == 'closed') {

          $eventTriggerElm.addClass('few-paperfold--open');
          $eventTriggerElm.data('status', 'open');
          paperfold.open();

        } else {

          $eventTriggerElm.removeClass('few-paperfold--open');
          $eventTriggerElm.data('status', 'closed');
          paperfold.close();

        }



      });

    });

  },

}