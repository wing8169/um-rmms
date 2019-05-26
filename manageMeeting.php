<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /um-rmms");
}

//Get Heroku ClearDB connection information
$cleardb_url      = parse_url("mysql://bca398946056c0:db2a3802@us-cdbr-iron-east-02.cleardb.net/heroku_8ac57aa6a74cd67?reconnect=true");

$cleardb_server   = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db       = substr($cleardb_url["path"], 1);
$connString = "mysql:host=$cleardb_server;dbname=$cleardb_db";

try {
  $pdo = new PDO($connString, $cleardb_username, $cleardb_password);
  $user_id = $_SESSION["id"];

  $query1 = "SELECT * FROM meeting WHERE user_id  = '$user_id' OR ID in (SELECT meeting_id FROM guest WHERE user_id = '$user_id');";
  $result1 = $pdo->query($query1);

  $records = array();
  while ($row = $result1->fetch()) {
    $starttime =    explode(" ", $row['start_time']);
    $endtime =    explode(" ", $row['end_time']);
    $records[] = array('ID' => $row['ID'], 'user_id' => $row['user_id'], 'date' => $starttime[0], 'start_time' => $starttime[1], 'end_time' => $endtime[1], 'title' => $row['title'], 'venue' => $row['venue'], 'notification' => $row['notification'], 'description' => $row['description']);
  }
  $query2 = "SELECT meeting_notes.ID, user.full_name, meeting_notes.title, meeting_notes.description, meeting_notes.meeting_id FROM meeting_notes INNER JOIN user ON user.ID = meeting_notes.user_id WHERE meeting_id in (SELECT ID from `meeting` WHERE user_id='$user_id' UNION SELECT meeting_id FROM guest WHERE user_id='$user_id');";
  $result2 = $pdo->query($query2);
  $meeting_notes = array();
  while ($row = $result2->fetch()) {
    $meeting_notes[] = array('meetingnotesID' => $row['ID'], 'full_name' => $row['full_name'], 'title' => $row['title'], 'note_description' => $row['description']);
  }
  $query3 = "SELECT full_name FROM user where ID = $user_id;";
  $result3 = $pdo->query($query3);
  $full_name = $result3->fetch();
  $fullname = $full_name[0];
  $pdo = null;
} catch (PDOException $e) {
  echo " Error: " .  $e->getMessage();
  exit;
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
  <link rel="stylesheet" href="css/manageMeeting/meetingrecord.css" />
  <link href="//fonts.googleapis.com/css?family=Mukta" rel="stylesheet" />
  <link rel="shortcut icon" href="favicon.ico">
</head>

<body>
  <?php foreach ($records as $record) { ?>
    <!-- Delete meeting modal starts -->
    <div class="modal fade" id="delete<?php echo "$record[ID]"; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post">
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
              Are you sure you want to delete this meeting?<br />
              This cannot be undone.
            </div>
            <input type="hidden" name="delete_id" value="<?php echo "$record[ID]"; ?>">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary" name="delete" <?php
                                                                          // get user_id of meeting owner
                                                                          $pdo = new PDO($connString, $cleardb_username, $cleardb_password);
                                                                          $query = "SELECT user_id FROM meeting WHERE ID='$record[ID]'";
                                                                          $result = $pdo->query($query);
                                                                          $owner_id = "";
                                                                          while ($row = $result->fetch()) {
                                                                            $owner_id = $row['user_id'];
                                                                          }
                                                                          $pdo = null;
                                                                          if ($_SESSION['id'] != $owner_id) echo "disabled";
                                                                          ?>>
                Delete
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Delete meeting modal ends -->

    <!-- Edit modal starts -->
    <div class="modal fade" id="edit<?php echo "$record[ID]"; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              Update Meeting Record
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form starts here -->
            <form novalidate method="POST">
              <div class="form-group">
                <label for="datepicker">Date*</label>
                <input type="date" class="form-control" name="datepicker" value="<?php echo "$record[date]"; ?>" required />
              </div>

              <div class="form-group">
                <label for="starttime">Start Time*</label>
                <input type="time" class="form-control" name="starttime" value="<?php echo "$record[start_time]"; ?>" required />
              </div>

              <div class="form-group">
                <label for="endtime">End Time*</label>
                <input type="time" class="form-control" name="endtime" value="<?php echo "$record[end_time]"; ?>" required />
              </div>

              <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" class="form-control" name="title" value="<?php echo "$record[title]"; ?>" disabled />
              </div>

              <div class="form-group">
                <label for="venue">Venue*</label>
                <select class="custom-select" name="venue" required>
                  <option value="FCSIT,MM4" <?php if ("$record[venue]" == 'FCSIT,MM4') echo ' selected="selected"'; ?>>FCSIT,MM4</option>
                  <option value="FCSIT,DK2" <?php if ("$record[venue]" == 'FCSIT,DK2') echo ' selected="selected"'; ?>>FCSIT,DK2</option>
                  <option value="FCSIT,DK1" <?php if ("$record[venue]" == 'FCSIT,DK1') echo ' selected="selected"'; ?>>FCSIT,DK1</option>
                </select>
              </div>

              <div class="form-group">
                <label for="description">Descriptions</label>
                <textarea class="form-control" name="description" rows="5" style="height:100%;"><?php echo "$record[description]"; ?></textarea>
              </div>

              <input type="hidden" name="edit_id" value="<?php echo "$record[ID]"; ?>">

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary" name="edit" <?php
                                                                          // get user_id of meeting owner
                                                                          $pdo = new PDO($connString, $cleardb_username, $cleardb_password);
                                                                          $query = "SELECT user_id FROM meeting WHERE ID='$record[ID]'";
                                                                          $result = $pdo->query($query);
                                                                          $owner_id = "";
                                                                          while ($row = $result->fetch()) {
                                                                            $owner_id = $row['user_id'];
                                                                          }
                                                                          $pdo = null;
                                                                          if ($_SESSION['id'] != $owner_id) echo "data-toggle='popover' data-content='And here's some amazing content. It's very engaging. Right?' disabled ";
                                                                          ?>>
                  Save changes
                </button>
              </div>
            </form>
            <!-- Form ends here -->
          </div>
        </div>
      </div>
    </div>
    <!-- Edit modal ends-->

  <?php }
?>
  <?php foreach ($meeting_notes as $meeting_note) { ?>
    <!-- Delete note modal starts -->
    <div class="modal fade" id="delete_note<?php echo "$meeting_note[meetingnotesID]"; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                Delete Notes
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete the note?<br />
              This cannot be undone.
            </div>
            <input type="hidden" name="delete_note_id" value="<?php echo "$meeting_note[meetingnotesID]"; ?>">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary" name="delete_note" <?php
                                                                                // get user_id of meeting_note owner
                                                                                $pdo = new PDO($connString, $cleardb_username, $cleardb_password);
                                                                                $query = "SELECT user_id FROM meeting_notes WHERE ID='$meeting_note[meetingnotesID]'";
                                                                                $result = $pdo->query($query);
                                                                                $owner_id = "";
                                                                                while ($row = $result->fetch()) {
                                                                                  $owner_id = $row['user_id'];
                                                                                }
                                                                                $pdo = null;
                                                                                if ($_SESSION['id'] != $owner_id) echo "disabled";
                                                                                ?>>
                Delete
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete note modal ends -->
  <?php }
?>

  <!-- Add notes modal starts -->
  <div id="addnotesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <?php echo $fullname; ?>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form starts here -->
          <form novalidate method="POST">
            <div class="form-group">
              <label for="description">Choose your meeting</label>
              <select name="meetinglist" class="custom-select">
                <?php
                try {
                  $pdo = new PDO($connString, $cleardb_username, $cleardb_password);
                  $sql = "SELECT ID, title FROM meeting WHERE user_id = '$user_id' OR ID in (SELECT meeting_id FROM guest WHERE user_id = '$user_id');";
                  $cmd = $pdo->prepare($sql);
                  $cmd->execute();
                  $result = $cmd->fetchAll(PDO::FETCH_ASSOC);
                  $isFirst = true;
                  foreach ($result as $row) {
                    if ($isFirst) {
                      echo  '<option value="' .  $row['ID'] . " " . $row['title'] . '"selected>' . $row['title'] . '</option>';
                    } else {
                      echo '<option value="' . $row['ID'] . " " . $row['title'] . '">' . $row['title'] . '</option>';
                    }
                    $isFirst = false;
                  }
                  $pdo = null;
                } catch (PDOException $e) {
                  echo " Error: " .  $e->getMessage();
                  exit;
                }
                ?></select>
            </div>

            <div class="form-group">
              <label for="description">Descriptions</label>
              <textarea name="comment_descriptions" class="form-control" placeholder="Enter your comment here" rows="3" style="height:100%;"></textarea>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary" name="add_comment">
                Add comment
              </button>
            </div>
          </form>
          <!-- Form ends here -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add notes modal ends-->


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
        <li class="active">
          <a href="#">Manage Meeting Records</a>
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
    <div id="content">
      <button type="button" id="sidebarCollapse" class="navbar-btn">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <h1 class="text-center mt-3 mb-3" style="font-family: 'Mukta', sans-serif;color: #7BABED;">
        Manage Meeting Records
      </h1>
      <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
          <div id="meetingrecord" class="row justify-content-center">

            <?php foreach ($records as $record) { ?>
              <div id="<?php echo "$record[ID]"; ?>" class="col-sm-4 pt-4">
                <div class="card  mx-auto">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo "$record[title]"; ?></h4>
                    <button type="button" class="close" aria-label="Close" data-target="#delete<?php echo "$record[ID]"; ?>" data-toggle="modal" style="color: #7BABED">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <p class="card-text">
                      <strong>Date: </strong>
                      <?php echo "$record[date]"; ?>
                      <br />
                      <strong>Start time: </strong>
                      <?php echo "$record[start_time]"; ?>
                      <br />
                      <strong>End time: </strong>
                      <?php echo "$record[end_time]"; ?>
                      <br />
                      <strong>Venue: </strong>
                      <?php echo "$record[venue]"; ?>
                      <br />
                      <strong>Description: </strong>
                      <?php echo "$record[description]"; ?>
                    </p>
                    <p class="card-text">
                      <a href="#edit<?php echo "$record[ID]"; ?>" data-toggle="modal" style="text-decoration: none; color: #7BABED">
                        Edit
                      </a>
                    </p>
                  </div>
                </div>
              </div>

            <?php } ?>
          </div>

          <hr>

          <div style="text-align: center;" class="mb-3">
            <button class="btn btn-primary" data-target="#addnotesModal" data-toggle="modal">
              Add Meeting Notes
            </button>
          </div>

          <div class="row justify-content-center">
            <?php foreach ($meeting_notes as $meeting_note) { ?>
              <div class="card border-dark m-1" style="width: 18rem;" id="<?php echo "$meeting_note[meetingnotesID]"; ?>">
                <div class="card-body">
                  <button type="button" class="close" aria-label="Close" data-target="#delete_note<?php echo "$meeting_note[meetingnotesID]"; ?>" data-toggle="modal" style="color: #7BABED">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="card-title"><?php echo $meeting_note['title']; ?></h5>
                  <p class="card-text"><?php echo $meeting_note['note_description']; ?></p>
                </div>
                <div class="card-footer text-muted">
                  <p style="color: #7BABED;">
                    <?php echo "by " . $meeting_note['full_name']; ?>
                  </p>
                </div>
              </div>
            <?php } ?>
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
    });
  </script>
  <?php
  try {
    $pdo = new PDO($connString, $cleardb_username, $cleardb_password);

    if (isset($_POST['delete'])) {
      if (
        isset($_POST["delete_id"])
      ) {
        $delete_id = $_POST['delete_id'];
        $query = "DELETE FROM meeting WHERE ID ='$delete_id' ";
        $result = $pdo->query($query);

        $query = "DELETE FROM meeting_notes WHERE  meeting_id = $delete_id";
        $result = $pdo->query($query);
        echo ("<meta http-equiv='refresh' content='1'>");
      }
    }


    if (isset($_POST['edit'])) {
      if (
        isset($_POST["datepicker"]) && isset($_POST["starttime"]) &&
        isset($_POST["endtime"]) &&
        isset($_POST["venue"]) && isset($_POST["description"]) && isset($_POST["edit_id"])
      ) {
        $edit_id = $_POST['edit_id'];
        $datepicker = $_POST['datepicker'];
        $start_time = $datepicker . " " . $_POST['starttime'];
        $end_time = $datepicker . " " . $_POST['endtime'];
        $venue = $_POST['venue'];
        $description = $_POST['description'];

        $query = "UPDATE meeting SET start_time = '$start_time', end_time = '$end_time', venue = '$venue', description = '$description' WHERE ID=$edit_id";
        $result = $pdo->query($query);

        echo ("<meta http-equiv='refresh' content='1'>");
      }
    }

    if (isset($_POST['delete_note'])) {
      if (
        isset($_POST["delete_note_id"])
      ) {
        $delete_note_id = $_POST['delete_note_id'];
        $query = "DELETE FROM meeting_notes WHERE ID ='$delete_note_id' ";
        $result = $pdo->query($query);
        echo ("<meta http-equiv='refresh' content='1'>");
      }
    }

    if (isset($_POST['add_comment'])) {
      if (
        isset($_POST["meetinglist"]) && $_POST["meetinglist"] != " " && !empty($_POST["comment_descriptions"])
      ) {
        $user_id = $_SESSION['id'];
        $meetinglist = $_POST['meetinglist'];
        $meetingid = explode(" ", $meetinglist, 2);
        $comment_descriptions = $_POST['comment_descriptions'];

        $query = "INSERT INTO meeting_notes (user_id, meeting_id, title, description) VALUES ($user_id, $meetingid[0], '$meetingid[1]', '$comment_descriptions')";
        $result = $pdo->query($query);
        echo ("<meta http-equiv='refresh' content='1'>");
      }
    }

    $pdo = null;
  }
  // Check connection
  catch (PDOException $e) {
    echo " Error: " .  $e->getMessage();
    exit;
  }
  ?>
</body>

</html>