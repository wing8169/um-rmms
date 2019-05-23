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
  <link rel="stylesheet" href="css/checklist/styleChecklist.css" />
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
        <li class="active">
          <a href="#">Checklist</a>
        </li>
        <li>
          <a href="progress.php">Manage Progress</a>
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
        Checklist
      </h1>
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12">
          <!-- Add new item -->
          <div class="row justify-content-center">
            <div class="add col-xs-12 col-md-6 mb-3">
              <input name="addtask" class="addtask form-control" id="addtask" type="text" placeholder=" + Add Task" />
            </div>
          </div>

          <div class="editgroup-off">
            <div class="item editdeadline">
              <p><i class="far fa-calendar-alt "></i>Deadline</p>
              <input class="deadline_day" type="date" id="deadlinedate" />
              <input class="deadline_time" type="time" id="deadlinetime" />
            </div>
            <div class="item editcomment">
              <p><i class="far fa-comment-alt "></i>Comment</p>
              <input class="comment" type="text" id="comment" />
              <div class="setting">
                <P class="cancel"><i class="fas fa-times"></i>Cancel</P>
                <P class="save" id="savelist"><i class="far fa-save"></i>Save</P>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <!-- To do list -->
            <div class="todolist" id="todolist"></div>
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
  <script type="text/javascript">
    $(document).ready(function() {
      // update table
      $.ajax({
        type: "POST",
        url: "php/checklist/selectList.php",
        data: {},
        cache: false,
        success: function(data) {
          data = JSON.parse(data);
          $.each(data, function(index, value) {
            $("#todolist").append(
              `<div class="${value['favourite']==1?"listitem important":"listitem"}">
                <div class="main">
                  <input type="checkbox" class="checkbox" id="${value["id"] + "checkbox"}"/>
                  <p>${value["title"]}</p>
                  <i class="${value['favourite']==1?"far fa-star fa-lg star":"far fa-star fa-lg star"}" id="${value['id']}fav"></i>
                  <i class="far fa-edit fa-lg pen"></i>
                </div>
                <div class="detail">
                  <span class="icon"><i class="far fa-calendar-alt "></i>${value["date_str"]}</span>
                  <span class="icon"><i class="far fa-file "></i></span>
                  <span class="icon"><i class="far fa-comment-alt "></i></span>
                </div>
                <div class="itemeditgroup">
                  <div class="item editdeadline">
                    <p><i class="far fa-calendar-alt "></i>Deadline</p>
                    <input class="deadline_day" type="date" id="${value["id"] + "date"}" value="${value["date_str"]}" />
                    <input class="deadline_time" type="time" id="${value["id"] + "time"}" value="${value["time_str"]}" />
                  </div>
                  <div class="item editcomment">
                    <p><i class="far fa-comment-alt "></i>Comment</p>
                    <input class="comment" id="${value["id"] + "comment"}" type="text" value="${value["comment"]}" />
                  </div>
                  <div class="setting">
                    <P class="cancel"><i class="fas fa-times"></i>Cancel</P>
                    <P class="save" id="${value["id"] + "save"}"><i class="far fa-save"></i>Save</P>
                  </div>
                </div>
              </div>`
            );
            if (value['checked'] == 1) {
              $(`#${value['id']}checkbox`).prop("checked", true);
            }
            $(`#${value['id']}checkbox`).change(function() {
              let checked = this.checked ? 1 : 0;
              // send request
              $.ajax({
                type: "POST",
                url: "php/checklist/checkboxChange.php",
                data: {
                  "checked": checked,
                  "id": value['id'],
                },
                cache: false,
                success: function(data) {}
              });
            });
            $(`#${value['id']}save`).click(function() {
              let deadline = $(`#${value['id']}date`).val() + " " + $(`#${value['id']}time`).val() + ":00";
              let comment = $(`#${value['id']}comment`).val();
              // send request
              $.ajax({
                type: "POST",
                url: "php/checklist/updateList.php",
                data: {
                  "deadline": deadline,
                  "comment": comment,
                  "id": value['id'],
                },
                cache: false,
                success: function(data) {
                  location.reload(true);
                }
              });
            });
            $(`#${value['id']}fav`).click(function() {
              let favourite = $(`#${value['id']}fav`).hasClass("fas") ? 0 : 1;
              // send request
              $.ajax({
                type: "POST",
                url: "php/checklist/favChange.php",
                data: {
                  "favourite": favourite,
                  "id": value['id'],
                },
                cache: false,
                success: function(data) {}
              });
            });
            if (value['favourite'] == 1) {
              setTimeout(() => {
                $(`#${value['id']}fav`).addClass("fas");
                $(`#${value['id']}`).addClass("important");
              }, 500);
            }
          });
          var script = document.createElement("script");
          script.src = "js/checklist/index.js";
          script.type = "text/javascript";
          document.getElementsByTagName("head")[0].appendChild(script);
        }
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
      // insert new list
      $("#savelist").click(function() {
        // get data
        let title = $("#addtask").val();
        let deadlinedate = $("#deadlinedate").val() + " " + $("#deadlinetime").val() + ":00";
        let comment = $("#comment").val();
        // send request
        $.ajax({
          type: "POST",
          url: "php/checklist/insertList.php",
          data: {
            "title": title,
            "deadlinedate": deadlinedate,
            "comment": comment,
          },
          cache: false,
          success: function(data) {
            location.reload(true);
          }
        });
      });
    });
  </script>
</body>

</html>