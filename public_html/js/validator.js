function checkForm() {

      var name        = $.trim($('#name').val());
      var phone       = $.trim($('#phone').val());
      var captcha     = $.trim($('#captcha').val());
      var formType    = $('.formtype').val();
      var arr = [];
      var err = "";

      //Форма на основной части страниц
      if(formType == 'regular') {
          var arrivalTime = $('.ddToggle').text();
      }
      //Форма в контактах
      if(formType == 'contacts') {
          var email       = $.trim($('#email').val());
          var companyName = $.trim($('#company_name').val());
          var message     = $.trim($('#message').val());
          var num = '';

          for(var i = 0; i < 7; i++) {
              var num = i + 1;
              if($('#chk'+num).is(':checked')) {
                arr[i] = i+1;
              }
          }

          if(email != '') {
              var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
              if (!email.match(reg)) {
                err += "Вы неправильно ввели адрес электронной почты\n";
              }
          }
          if(message == '') {
            err += "Дополнительная информация не может быть пустой\n";
          }
      }
      if(formType == 'mainpage') {
        var email       = $.trim($('#email').val());
        var message     = $.trim($('#message').val());
        if(email != '') {
              var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
              if (!email.match(reg)) {
                err += "Вы неправильно ввели адрес электронной почты\n";
              }
        }
      }
      if(!arrivalTime) {
          arrivalTime = '';
      }
      if(!message) {
          message = '';
      }

      //Если основные поля не заполнены
      if(name == '') {
           err += "Вы неправильно ввели имя\n";
      }
      if(phone == '') {
          err += "Вы неправильно ввели телефон\n";
      } else {
        var reg = /(\d+)/;
        if (!phone.match(reg)) {
            err += "Вы неправильно ввели телефон\n";
        }
      }
      if(captcha == '') {
          err += "Число введено неправильно\n";
      }

      if(!err) {
//         $.post("http://webelement.ru/ajax/ajax_send.php", { name: name, phone: phone,  arrivalTime: arrivalTime, captcha: captcha,
//                                        formType: formType, arr: arr, message: message, email: email, companyName: companyName},
//            function(data) {
//                if(data == 'err') {
//                    alert('Число введено неправильно');
//                } else {
//                    alert('Письмо отправлено');
//                }
//            });
             return true;
      } else {
          alert(err);
          return false;
      }
 }
