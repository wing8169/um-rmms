// meeting card that is clicked
var meetingToBeModified = "";

var meetingInfo = [];

function getDate(milli) {
  var tmp = new Date(parseInt(milli));
  return tmp.toLocaleDateString();
}

function getTime(milli) {
  var tmp = new Date(parseInt(milli));
  var tmpTime = tmp.toLocaleTimeString();
  return tmpTime.slice(0, 4) + " " + tmpTime.slice(8).toLowerCase();
}

// update the fields in the update section based on task name
function updateForms(id) {
  var selectedItems = meetingInfo.filter(d => d["id"] === id.toString());
  if (selectedItems.length != 0) {
    var selectedItem = selectedItems[0];

    // process and update date
    var dateelement = document.getElementById("datepicker");
    var unprocessedDate = new Date(
      parseInt(selectedItem["start"])
    ).toLocaleDateString();
    var year = unprocessedDate.slice(unprocessedDate.lastIndexOf("/") + 1);
    var month =
      (unprocessedDate.slice(0, unprocessedDate.indexOf("/")).length == 1
        ? "0"
        : "") + unprocessedDate.slice(0, unprocessedDate.indexOf("/"));
    var day =
      (unprocessedDate.slice(
        unprocessedDate.indexOf("/") + 1,
        unprocessedDate.lastIndexOf("/")
      ).length == 1
        ? "0"
        : "") +
      unprocessedDate.slice(
        unprocessedDate.indexOf("/") + 1,
        unprocessedDate.lastIndexOf("/")
      );
    var processedDate = year + "-" + month + "-" + day;
    dateelement.value = processedDate;

    // process start time and update start time
    var stimeelement = document.getElementById("starttime");
    var unprocessedSTime = new Date(
      parseInt(selectedItem["start"])
    ).toLocaleTimeString();
    var ampm = unprocessedSTime.slice(unprocessedSTime.indexOf(" ") + 1);
    var hour =
      unprocessedSTime.slice(0, unprocessedSTime.indexOf(":")).length === 1
        ? "0" + unprocessedSTime.slice(0, unprocessedSTime.indexOf(":"))
        : unprocessedSTime.slice(0, unprocessedSTime.indexOf(":"));
    hour = ampm === "AM" ? hour : (parseInt(hour) + 12).toString();
    var minute =
      unprocessedSTime.slice(
        unprocessedSTime.indexOf(":") + 1,
        unprocessedSTime.lastIndexOf(":")
      ).length === 1
        ? "0" +
          unprocessedSTime.slice(
            unprocessedSTime.indexOf(":") + 1,
            unprocessedSTime.lastIndexOf(":")
          )
        : unprocessedSTime.slice(
            unprocessedSTime.indexOf(":") + 1,
            unprocessedSTime.lastIndexOf(":")
          );
    var second =
      unprocessedSTime.slice(
        unprocessedSTime.lastIndexOf(":") + 1,
        unprocessedSTime.indexOf(" ")
      ).length === 1
        ? "0" +
          unprocessedSTime.slice(
            unprocessedSTime.lastIndexOf(":") + 1,
            unprocessedSTime.indexOf(" ")
          )
        : unprocessedSTime.slice(
            unprocessedSTime.lastIndexOf(":") + 1,
            unprocessedSTime.indexOf(" ")
          );
    var processedSTime = hour + ":" + minute + ":" + second;
    stimeelement.value = processedSTime;

    // process end time and update end time
    var etimeelement = document.getElementById("endtime");
    var unprocessedETime = new Date(
      parseInt(selectedItem["end"])
    ).toLocaleTimeString();
    ampm = unprocessedETime.slice(unprocessedETime.indexOf(" ") + 1);
    hour =
      unprocessedETime.slice(0, unprocessedETime.indexOf(":")).length === 1
        ? "0" + unprocessedETime.slice(0, unprocessedETime.indexOf(":"))
        : unprocessedETime.slice(0, unprocessedETime.indexOf(":"));
    hour = ampm === "AM" ? hour : (parseInt(hour) + 12).toString();
    minute =
      unprocessedETime.slice(
        unprocessedETime.indexOf(":") + 1,
        unprocessedETime.lastIndexOf(":")
      ).length === 1
        ? "0" +
          unprocessedETime.slice(
            unprocessedETime.indexOf(":") + 1,
            unprocessedETime.lastIndexOf(":")
          )
        : unprocessedETime.slice(
            unprocessedETime.indexOf(":") + 1,
            unprocessedETime.lastIndexOf(":")
          );
    second =
      unprocessedETime.slice(
        unprocessedETime.lastIndexOf(":") + 1,
        unprocessedETime.indexOf(" ")
      ).length === 1
        ? "0" +
          unprocessedETime.slice(
            unprocessedETime.lastIndexOf(":") + 1,
            unprocessedETime.indexOf(" ")
          )
        : unprocessedETime.slice(
            unprocessedETime.lastIndexOf(":") + 1,
            unprocessedETime.indexOf(" ")
          );
    var processedETime = hour + ":" + minute + ":" + second;
    etimeelement.value = processedETime;

    // update title, venue and description
    $("#title").val(selectedItem["title"]);
    $("#venue").val(selectedItem["venue"]);
    $("#description").val(selectedItem["description"]);
  }
}

