document.addEventListener('DOMContentLoaded', () => {
    const btnLogin = document.getElementById('btn-login');
    const btnRegister = document.getElementById('btn-register');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    const toggleForms = (show, hide, activeBtn, inactiveBtn) => {
        hide.classList.remove('active');
        show.classList.add('active');
        inactiveBtn.classList.remove('active');
        activeBtn.classList.add('active');
    };

    btnLogin.addEventListener('click', () => {
        toggleForms(loginForm, registerForm, btnLogin, btnRegister);
    });

    btnRegister.addEventListener('click', () => {
        toggleForms(registerForm, loginForm, btnRegister, btnLogin);
    });

    const forms = document.querySelectorAll('.auth-form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const action = form.parentElement.id === 'loginForm' ? 'Login' : 'Registration';
            // alert(`${action} successful! Neural-link sequence initialized.`);
        });
    });
});

function createAccount() {

    $.ajax({
        url: "/api/register-user",
        type: "POST",
        data: $('#registerForm').serialize(),
       beforeSend: function(){
            $("#spinnerLoader").css("display", "flex");
            $("body").css("overflow", "hidden"); // scroll disable
        },
        success: function(response)
        {
            console.log(response);
            if(response.status==1){
                alert(response.message);

            }else{
              if (response.status == 0) {
                    // Agar multiple errors ho to join kar lo
                    alert(response.errors);
                } else {
                    alert("Signup Successful ✅");
                }


                    $("#spinnerLoader").fadeOut();


            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
        complete: function(){
            $("#spinnerLoader").hide();
            $("body").css("overflow", "auto"); // scroll enable
        }
    });

}

function loginAccount(){


     $.ajax({
          headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: "/login-user",
        type: "POST",
        data: $('#loginForm').serialize(),
       beforeSend: function(){
            $("#spinnerLoader").css("display", "flex");
            $("body").css("overflow", "hidden"); // scroll disable
        },
        success: function(response)
        {

            if(response.status==1){

                alert(response.message);
                window.location.href = response.redirect;

            }else{
              if (response.status == 0) {

                    alert(response.errors);
                }

            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        },
        complete: function(){
            $("#spinnerLoader").hide();
            $("body").css("overflow", "auto");
        }
    });

}
