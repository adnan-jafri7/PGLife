window.addEventListener("load", function () {
    var login_form = document.getElementById("login-form");
    var logout = document.getElementById("logout");
    login_form.addEventListener("submit", function (event) {
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(login_form);

        // On success
        XHR.addEventListener("load", login_success);

        // On error
        XHR.addEventListener("error", on_error);

        // Set up request
        XHR.open("POST", "api/login_submit.php");

        // Form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });

    logout.addEventListener(function (event) {
        var XHR2 = new XMLHttpRequest();

        // On success
        XHR2.addEventListener("load", login_success);

        // On error
        XHR2.addEventListener("error", on_error);

        // Set up request
        XHR2.open("POST", "api/logout.php");

        // Form data is sent with request
        XHR2.send();

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });




   //add code corresponding to login form as a part of your assignment
});

var login_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        alert(response.message);
        window.location.href = "index.php";
    } else {
        alert(response.message);
    }
};

//add function corresponding to login_success as a part of your assignment

var on_error = function (event) {
    document.getElementById("loading").style.display = 'none';

    alert('Oops! Something went wrong.');
};
