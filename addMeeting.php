<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /");
}
include('php/addMeeting/selectMeeting.php');
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
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/addMeeting/calendar.css" />
  <!-- Font Awesome JS -->
  <script defer src="//use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
  <script defer src="//use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  <link href="//fonts.googleapis.com/css?family=Mukta" rel="stylesheet" />
  <link rel="shortcut icon" href="favicon.ico">
  <style>
    #calendar {
      margin-left: auto !important;
      margin-right: auto !important;
      margin-bottom: 20px !important;
      width: 95vh !important;
      height: 100% !important;
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
        <li class="active">
          <a href="#">Meeting Schedule</a>
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
        <?php
        if ($_SESSION['role'] == 'supervisor') {
          echo '<li>
            <a href="manageStudents.php">Manage Students</a>
          </li>';
        }
        ?>
      </ul>

      <ul class="list-unstyled CTAs">
        <li>
          <a href="#" class="download" id="logout">Log Out</a>
        </li>
      </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
      <button type="button" id="sidebarCollapse" class="navbar-btn">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <h1 class="text-center mt-3 mb-3" style="font-family: 'Mukta', sans-serif;color: #7BABED;">
        Meeting Schedule
      </h1>
      <!-- calendar control -->
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12">
          <div class="row mb-3 mt-3">
            <div class="btn-group col-md-12 col-lg-4 mb-3">
              <button class="btn btn-primary" data-calendar-nav="prev">
                << Prev </button> <button class="btn btn-primary" data-calendar-nav="today">
                  Today
              </button>
              <button class="btn btn-primary" data-calendar-nav="next">
                Next >>
              </button>
            </div>
            <div class="page-header col-md-12 col-lg-4 text-center mb-3">
              <h3></h3>
            </div>

            <div class="btn-group col-md-12 offset-lg-1 col-lg-3 mb-3">
              <button class="btn btn-primary" data-calendar-view="year">
                Year
              </button>
              <button class="btn btn-primary active" data-calendar-view="month">
                Month
              </button>
              <button class="btn btn-primary" data-calendar-view="week">
                Week
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- calendar put here -->
      <div class="row">
        <div id="calendar"></div>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <!-- form put here -->
          <form novalidate method="POST">
            <div class="form-group">
              <label for="datepicker">Date*</label>
              <input type="date" class="form-control" id="datepicker" required />
            </div>

            <div class="form-group">
              <label for="starttime">Start Time*</label>
              <input type="time" class="form-control" id="starttime" required />
            </div>

            <div class="form-group">
              <label for="endtime">End Time*</label>
              <input type="time" class="form-control" id="endtime" required />
            </div>

            <div class="form-group">
              <label for="title">Title*</label>
              <input type="text" class="form-control" id="title" placeholder="Title of Meeting" required />
            </div>

            <div class="form-group">
              <label for="venue">Venue*</label>
              <select id="venue" class="custom-select" required>
                <option value="">Select a venue*</option>
                <option value="MM4, FCSIT">MM4, FCSIT</option>
                <option value="DK2, FCSIT">DK2, FCSIT</option>
                <option value="DK1, FCSIT">DK1, FCSIT</option>
              </select>
            </div>

            <div class="form-group">
              <label for="notification">Notification</label>
              <select id="notification" class="custom-select" required>
                <option value="0">No Notification</option>
                <option value="1">30 minutes before meeting</option>
                <option value="2">1 hour before meeting</option>
                <option value="3">2 hours before meeting</option>
              </select>
            </div>

            <div class="form-group">
              <label for="description">Descriptions</label>
              <textarea class="form-control" id="description" rows="5" style="height:100%;" placeholder="The meeting descriptions"></textarea>
            </div>

            <div class="form-group">
              <label for="guests">Add Guests (separated with comma)</label>
              <input type="text" class="form-control typeahead" id="guests" />
            </div>
            <div class="row justify-content-center">
              <button type="button" class="btn btn-primary" id="addmeeting">
                Add Meeting
              </button>
            </div>
          </form>
        </div>
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
  <script>
    function getDate(milli) {
      var tmp = new Date(parseInt(milli));
      return tmp.toLocaleDateString();
    }

    function getTime(milli) {
      var tmp = new Date(parseInt(milli));
      var tmpTime = tmp.toLocaleTimeString();
      return tmpTime.slice(0, 5) + " " + tmpTime.slice(8).toLowerCase();
    }
  </script>
  <!-- jQuery CDN - Minified version -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script src="js/addMeeting/underscore-min.js"></script>
  <script src="js/addMeeting/calendar.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      setTimeout(() => {
        var script = document.createElement("script");
        script.src = "js/addMeeting/app.js";
        script.type = "text/javascript";
        document.getElementsByTagName("head")[0].appendChild(script);
      }, 1000);
      $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
        $(this).toggleClass("active");
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
      $("#addmeeting").click(function() {
        if ($("#datepicker").val() == "" || $("#starttime").val() == "" || $("#endtime").val() == "" || $("#title").val() == "" || $("#venue").val() == "") {
          alert("Please fill in all the required fields.");
          return;
        }
        let starttime = $("#datepicker").val() + " " + $("#starttime").val() + ":00";
        let endtime = $("#datepicker").val() + " " + $("#endtime").val() + ":00";
        let title = $("#title").val();
        let venue = $("#venue").val();
        let notification = $("#notification").val();
        let description = $("#description").val();
        let guests = $("#guests").val();
        let data = {
          "start_time": starttime,
          "end_time": endtime,
          "title": title,
          "venue": venue,
          "notification": notification,
          "description": description,
          "guests": guests,
        };
        // send request
        $.ajax({
          type: "POST",
          url: "php/addMeeting/addMeeting.php",
          data: data,
          cache: false,
          success: function(data) {
            console.log(data);
            data = JSON.parse(data);
            alert(data["msg"]);
            setTimeout(function() {
              // hard reload
              location.reload(true);
            }, 1000);
          }
        });
      });
    });
  </script>
  <!-- <script src="js/addMeeting/app.js"></script> -->
  <script src="js/autocomplete.js"></script>
</body>

</html>