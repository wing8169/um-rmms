const tab = document.querySelectorAll(".tab");

// Add task-----------------
let addtask = document.getElementsByClassName("addtask")[0];
let todolist = document.getElementsByClassName("todolist");
let deadline_day = document.querySelector(".editgroup-off .deadline_day");
let deadline_time = document.querySelector(".editgroup-off .deadline_time");
let comment = document.querySelector(".editgroup-off .comment");
const save = document.querySelector(".editgroup-off .save");

let taskcontent = [];

save.addEventListener("click", post);
function post() {
  //grab input
  taskcontent.title = addtask.value;
  taskcontent.day = deadline_day.value;
  taskcontent.time = deadline_time.value;
  taskcontent.comment = comment.value;

  edit_deadline_day.value = deadline_day.value;
  edit_deadline_time.value = deadline_time.value;
  edit_comment.value = comment.value;
  let newitem = `
        <div class="listitem ">
            <div class="main">
                <input type="checkbox" class="checkbox">
                <p>${taskcontent.title}</p>
                <i class="far fa-star fa-lg star"></i>
                <i class="far fa-edit fa-lg pen"></i>
				 
            </div>
            <div class="detail">
                <span class="icon"><i class="far fa-calendar-alt "></i>${
                  deadline_day.value
                }   ${taskcontent.time}</span>
                <span class="icon"><i class="far fa-file "></i></span>
                <span class="icon"><i class="far fa-comment-alt "></i></span>
            </div>
            <div class="itemeditgroup">
                <div class="item editdeadline">
                    <p><i class="far fa-calendar-alt "></i>Deadline</p>
                    <input class="deadline_day" type="date" value="${
                      edit_deadline_day.value
                    }">
                    <input class="deadline_time" type="time" value="${
                      edit_deadline_time.value
                    }">
                </div>
                
                <div class="item editcomment">
                    <p><i class="far fa-comment-alt "></i>comment</p>
                    <input class="comment" type="text" value="${
                      edit_comment.value
                    }">
                </div>
                <div class="setting">
                    <P class="cancel"><i class="fas fa-times"></i>Cancel</P>
                    <P class="save"><i class="far fa-save"></i>Save</P>
                </div>
            </div>            
        </div>
        `;
  todolist[0].innerHTML = todolist[0].innerHTML + newitem;
  editgroup.classList.remove("editgroup-on");
  editgroup.classList.add("editgroup-off");
  //Clear data
  addtask.value = "";
  deadline_day.value = "";
  deadline_time.value = "";
  comment.value = "";

  //Update
  updata();
  updatapen();
}

//Priority
let listitem = document.getElementsByClassName("listitem");
let star = document.getElementsByClassName("star");

function updata() {
  for (let i = 0; i < star.length; i++) {
    star[i].addEventListener("click", important);
    function important() {
      if (star[i].classList.contains("far")) {
        star[i].classList.toggle("fas");
      }
      if (star[i].classList.contains("fas")) {
        listitem[i].classList.add("important");
      } else {
        listitem[i].classList.remove("important");
      }
    }
  }
}
updata();

//Expand column
const editgroup = document.querySelector(".editgroup-off");
const cancel = document.querySelector(".cancel");

//New item
addtask.addEventListener("focus", open);
function open() {
  editgroup.classList.remove("editgroup-off");
  editgroup.classList.add("editgroup-on");
  // Click X to close expand
  cancel.addEventListener("click", () => {
    editgroup.classList.remove("editgroup-on");
    editgroup.classList.add("editgroup-off");
  });
}

//Modify
let itemeditgroup = document.getElementsByClassName("itemeditgroup");

let edit_deadline_day = document.querySelector(".itemeditgroup .deadline_day");
let edit_deadline_time = document.querySelector(
  ".itemeditgroup .deadline_time"
);
let edit_comment = document.querySelector(".itemeditgroup .comment");
let pen = document.getElementsByClassName("pen");
let state = [];

function updatapen() {
  for (let k = 0; k < pen.length; k++) {
    pen[k].addEventListener("click", () => {
      //edit mode
      pen[k].classList.toggle("fas");
      listitem[k].classList.toggle("editing");

      if (pen[k].classList.contains("fas")) {
        itemeditgroup[k]
          .querySelector(".cancel")
          .addEventListener("click", () => {
            console.log("123");
            listitem[k].classList.remove("editing");
            pen[k].classList.remove("fas");
          });
      }
    });
  }
}
updatapen();