$(document).ready(function() {
  // Add note
  $("#createNote").on("click", function() {
    addNote("tmp"); // new id = read the last id in database, increment by 1.
  });
  // Retrieving data
  meetingInfo = localStorage.getItem("meetingInfo");
  if (meetingInfo == null || meetingInfo == "[]") {
    $.getJSON("events.json", function(json) {
      meetingInfo = json["result"];
      // update local storage
      localStorage.setItem("meetingInfo", JSON.stringify(meetingInfo));
      // inititalize card
      initCards();
    });
  } else {
    // parse meetingInfo from String to JSON
    meetingInfo = JSON.parse(meetingInfo);
    // inititalize card
    initCards();
  }
});

function addNote(id) {
  var element = `<li class="myNote col mb-3" id="${id}">
  <div class="card border-light mx-auto ">
	<div class="card-header">
	  ChoonHeng Chor
	</div>
	<div class="card-body text-dark">
	  <h5 class="card text">
		<textarea rows="1" cols="20" placeholder="Title"></textarea>
	  </h5>
	  <p class="card text">
      <textarea
        rows="5"
        cols="40"
        placeholder="Description"
      ></textarea>
	  </p>
	  <div class="btn-group mt-3">
		<button type="button" class="btn btn-success">Save</button>
		<button type="button" class="btn btn-danger delete">
		  Delete
		</button>
	  </div>
	</div>
  </div>
</li>`;
  $("#myCard").append(element);
  deleteNote();
}

function deleteNote() {
  $(".delete").click(function() {
    $(this)
      .parent()
      .parent()
      .parent()
      .parent()
      .remove();
  });
}

function replyDelete() {
  var button_id = meetingToBeModified;
  // remove the data
  for (let i = 0; i < meetingInfo.length; i++) {
    if (meetingInfo[i]["id"] === button_id) {
      meetingInfo.splice(i, 1);
      break;
    }
  }
  // update json file (local storage)
  localStorage.setItem("meetingInfo", JSON.stringify(meetingInfo));
  // re-initialize cards
  initCards();
}

// set the meeting to be modified
function setMeetingToBeModified(id) {
  meetingToBeModified = id.toString();
  updateForms(id);
}

function initCards() {
  // remove the old cards
  $("#meetingrecord").empty();
  for (var i = 0; i < meetingInfo.length; i++) {
    $("#meetingrecord").append(`
    <div id="${meetingInfo[i]["id"]}" class="col-sm-4 pt-4">
      <div class="card border-light mx-auto">
        <div class="card-body">
          <h4 class="card-title">${meetingInfo[i].title} </h4>
          <button  
            type="button" class="close" onClick="setMeetingToBeModified(${
              meetingInfo[i]["id"]
            })" aria-label="Close" data-target="#deleteAlert" data-toggle="modal" style="color: #7BABED">
            <span aria-hidden="true">&times;</span>
          </button>
          <p class="card-text">
            <strong>Date: </strong>
            ${getDate(meetingInfo[i].start)}
            <br />
            <strong>Time: </strong>
            ${getTime(meetingInfo[i].start)} - ${getTime(meetingInfo[i].end)}
            <br />
            <strong>Venue: </strong>
            ${meetingInfo[i].venue}
            <br />
            <strong>Description: </strong>
            ${meetingInfo[i].description}
          </p>
          <p class="card-text">
            <a href="#" data-toggle="modal" data-target="#myModal" onClick="setMeetingToBeModified(${
              meetingInfo[i]["id"]
            })" style="text-decoration: none; color: #7BABED">
              Edit
            </a>  
          </p>
        </div>
      </div>
    </div>`);
  }
}
