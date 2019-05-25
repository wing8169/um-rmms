<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /um-rmms");
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
        <li class="active">
          <a href="#">Review Reports</a>
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
        Submit Report
      </h1>
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <form novalidate method="POST" enctype="multipart/form-data" id="form">
            <div class="form-group">
              <label for="emailAddr">*Email address:</label>
              <select name="emailAddr" id="emailAddr" class="form-control custom-select">
                <?php
                try {
                  $connString = "mysql:host=127.0.0.1;dbname=umrmms";
                  $pdo = new PDO($connString, 'jiaxiong', 'jiaxiong');
                  $sql = "SELECT user.email FROM user INNER JOIN student ON student_id = '$_SESSION[id]';";
                  $cmd = $pdo->prepare($sql);
                  $cmd->execute();
                  $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
                  $isFirst = true;
                  foreach ($result as $row) {
                    if ($isFirst) {
                      echo  '<option value="' .  $row['email'] . " " . '"selected>' . $row['email'] . '</option>';
                    } else {
                      echo '<option value="' . $row['email'] . " " . '">' . $row['email'] . '</option>';
                    }
                    $isFirst = false;
                  }
                  $pdo = null;
                } catch (PDOException $e) {
                  echo " Error: " .  $e->getMessage();
                  exit;
                }
                ?></select>
              <small id="emailHelp" class="form-text text-muted" required>Recipient email</small>
            </div>
            <div class="form-group">
              <label for="reportname">*Report Name:</label>
              <input name="reportname" type="text" class="form-control" id="reportname" placeholder="Name of report" />
            </div>
            <div class="form-group">
              <label for="fileSubmit">*Please Upload Your Report:</label>
              <input name="fileSubmit" type="file" id="fileSubmit" class="form-control" accept=".doc,.docx,.pdf" />
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary" required id="submitreport">
                Submit
              </button>
            </div>
          </form>
        </div>
        <table class="table mt-5 ml-5 mr-5" id="reporttable">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Report Name</th>
              <th>Submission Date</th>
              <th>Reviewer</th>
              <th>Status</th>
              <th>Reviews</th>
              <th>Attachments</th>
            </tr>
          </thead>
          <tbody id="reporttablebody"></tbody>
        </table>
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
      // update table
      $.ajax({
        type: "POST",
        url: "php/reviewStudent/updateTable.php",
        data: {},
        cache: false,
        success: function(data) {
          data = JSON.parse(data);
          $.each(data, function(index, value) {
            $("#reporttablebody").append(
              `<tr>
              <td>${value["id"]}</td>
              <td>${value["name"]}</td>
              <td>${value["submission_date"]}</td>
              <td>${value["rec_name"]}</td>
              <td>${value["status"]}</td>
              <td>${value["review"]}</td>
              <td>
                <a href="${value["file_path"]}" target="_blank">Click to download report</a>
                <br>
                <br>
                <a href="${value["review_path"] == ''? '#' : value["review_path"]}" target="${value["review_path"] == ''? '_self' : '_blank'}">Click to download review report</a>
              </td>
            </tr>`
            );
          });
        }
      });
      $('#fileSubmit').on('change', function() {
        var file = this.files[0];
        // Also see .name, .type
      });
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
              location.href = "/um-rmms";
            }
          }
        });
      });
      $("#form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: "php/reviewStudent/studentSubmit.php",
          data: new FormData(this),
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            data = JSON.parse(data);
            alert(data['msg']);
            location.reload();
          }
        });
      });
    });
  </script>
</body>

</html>