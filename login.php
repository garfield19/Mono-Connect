<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Easy Loans - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="assets/css/app.min.css" rel="stylesheet">

</head>

<body>
    <div class="app">
    <div class="notification-toast top-right" id="notification-toast"></div>
        <div class="container-fluid p-0 h-100">
            <div class="row no-gutters h-100 full-height">
                <div class="col-lg-4 d-none d-lg-flex bg" style="background-image:url('assets/images/others/signup.jpg')">
                    <div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
                        <div>
                            <img src="assets/images/logo/logo-white.png" alt="">
                        </div>
                        <div>
                            <h1 class="text-white m-b-20 font-weight-normal">Login to easy loans</h1>
                            <p class="text-white font-size-16 lh-2 w-80 opacity-08">Get huge loans here, pay back when ever you want.</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-white">© 2021 Easy Loans</span>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-white text-link" href="">Legal</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-white text-link" href="">Privacy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 bg-white">
                    <div class="container h-100">
                        <div class="row no-gutters h-100 align-items-center">
                            <div class="col-md-8 col-lg-7 col-xl-6 mx-auto">
                                <h2>Sign In</h2>
                                <p class="m-b-30">Enter your credential</p>
                                <form>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="inputEmail">Email:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="inputPassword">Password:</label>
                                        <a class="float-right font-size-13 text-muted" href="">Forget Password?</a>
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock"></i>
                                            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-size-13 text-muted">
                                                Don't have an account? 
                                                <a class="small" href="link-account.html"> Signup</a>
                                            </span>
                                            <button class="btn btn-primary" id="signIn">Sign In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core Vendors JS -->
    <script src="assets/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="assets/js/app.min.js"></script>

    <script type="application/javascript">
    $('#signIn').click(function(e) {
            e.preventDefault();
            $("#submitForm").toggleClass("is-loading");
   $.ajax({
      url: 'api/public/api/v1/loginUser',
      data: {
         'email': $('#inputEmail').val(),
         'password': $('#inputPassword').val()
      },
      error: function() {
        errorToast();
        $("#submitForm").removeClass("is-loading");
      },
      dataType: 'text',
      success: function(data) {
          console.log(data);
          if(data = "1"){
            window.location.replace("http://localhost/app/home.php");
          }else{
            errorToast();
            $("#submitForm").removeClass("is-loading");
          }
      },
      type: 'POST'
   });
});


function errorToast() {
    var toastHTML = `<div class="toast fade hide" data-delay="3000">
        <div class="toast-header">
            <i class="anticon anticon-info-circle text-danger m-r-5"></i>
            <strong class="mr-auto">Something Went Wrong</strong>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            There was an error with your request, please try again.
        </div>
    </div>`

    $('#notification-toast').append(toastHTML)
    $('#notification-toast .toast').toast('show');
    setTimeout(function(){ 
        $('#notification-toast .toast:first-child').remove();
    }, 5000);
}

</script>


</body>

</html>