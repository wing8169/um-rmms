<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /");
}
if (isset($_SESSION['role']) && $_SESSION['role'] != 'supervisor') {
  header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>UM Research Meeting Management System</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- Font Awesome JS -->
  <script defer src="//use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="//use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  <!-- Google Font -->
  <link href="//fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
  <!-- icon -->
  <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
  <link href="//fonts.googleapis.com/css?family=Mukta" rel="stylesheet" />
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    tbody {
      display: block;
      max-height: 500px;
      overflow-y: auto;
    }

    thead,
    tbody tr {
      display: table;
      width: 100%;
      table-layout: fixed;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
      <div class="sidebar-header">
        <img src="img/umrmms.png" alt="UM RMMS" />
        <h5 class="text-center">Welcome back, <?php echo $_SESSION['fullname']; ?>.</h5>
      </div>

      <ul class="list-unstyled components">
        <li>
          <a href="addMeeting.php">Meeting Schedule</a>
        </li>
        <li>
          <a href="manageMeeting.php">Manage Meeting Records</a>
        </li>
        <li>
          <a href="checklist.php">Checklist</a>
        </li>
        <li>
          <a href="progress.php">Manage Progress</a>
        </li>
        <li>
          <a href="<?php echo $_SESSION['role'] == 'student' ?  'reviewStudent.php' : 'supervisor/reviewSupervisor.php' ?>">Review Reports</a>
        </li>
        <li class="active">
          <a href="#">Manage Students</a>
        </li>
      </ul>

      <ul class="list-unstyled CTAs">
        <li>
          <a href="#" class="download" id="logout">Log Out</a>
        </li>
      </ul>
    </nav>
    <div id="content">
      <button type="button" id="sidebarCollapse" class="navbar-btn">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <h1 class="text-center mt-3 mb-3" style="font-family: 'Mukta', sans-serif;color: #7BABED;">
        <?php
        if ($_SESSION['role'] == 'student') {
          echo 'Manage Supervisors';
        } else {
          echo 'Manage Students';
        }
        ?>
      </h1>
      <div class="row justify-content-center" id="cardcontainer"></div>

      <div class="row justify-content-center align-items-center">
        <form class="col-7 container mt-5 ml-3 mr-3" action="" novalidate method="POST">
          <div class="form-group">
            <input id="email" type="text" placeholder="Enter email" name="email" class="form-control typeahead" required />
          </div>
          <div class="text-center">
            <button id="addstudent" type="button" class="btn btn-primary mt-3">
              Add Student
            </button>
            <button id="removestudent" type="button" class="btn btn-primary mt-3">
              Remove Student
            </button>
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
  </div>
  <!-- jQuery CDN - Minified version -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      // update cards
      $.ajax({
        type: "POST",
        url: "php/progress/selectCards.php",
        data: {},
        cache: false,
        success: function(data) {
          data = JSON.parse(data);
          $.each(data, function(index, value) {
            $("#cardcontainer").append(
              `<div class="card text-center pt-5 pb-5 ml-3 mr-3 mt-3 mb-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">${value['full_name']}</h5>
                  <p class="card-text">
                    ${value['email']}
                  </p>
                </div>
              </div>`
            );
          });
        }
      });
      $("#logout").click(function() {
        // send request
        $.ajax({
          type: "POST",
          url: "php/signout.php",
          data: {},
          cache: false,
          success: function(data) {
            if (data == "success") {
              location.href = "/";
            }
          }
        });
      });
      // side bar function
      $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
        $(this).toggleClass("active");
      });
      //add student under supervisor
      $("#addstudent").click(function() {
        let data = {
          "email": $("#email").val(),
        }
        $.ajax({
          type: "POST",
          url: "php/manageUser/addStudent.php",
          data: data,
          cache: false,
          success: function(data) {
            data = JSON.parse(data);
            if (data["status"] === "success") {
              alert(data['msg']);
              location.reload();
            } else {
              alert(data['msg']);
            }
          }
        });
      });

      //remove student under supervisor
      $("#removestudent").click(function() {
        let data = {
          "email": $("#email").val(),
        }
        $.ajax({
          type: "POST",
          url: "php/manageUser/removeStudent.php",
          data: data,
          cache: false,
          success: function(data) {
            data = JSON.parse(data);
            if (data["status"] === "success") {
              location.reload();
              alert(data['msg']);
            } else {
              alert(data['msg']);
            }
          }
        });
      })

    })
  </script>
  <script src="js/autocomplete.js"></script>
</body>

</html>