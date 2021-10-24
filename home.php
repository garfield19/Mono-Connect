<?php
   session_start();
   $isLoggedIn =  $_SESSION['isLoggedIn'];
   $loanOffer =  (int)$_SESSION['loanOffer'];
   if(!$isLoggedIn){
       header('location:login.php');
   }
   $account_id =  $_SESSION['accountID'];
   //echo $account_id;
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Easy Loans - Loans in 5 minutes</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="assets/images/logo/logo-white.png">
      <!-- Core css -->
      <link href="assets/css/app.min.css" rel="stylesheet">
      <!-- page css -->
      <link href="assets/css/style.css" rel="stylesheet">
   </head>
   <body onload="getAccountData()">
      <div class="app">
         <div class="layout">
            <!-- Header START -->
            <div class="header">
               <div class="logo logo-dark">
                  <a href="index.php">
                  <img src="assets/images/logo/logo.png" alt="Logo">
                  </a>
               </div>
               <div class="nav-wrap">
                  <ul class="nav-left">
                  </ul>
                  <ul class="nav-right">
                     <li class="dropdown dropdown-animated scale-left">
                        <a href="javascript:void(0);" data-toggle="dropdown">
                        <i class="anticon anticon-bell notification-badge"></i>
                        </a>
                        <div class="dropdown-menu pop-notification">
                           <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                              <p class="text-dark font-weight-semibold m-b-0">
                                 <i class="anticon anticon-bell"></i>
                                 <span class="m-l-10">Notifications</span>
                              </p>
                           </div>
                           <div class="relative">
                           </div>
                        </div>
                     </li>
                     <li class="dropdown dropdown-animated scale-left">
                        <div class="pointer" data-toggle="dropdown">
                           <div class="avatar avatar-text bg-primary">
                              <span>DO</span>
                           </div>
                        </div>
                        <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                           <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div>
                                    <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                    <span class="m-l-10">Edit Profile</span>
                                 </div>
                                 <i class="anticon font-size-10 anticon-right"></i>
                              </div>
                           </a>
                           <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div>
                                    <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                    <span class="m-l-10">Account Setting</span>
                                 </div>
                                 <i class="anticon font-size-10 anticon-right"></i>
                              </div>
                           </a>
                           <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div>
                                    <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                    <span class="m-l-10">Logout</span>
                                 </div>
                                 <i class="anticon font-size-10 anticon-right"></i>
                              </div>
                           </a>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
            <!-- Header END -->
            <!-- Side Nav START -->
            <div class="side-nav">
               <div class="side-nav-inner">
                  <ul class="side-nav-menu scrollable">
                     <li class="offer_side_bar">
                        <span class="display-5">You have a loan offer of</span> 
                        <div class="m-t-20">
                           <span class="offer_amount_prefix">&#8358;</span><span class="offer_amount" id="offer_amount"><?=$loanOffer; ?></span><span class="offer_amount_prefix">.00</span>
                        </div>
                        <button id="updateOffer" class="btn btn-primary m-r-5">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span>Get Offer</span>
                        </button>
                     </li>
                     <hr/>
                  </ul>
               </div>
            </div>
            <!-- Side Nav END -->
            <!-- Page Container START -->
            <div class="notification-toast top-right" id="notification-toast"></div>
            <div class="page-container">
               <!-- Content Wrapper START -->
               <div class="main-content">
                  <div class="row">
                     <div class="col-lg-4">
                        <div class="card">
                           <img class="card-img-top" src="assets/images/others/instant.png" alt="">
                           <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                 <h3 class="card_title_text">Get <b>Instant</b> Loan</h3>
                              </div>
                              <div class="d-flex align-items-center m-t-20 card-body-margin">
                                 <p>Get <span class="text-success font-weight-bold">instant</span> loan offer and disburse to your account in 5 minutes.</p>
                              </div>
                              <div class="box">
                                 <button href="javascript:void(0);" data-toggle="modal" data-target="#quick-view" class="btn btn-success btn-tone m-r-5 m-t-20">Withdraw</button>
                                 </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="card">
                           <img class="card-img-top" src="assets/images/others/refund.png" alt="">
                           <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                 <h3 class="card_title_text">Pay Loan <b>Seamlessly</b></h3>
                              </div>
                              <div class="d-flex align-items-center m-t-20 card-body-margin">
                                 <p>Repay loans at your <span class="text-primary font-weight-bold">convenience</span> at the click of a button.</p>
                              </div>
                              <div class="box">
                                 <button class="btn btn-primary btn-tone m-r-5 m-t-20" id="payLoan">Repay</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="card">
                           <div class="bg-overlay bg" style="background-image: url('assets/images/others/bg.png')">
                              <div class="card-body">
                                 <div class="m-b-20">
                                    <h4>Pending Loan Payments </h4>
                                    <div class="row">
                                       <div class="col-md-9">
                                          <div class="m-t-20">
                                             <span class="offer_amount_prefix">&#8358;</span><span class="offer_amount" id="debt">0</span><span class="offer_amount_prefix">.00</span>
                                          </div>
                                          <span class="badge badge-info">Loan Tip</span> Repay loans early to increase your loan offer.
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                 <h5>Transactions</h5>
                              </div>
                              <div class="m-t-20">
                                 <div class="table-responsive">
                                    <table class="table table-hover">
                                       <thead>
                                          <tr>
                                             <th>Date</th>
                                             <th>Amount</th>
                                             <th>Type</th>
                                             <th>Reference</th>
                                          </tr>
                                       </thead>
                                       <tbody id="transactions">
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Content Wrapper END -->
               <!-- Footer START -->
               <footer class="footer">
                  <div class="footer-content">
                     <p class="m-b-0">Copyright © 2021 Easy Loans. All rights reserved.</p>
                     <span>
                     <a href="" class="text-gray m-r-15">Term &amp; Conditions</a>
                     <a href="" class="text-gray">Privacy &amp; Policy</a>
                     </span>
                  </div>
               </footer>
               <!-- Footer END -->
            </div>
            <!-- Page Container END -->
            <!-- Quick View START -->
            <div class="modal fade" id="noOfferModal">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">No Offer</h5>
                        <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                        </button>
                     </div>
                     <div class="modal-body">
                        You do not have a loan offer, click the update offer button on the left side of your screen to get an offer.
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Quick View START -->
            <div class="modal modal-right fade quick-view" id="quick-view">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header justify-content-between align-items-center">
                        <h5 class="modal-title">Loan Calculator</h5>
                     </div>
                     <div class="modal-body scrollable">
                        <div class="m-b-30">
                           <h6>
                           You cant withdraw loans when you have a pending loan payment.
                           <h6>
                           <form>
                              <div class="form-group">
                                 <label for="amountToWithdraw">Enter the amount you need. Maximum of &#8358;<span id="maxOffer"></span></label>
                                 <input type="number" class="form-control" id="amountToWithdraw" placeholder="Amount to withdraw">
                              </div>
                           </form>
                        </div>
                        <hr>
                        <div>
                           <h5 class="m-b-0">Loan Summary</h5>
                           <p>Loan Amount : &#8358;<span id="loanAmout">0</span></p>
                           <p>Duration : Flexible</p>
                           <p>Interest Rate : 1%</p>
                           <p>Repayment Amount : &#8358;<span id="repaymentAmout">0</span></p>
                        </div>
                        <hr>
                        <button id="processLoan" class="btn btn-primary m-r-5">
                        <i class="anticon anticon-loading m-r-5"></i>
                        <span>Continue</span>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Quick View END -->
         </div>
      </div>
      <!-- Core Vendors JS -->
      <script src="assets/js/vendors.min.js"></script>
      <!-- page js -->
      <script type="text/javascript">
         var account_id = "<?php echo $account_id; ?>";
      </script>
      <script src="assets/js/home-js.js"></script>
      <!-- Core JS -->
      <script src="assets/js/app.min.js"></script>
   </body>
</html>
