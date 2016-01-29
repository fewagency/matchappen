$(function () {
  $('textarea[name="occupations"]').selectize({
    valueField: 'name',
    labelField: 'name',
    searchField: 'name',
    load: function (query, callback) {
      if (!query.length) return callback();
      $.ajax({
        url: $('textarea[name="occupations"]').data('optionsurl').first(),
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
}