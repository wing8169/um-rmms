<?php
include 'php/config.php';
session_start();
if (isset($_SESSION['user'])) {
  header("Location: /addMeeting.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <title>UM Research Meeting Management System</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />

  <link href="//fonts.googleapis.com/css?family=Frank+Ruhl+Libre:900" rel="stylesheet" />
  <link href="//fonts.googleapis.com/css?family=Julius+Sans+One" rel="stylesheet" />
  <link rel="shortcut icon" href="favicon.ico">

  <style>
    body {
      background-image: url("img/blueGradient1.png");
      background-repeat: no-repeat;
      background-size: cover;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    .container {
      padding-top: 5%;
    }

    span.signup {
      float: left;
      padding-top: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }

    .pswText {
      color: black;
    }

    .pswText:hover {
      color: #1a3054;
    }

    .jumbotron {
      background-color: white;
      border-radius: 2rem;
      max-width: 500px;
      box-shadow: 0 8px 16px -3px black;
    }

    .modal-content {
      border-color: #7ec4d3;
      border-radius: 2rem;
      padding: 10px;
    }

    .animate {
      -webkit-animation: animatezoom 0.6s;
      animation: animatezoom 0.6s;
    }

    #logo {
      border-radius: 200px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="justify-content-center">
      <img id="logo" src="img/umrmms.png" alt="" class="col" style="width:250px; height:250px;" />
      <h2 class="col text-center" style="font-family: 'Julius Sans One', sans-serif; color: white;">
        Welcome to
      </h2>

      <h1 class="col text-center" style="font-family: 'Julius Sans One', sans-serif;
          color: white;">
        <b> UM Research Meeting Management System</b>
      </h1>
    </div>

    <div class="row justify-content-center align-items-center">
      <form class="col-8 jumbotron mt-5 ml-3 mr-3" action="" novalidate method="POST">
        <div class="form-group">
          <label for="email"><b>Email</b></label>
          <input id="email" type="text" placeholder="Enter email" name="email" class="form-control" required />
        </div>
        <div class="form-group">
          <label for="psw"><b>Password</b></label>
          <input id="psw" type="password" placeholder="Enter Password" name="psw" class="form-control" required />
        </div>
        <div class="row justify-content-center">
          <button id="signin" type="button" class="btn btn-primary col-5">
            Login
          </button>
        </div>

        <span class="signup"><a href="#" data-toggle="modal" data-target="#signupModal" class="pswText">Sign up now.</a></span>
        <span class="psw"><a data-toggle="modal" data-target="#forgotModal" href="#" class="pswText">Forgot password?</a></span>
        <!-- Signup Modal -->
        <div class="modal fade" id="signupModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Sign up a new account.</h4>
                <button type="button" class="close" data-dismiss="modal">
                  &times;
                </button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label for="fullname"><b>Full Name</b></label>
                  <input id="fullname" type="text" placeholder="Enter your full name" name="fullname" class="form-control" required autofocus />
                </div>
                <div class="form-group">
                  <label for="emailSignUp"><b>Email</b></label>
                  <input id="emailSignUp" type="email" placeholder="Enter your email" name="emailSignUp" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="pswSignUp"><b>Password</b></label>
                  <input id="pswSignUp" type="password" placeholder="Set your password" name="pswSignUp" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="pswSignUpConfirm"><b>Password (Confirm)</b></label>
                  <input id="pswSignUpConfirm" type="password" placeholder="Enter password again" name="pswSignUpConfirm" class="form-control" required />
                </div>
                <div class="form-group">
                  <label for="role"><b>Select your role</b></label>
                  <select id="role" class="custom-select" required>
                    <option value="student">Student</option>
                    <option value="supervisor">Supervisor</option>
                  </select>
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="signup">
                  Sign Up Now
                </button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- Forgot password modal -->
        <div class="modal fade" id="forgotModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Reset password.</h4>
                <button type="button" class="close" data-dismiss="modal">
                  &times;
                </button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <div class="form-group">
                  <label for="emailForgot"><b>Please enter your email. A confirmation email will be
                      sent to you within 24 hours to reset your password.</b></label>
                  <input id="emailForgot" type="text" placeholder="Email address" name="emailForgot" class="form-control" required autofocus />
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button id="sendemail" type="button" class="btn btn-primary">
                  Send confirmation email
                </button>
                <button type="button" class="btn btn-dark" data-dismiss="modal">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <footer class="footer">
      <div class="container">
        <hr />
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center">
            <p>
              <span class="h6">UM Research Meeeting Management System Team</span>
              is a Registered Team of Web Programming Tutorial Group 2,
              Faculty of Computer Science and Information Technology,
              University of Malaya.
            </p>
            <p class="h6">
              Copyright &copy 2019
            </p>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!-- jQuery CDN - Minified version -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      // sign up operation
      $("#signup").click(function() {
        if ($("#pswSignUp").val() !== $("#pswSignUpConfirm").val()) {
          alert("Please check your password confirmation.");
        } else if ($("#fullname").val() == "" || $("#emailSignUp").val() == "" || $("#pswSignUp").val() == "") {
          alert("Please fill in all the required fields.");
        } else {
          let data = {
            "fullname": $("#fullname").val(),
            "email": $("#emailSignUp").val(),
            "psw": $("#pswSignUp").val(),
            "role": $("#role").val(),
          };
          $.ajax({
            type: "POST",
            url: "php/signup.php",
            data: data,
            cache: false,
            success: function(data) { // 'data' is the variable holding the return from PHP's echo
              data = JSON.parse(data);
              //check if what response is   
              if (data['status'] === "success") {
                alert(`Welcome ${data['msg']}, you have successfully registered an account in UM RMMS.`);
                location.href = 'addMeeting.php';
              } else {
                alert(data['msg']);
              }
            }
          });
        }
      });
      // sign in operation
      $("#signin").click(function() {
        if ($("#email").val() == "" || $("#psw").val() == "") {
          alert("Please do not leave the fields blank!");
        } else {
          // initialize data
          let data = {
            "email": $("#email").val(),
            "password": $("#psw").val(),
          };
          // send request
          $.ajax({
            type: "POST",
            url: "php/signin.php",
            data: data,
            cache: false,
            success: function(data) { // 'data' is the variable holding the return from PHP's echo
              data = JSON.parse(data);
              //check if what response is   
              if (data['status'] === "success") {
                location.href = '/addMeeting.php';
              } else {
                alert(data['msg']);
              }
            }
          });
        }
      });
      // send reset password email operation
      $("#sendemail").click(function() {
        $("#sendemail").attr('disabled', true);
        // send request
        $.ajax({
          type: "POST",
          url: "php/email.php",
          data: {
            email: $("#emailForgot").val(),
          },
          cache: false,
          success: function(data) { // 'data' is the variable holding the return from PHP's echo
            console.log(data);
            data = JSON.parse(data);
            // alert user
            alert(data['msg']);
            $("#sendemail").attr('disabled', false);
          }
        });
      });
    });
  </script>
</body>

</html>