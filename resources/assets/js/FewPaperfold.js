FewPaperfold = {

  init: function() {

    this.initPaperfold();

  },

  initPaperfold: function() {

    $('[data-fewaccordiontarget]').each(function() {

      var $targetElm = $('.' + $(this).attr('data-fewaccordiontarget'));

      console.log($targetElm);

      var paperfold = $targetElm.paperfold({
        duration: 240,
        folds: ($('.few-paperfold-item', $targetElm).length / 2)
      });

      $(this).on('click', function(event) {

        event.preventDefault();
        paperfold.toggle();

      });

    });

  },

}