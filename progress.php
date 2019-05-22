<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /um-rmms");
}
if ($_SESSION['role'] == 'supervisor' && !isset($_SESSION['progress'])) {
  header("Location: supervisor/progressSupervisor.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <script type="text/javascript" src="js/progress/gco.js"></script>
  <title>UM Research Meeting Management System</title>
  <link rel="stylesheet" href="css/progress/gc.css" />
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
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css" />
  <link href="//fonts.googleapis.com/css?family=Mukta" rel="stylesheet" />
</head>

<body>
  <!--Delete message -->
  <div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Delete Message
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this task?<br />
          This cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary" onClick="remove()" data-dismiss="modal">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete message ends -->

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
        <li class="active">
          <a href="#">Manage Progress</a>
        </li>
        <li>
          <a href="<?php echo $_SESSION['role'] == 'student' ?  'reviewStudent.php' : 'supervisor/reviewSupervisor.php' ?>">Review Reports</a>
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
        Research Progress
      </h1>
      <?php
      if ($_SESSION['role'] == 'supervisor') echo '<h4 class="text-center">' . $_SESSION['progress'] . '</h4>'
      ?>
      <div class="container mt-3 p-3">
        <div id="chart_div"></div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="container mt-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Add Task</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Update Task</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <form>
                  <div class="form-group">
                    <label for="taskname">Task Name: </label>
                    <input type="text" class="form-control" id="taskname" placeholder="Enter task name" />
                  </div>

                  <div class="form-group">
                    <label for="sdate">Start Date: </label>
                    <input type="date" class="form-control" id="sdate" />
                  </div>

                  <div class="form-group">
                    <label for="edate">End Date: </label>
                    <input type="date" class="form-control" id="edate" />
                  </div>

                  <div class="form-group">
                    <label for="percent">Percent Complete</label>
                    <input type="number" class="form-control" id="percent" placeholder="Enter the percent" />
                  </div>

                  <div class="form-group">
                    <label for="depend">Dependencies</label>
                    <select class="selectpicker form-control" id="depend" multiple>
                    </select>
                  </div>

                  <div class="form-group">
                    <input class="btn btn-primary" id="add" type="button" value="Add Task" />
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form>
                  <div class="form-group">
                    <label for="taskname2">Task Name: </label>
                    <select id="taskname2" class="custom-select" required>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="sdate2">Start Date: </label>
                    <input type="date" class="form-control" id="sdate2" />
                  </div>

                  <div class="form-group">
                    <label for="edate2">End Date: </label>
                    <input type="date" class="form-control" id="edate2" />
                  </div>

                  <div class="form-group">
                    <label for="percent2">Percent Complete</label>
                    <input type="number" class="form-control" id="percent2" placeholder="Enter the percent" />
                  </div>

                  <div class="form-group">
                    <label for="depend2">Dependencies</label>
                    <select class="selectpicker form-control" id="depend2" multiple>
                    </select>
                  </div>

                  <div class="form-group">
                    <input class="btn btn-primary" id="update" type="button" value="Update Task" />

                    <input class="btn btn-primary" data-toggle="modal" data-target="#deleteAlert" id="remove" type="button" value="Remove Task" />
                  </div>
                </form>
              </div>
            </div>
          </div>
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

  <!-- jQuery CDN - Minified version -->
  <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- Popper.JS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <!-- Bootstrap JS -->
  <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/progress/gc.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="//cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>

  <script type="text/javascript">
    // data for gantt chart
    var data = [];
    // add all the tasks into the dropdown menu
    function updateTaskNames() {
      $("#taskname2").empty();
      data.forEach(function(item, index) {
        $("#taskname2").append(`<option>${item[0]}</option>`);
      });
    }
    // update the fields in the update section based on task name
    function updateForms(taskname) {
      var selectedItems = data.filter(d => d[0] === taskname);
      if (selectedItems.length != 0) {
        var selectedItem = selectedItems[0];
        // update fields
        var sdate2element = document.getElementById("sdate2");
        sdate2element.value = selectedItem[2].toISOString().substr(0, 10);
        var edate2element = document.getElementById("edate2");
        edate2element.value = selectedItem[3].toISOString().substr(0, 10);
        $("#percent2").val(selectedItem[5]);
        // add other tasks into dependency list except the task itself
        $("#depend2").empty();
        data.forEach(function(item, index) {
          if (item[0] !== taskname)
            $("#depend2").append(`<option>${item[0]}</option>`);
        });
        $("#depend2").selectpicker("refresh");
        // add default dependencies
        if (selectedItem[6] != null) {
          $("#depend2").selectpicker("val", selectedItem[6].split(","));
          $("#depend2").selectpicker("refresh");
        }
      }
    }

    function remove() {
      var id = $("#taskname2").val();
      var index = data.findIndex(e => e[0] === id);
      data.splice(index, 1);
      for (let i = 0; i < data.length; i++) {
        if (data[i][6] === null || data[i][6] === "") continue;
        let dependencies = data[i][6].split(",");
        let j = dependencies.findIndex(e => e === id);
        if (j !== -1) dependencies.splice(j, 1);
        data[i][6] = dependencies.join(",");
        if (data[i][6] === "") data[i][6] = null;
      }
      updateChart(data);
      updateTaskNames();
      if ($("#taskname2").val() !== "") {
        updateForms($("#taskname2").val());
      }
      $("#depend").empty();
      data.forEach(function(item, index) {
        $("#depend").append(`<option>${item[0]}</option>`);
      });
      $("#depend").selectpicker("refresh");
    }
    $(document).ready(function() {
      // side bar function
      $("#sidebarCollapse").on("click", function() {
        $("#sidebar").toggleClass("active");
        $(this).toggleClass("active");
      });

      // add options based on data
      updateTaskNames();
      // initial update for form fields
      if ($("#taskname2").val() !== "") {
        updateForms($("#taskname2").val());
      }
      // add form function
      $("#add").on("click", function() {
        var id = $("#taskname").val();
        var sdate = new Date($("#sdate").val());
        var edate = new Date($("#edate").val());
        var percent = parseInt($("#percent").val());
        var dependArr = $("#depend").val();
        var depend = dependArr.join(",");
        if (depend === "") depend = null;
        var newRow = [id, id, sdate, edate, null, percent, depend];
        data.push(newRow);
        updateChart(data);
        $("#depend").append(`<option>${id}</option>`);
        $("#depend").selectpicker("refresh");
        updateTaskNames();
        updateForms(data[0][0]);
      });
      // update fields based on task
      $("#taskname2").on("change", function() {
        updateForms($("#taskname2").val());
      });
      // update form function
      $("#update").on("click", function() {
        var id = $("#taskname2").val();
        var sdate = new Date($("#sdate2").val());
        var edate = new Date($("#edate2").val());
        var percent = parseInt($("#percent2").val());
        var dependArr = $("#depend2").val();
        var depend = dependArr.join(",");
        // if string is empty, make it null
        if (depend === "") depend = null;
        var newRow = [id, id, sdate, edate, null, percent, depend];
        data[data.findIndex(e => e[0] === id)] = newRow;
        updateChart(data);
        updateTaskNames();
        updateForms(data[0][0]);
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
              location.href = "/um-rmms";
            }
          }
        });
      });

      // $("#remove").on("click", function() {
      //   var id = $("#taskname2").val();
      //   var index = data.findIndex(e => e[0] === id);
      //   data.splice(index, 1);
      //   for (let i = 0; i < data.length; i++) {
      //     if (data[i][6] === null || data[i][6] === "") continue;
      //     let dependencies = data[i][6].split(",");
      //     let j = dependencies.findIndex(e => e === id);
      //     if (j !== -1) dependencies.splice(j, 1);
      //     data[i][6] = dependencies.join(",");
      //     if (data[i][6] === "") data[i][6] = null;
      //   }
      //   updateChart(data);
      //   updateTaskNames();
      //   if ($("#taskname2").val() !== "") {
      //     updateForms($("#taskname2").val());
      //   }
      //   $("#depend").empty();
      //   data.forEach(function(item, index) {
      //     $("#depend").append(`<option>${item[0]}</option>`);
      //   });
      //   $("#depend").selectpicker("refresh");
      // });
    });
  </script>
</body>

</html>