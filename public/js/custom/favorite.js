$(document).ready(function () {
  $('.js-toggle-favorite').on('click', function (e) {
    let $toggleElement = $(this);
    let subjectId = $toggleElement.data('id');
    let subjectType = $toggleElement.data('type');
    let userLogged = window.userId;
    if (userLogged === '') {
      if (window.confirm('Trebuie sa te loghezi inainte, daca dai pe ok vei merge la pagina de logare!'))
      {
        window.location.href='/login';
      }
      return;
    }
    $.ajax({
      url: '/toggle/favorite',
      type: 'POST',
      dataType: 'JSON',
      data: {
        id: subjectId,
        type: subjectType,
      },
      success: function (result) {
        if (result.status === 'success') {
          if (result.entityId != null) {
            $toggleElement.css('color', 'red');
          } else {
            $toggleElement.css('color', '#656565');
          }
        }
      }
    });
  });
});
