// (function addNote() {
//   var notes,
//     count = 0;
//   var _private = {
//     attachNoteEvent: function(noteElement) {
//       var div = noteElement.children("div");
//       var closeImg = div.find("i");

//       div.focus(function() {
//         closeImg.removeClass("hide");
//       });

//       div.children().focus(function() {
//         closeImg.removeClass("hide");
//       });

//       div.hover(
//         function() {
//           closeImg.removeClass("hide");
//         },
//         function() {
//           closeImg.addClass("hide");
//           _private.saveNotes();
//         }
//       );

//       div.children().hover(
//         function() {
//           closeImg.removeClass("hide");
//         },
//         function() {
//           closeImg.addClass("hide");
//         }
//       );
//     },
//     addNewNote: function(className, title, content, time) {
//       if (!className) {
//         className = "c-" + Math.ceil(Math.random() * 3);
//         if (!time) {
//           var date = new Date();
//           var time =
//             date.getFullYear() +
//             "-" +
//             (date.getMonth() + 1) +
//             "-" +
//             date.getDate() +
//             " " +
//             (date.getHours() - 12) +
//             ":" +
//             date.getMinutes() +
//             ":" +
//             date.getSeconds();
//         }
//       }

//       notes.append(
//         "<li><div class='" +
//           className +
//           "'><i class='icon-check'>  Save</i><p class='time'>" +
//           time +
//           "</p>" +
//           "<textarea class='note-title' placeholder='Enter your name...' maxlength='50'/>" +
//           "<textarea class='note-content' placeholder='Start a note...'/>" +
//           "<i class='icon-cancel hide'> Delete</i>" +
//           "</div></li>"
//       );

//       var newNote = notes.find("li:last");
//       newNote.find(".icon-cancel").on("click", function() {
//         newNote.remove();
//         _private.saveNotes();
//       });
//       newNote.find(".icon-check").on("click", function() {
//         _private.saveNotes();
//         $("body")
//           .fadeIn(175)
//           .fadeOut(175)
//           .fadeIn(175);
//       });

//       _private.attachNoteEvent(newNote);

//       if (title) {
//         newNote.find("textarea.note-title").val(title);
//       }

//       if (content) {
//         newNote.find("textarea.note-content").val(content);
//       }
//       if (time) {
//         newNote.find(".time").text();
//       }

//       _private.saveNotes();
//     },
//     saveNotes: function() {
//       var notesArray = [];

//       notes.find("li > div").each(function(i, e) {
//         var c = $(e).attr("class");
//         var title = $(e).find("textarea.note-title");
//         var content = $(e).find("textarea.note-content");
//         var time = $(e)
//           .find(".time")
//           .text();

//         notesArray.push({
//           Index: i,
//           Title: title.val(),
//           Content: content.val(),
//           Class: c,
//           Time: time
//         });
//       });

//       var jsonStr = JSON.stringify(notesArray);

//       localStorage.setItem("notes", jsonStr);
//     },
//     loadNotes: function() {
//       var localNotes = localStorage.getItem("notes");
//       if (localNotes) {
//         var notesList = JSON.parse(localNotes);
//         count = notesList.length;
//         var i;
//         for (i = 0; i < count; i++) {
//           var storedNote = notesList[i];
//           _private.addNewNote(
//             storedNote.Class,
//             storedNote.Title,
//             storedNote.Content,
//             storedNote.Time
//           );
//         }
//         $("#controls strong").hide();
//         $("#welcome").html("Welcome back!");
//       }
//     }
//   };

//   $(document).ready(function() {
//     //Begins here
//     notes = $("#notes-list");
//     _private.loadNotes();

//     $("#btnNew").click(function() {
//       var t = 1;
//       _private.addNewNote();
//     });
//     if (count === 0) {
//       $("#welcome").html("Add new notes");
//       $("#controls strong").show();
//     }
//   });
//   return {};
// })();

// $(".carousel-sync").on("slide.bs.carousel", function(ev) {
//   var dir = ev.direction == "right" ? "prev" : "next";
//   $(".carousel-sync")
//     .not(".sliding")
//     .addClass("sliding")
//     .carousel(dir);
// });
// $(".carousel-sync").on("slid.bs.carousel", function(ev) {
//   $(".carousel-sync").removeClass("sliding");
// });

// $(document).ready(function(){
// $('.carousel-item').on('click',function(){
// 	alert("asdasdasdasdsd");
// });
// });

// var cardInfo=[
// 	{
// 		image:"test.jpeg",
// 		title:"Group discussion",
// 		date: "19/5/2019",
// 		time:"9.45am",
// 		venue:"FSKTM",
// 		details:"HS Ong and discuss about our project puurpose.",
// 		notes: addNote()
// 	},
// 	{
// 		image:"meeting1.jpg",
// 		title:"Group discussion",
// 		date: "19/5/2019",
// 		time:"9.45am",
// 		venue:"FSKTM",
// 		details:"HS Ong and discuss about our project puurpose.",
// 		notes: addNote()
// 	}
// ];
// var note1 = document.getElementById("#note");

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
  init();
}

function init() {
  $(".delete").click(function() {
    $(this)
      .parent()
      .parent()
      .parent()
      .parent()
      .remove();
  });
}

// $(document).ready(function() {
//   init();
// });

var meetingInfo = [
  {
    image: "../../img/test.jpeg",
    title: "Group discussion 1",
    date: "19/5/2019",
    time: "9.45am",
    venue: "FSKTM",
    details: "HS Ong and discuss about our project purpose."
  },
  {
    image: "../../img/meeting1.jpg",
    title: "Group discussion 2",
    date: "19/5/2019",
    time: "9.45am",
    venue: "FSKTM",
    details: "HS Ong and discuss about our project purpose."
  }
];

$(document).ready(function() {
  for (i = 0; i < meetingInfo.length; i++) {
    if (i == 0) {
      $("#meetingrecord").append(`<div class="carousel-item active">
    <div class="row justify-content-center">
      <div class="card pl-0 pr-0 col-6 border-light">
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
            <strong>Meeting details </strong>
            ${meetingInfo[i].details}
          </p>
          <p class="card-text">
            <small class="text-muted">Last updated 3 mins ago</small>
          </p>
        </div>
      </div>
    </div>
  </div>`);
    } else {
      $("#meetingrecord").append(`<div class="carousel-item ">
    <div class="row justify-content-center">
      <div class="card pl-0 pr-0 col-6 border-light">
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
            <strong>Meeting details </strong>
            ${meetingInfo[i].details}
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
});
