<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Easy Loans - Link Your Account</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/logo/logo-white.png">
      <!-- page css -->
      <!-- Core css -->
      <link href="assets/css/app.min.css" rel="stylesheet">
      <!-- Mono js -->
      <script type="application/javascript" src="https://connect.withmono.com/connect.js"></script>
   </head>
   <body>
      <div class="app">
         <div class="container-fluid p-0 h-100" >
            <div class="row no-gutters h-100 full-height">
               <div class="col-lg-4 d-none d-lg-flex bg" style="background-image:url('assets/images/others/signup.jpg')">
                  <div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
                     <div>
                        <img src="assets/images/logo/logo-white.png" alt="">
                     </div>
                     <div>
                        <h1 class="text-white m-b-20 font-weight-normal">Easy Loans</h1>
                        <p class="text-white font-size-16 lh-2 w-80 opacity-08">Get huge loans here, pay back when ever your want.</p>
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
               <div class="notification-toast top-right" id="notification-toast"></div>
               <div class="col-lg-8 bg-white">
                  <div class="container h-100">
                     <div class="row no-gutters h-100 align-items-center">
                        <div class="col-md-8 col-lg-7 col-xl-6 mx-auto">
                           <h2>Sign Up</h2>
                           <span class="m-b-30">You need to connect your bank account to access easy loans.</span>
                           <button class="btn btn-primary btn-lg btn-block" id="connect-btn">
                           <i class="anticon anticon-loading m-r-5"></i>
                           <span>Connect Bank Account</span>
                           </button>
                           <hr>
                           <p></p>
                           <div class="m-t-25" style="max-width: 700px">
                              <form>
                                 <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label for="inputFullName">Full Name</label>
                                       <input type="text" class="form-control" id="inputFullName" placeholder="Jane Doe" disabled required>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label for="inputPhone">Phone Number</label>
                                       <input type="text" class="form-control" id="inputPhone" placeholder="080" disabled required>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label for="inputEmail">Email</label>
                                       <input type="email" class="form-control" id="inputEmail" placeholder="Email" disabled required>
                                    </div>
                                    <div class="form-group col-md-6">
                                       <label for="inputPassword">Password</label>
                                       <input type="password" class="form-control" id="inputPassword" placeholder="Password" required>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" disabled required>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" disabled required>
                                 </div>
                                 <input type="hidden" id="inputAccountID"> 
                                 <button id="submitForm" class="btn btn-primary"> <i class="anticon anticon-loading m-r-5"></i>Sign Up</button>
                              </form>
                           </div>
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
      <script src="assets/js/include-footer.js"></script>
      <!-- Core JS -->
      <script src="assets/js/app.min.js"></script>
   </body>
</html>