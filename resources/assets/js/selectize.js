$(function () {
  $('textarea[name="occupations"]').selectize({
    valueField: 'name',
    labelField: 'name',
    searchField: 'name',
    create: true,
    createFilter: /.{4,}/,
    persist: false,
    load: function (query, callback) {
      if (!query.length) return callback();
      $.ajax({
        url: $('textarea[name="occupations"]').data('optionsurl'),
        type: 'GET',
        data: {
          q: query,
        },
        error: function () {
          callback();
        },
        success: function (res) {
          callback(res);
        }
      });
    }
  });
});