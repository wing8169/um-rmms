var meetingInfo = [];
$(document).ready(function() {
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

$(document).ready(function() {
  $("#createNote").on("click", function() {
    addNote("tmp"); // new id = read the last id in database, increment by 1.
  });
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
	  <div class="btn-group">
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

function replyDelete(button_id) {
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

function initCards() {
  // remove the old cards
  $("#meetingrecord").empty();
  for (i = 0; i < meetingInfo.length; i++) {
    if (i == 0) {
      $("#meetingrecord").append(`
      <div id="card${i}" class="carousel-item active">
    <div class="row justify-content-center">
      <div class="card pl-0 pr-0 col-6 border-light">
      <button id="${
        meetingInfo[i]["id"]
      }" type="button" class="close" aria-label="Close" onClick="replyDelete(this.id)">
        <span aria-hidden="true">&times;</span>
      </button>
        <div class="inner">
          <img
            class="card-img-top img-fluid"
            src="${meetingInfo[i].image}"
            alt="Card image cap"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">${meetingInfo[i].title}</h4>
          <p class="card-text">
            <strong>Date</strong>
            ${meetingInfo[i].date}
            <br />
            <strong>Time </strong>
            ${meetingInfo[i].time}
            <br />
            <strong>Venue </strong>
            ${meetingInfo[i].venue}
            <br />
            <strong>Description </strong>
            ${meetingInfo[i].description}
          </p>
          <p class="card-text">
            <small class="text-muted">Last updated 3 mins ago</small>
          </p>
        </div>
      </div>
    </div>
    </div>`);
    } else {
      $("#meetingrecord").append(`
      <div id="card${i}" class="carousel-item">
    <div class="row justify-content-center">
      <div class="card pl-0 pr-0 col-6 border-light">
      <button id="${
        meetingInfo[i]["id"]
      }" type="button" class="close" aria-label="Close" onClick="replyDelete(this.id)">
  <span aria-hidden="true">&times;</span>
</button>
        <div class="inner">
          <img
            class="card-img-top img-fluid"
            src="${meetingInfo[i].image}"
            alt="Card image cap"
          />
        </div>
        <div class="card-body">
          <h4 class="card-title">${meetingInfo[i].title}</h4>
          <p class="card-text">
            <strong>Date</strong>
            ${meetingInfo[i].date}
            <br />
            <strong>Time </strong>
            ${meetingInfo[i].time}
            <br />
            <strong>Venue </strong>
            ${meetingInfo[i].venue}
            <br />
            <strong>Description </strong>
            ${meetingInfo[i].description}
          </p>
          <p class="card-text">
            <small class="text-muted">Last updated 3 mins ago</small>
          </p>
        </div>
      </div>
    </div>
    </div>`);
    }
  }
}
