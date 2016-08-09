$(function () {
  var occupationInputs = $('input[data-occupationsurl], textarea[data-occupationsurl]');
  occupationInputs.selectize({
    valueField: 'name',
    labelField: 'name',
    searchField: 'name',
    create: true,
    createFilter: /.{4,}/,
    persist: false,
    load: function (query, callback) {
      if (!query.length) return callback();
      $.ajax({
        url: occupationInputs.data('occupationsurl'),
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