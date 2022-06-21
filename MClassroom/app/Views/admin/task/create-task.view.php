<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom | Create Task</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <style>
        .users-preview{
            display: none;
        }
        label{
            user-select: none;
        }
    </style>
  </head>
  <body>
  <?php require_once INCS . "header.view.php" ?>
  <div class="content-wrapper">
    <div class="task-form bg-light p-3">
        <div class="my-3 p-3" style="background:#efefef;">
            <label class="my-2" for="taskTitle">Title :</label>
            <input type="text" id="taskTitle" class="form-control">
        </div>
        <div class="my-3 p-3" style="background:#efefef;">
            <label class="my-2" for="taskDueTo">Due To :</label>
            <input type="date" value="<?= date('Y-m-d'); ?>" min="<?= date('Y-m-d'); ?>" id="taskDueTo" class="form-control">
        </div>
        <div class="my-3 p-3" style="background:#efefef;">
            <label class="my-2">Status :</label><br>
            <input type="radio" name="TaskStatus" id="SDraft" checked value="1" class="ml-2 mr-1"><label class="my-2 ms-2 me-4" for="SDraft">Draft</label>
            <input type="radio" name="TaskStatus" id="SPublic" value="2" class="ml-2 mr-1"><label class="my-2 ms-2 me-4" for="SPublic">Public</label>
        </div>
        <div class="my-3 p-3" style="background:#efefef;">
            <label class="my-2">Participants :</label><br>
            <input type="radio" name="TaskFor" id="ForGroup" checked value="1" class=""><label class="my-3 ms-2 me-4" for="ForGroup">Groups</label>
            <input type="radio" name="TaskFor" id="ForUsers" value="2" class=""><label class="my-3 ms-2 me-4" for="ForUsers">Students</label>

            <div class="groups-preview bg-light p-3" id="groups-preview">
                <?php foreach($groups as $grp): ?>
                    <input type="checkbox" data-groupid="<?= $grp['idGroup'] ?>" id="g<?= $grp['idGroup'] ?>"><label class="m-1 groupChosen" for="g<?= $grp['idGroup'] ?>"><?= $grp['label'] ?></label><br>
                <?php endforeach ?>
            </div>


            <div class="users-preview p-3 bg-light" id="users-preview">
                <select id="grpsForUsers" class="w-100 p-2 my-2">
                    <option hidden>Select group</option>
                    <?php foreach($groups as $grp): ?>
                        <option value="<?= $grp['idGroup'] ?>"><?= $grp['label'] ?></option>
                    <?php endforeach ?>
                </select>
                <div class="selectedUsers bg-light p-3" id="selectedUsers-preview"></div>
            </div>
        </div>
        <div class="my-3 p-3" style="background:#efefef;">
            <label class="my-2">Type :</label><br>
            <input type="radio" name="TaskType" id="TaskQu" checked value="1" class="ml-2 mr-1"><label class="my-2 ms-2 me-4" for="TaskQu">Quiz</label>
            <input type="radio" name="TaskType" id="TaskEx" value="2" class="ml-2 mr-3"><label class="my-2 ms-2 me-4" for="TaskEx">Exercice</label>
        </div>
        <div>
            <button class="btn btn-info" id="btnCreateTask">Create</button>
        </div>
    </div>
  </div>
  <?php require_once INCS . "footer.view.php" ?>
  <script>


    let usersForTask = [];
    let groupsForTask = [];

    $("#ForUsers").click(()=>{
        $("#groups-preview").hide();
        $("#users-preview").show();
    });
    $("#ForGroup").click(()=>{
        $("#groups-preview").show();
        $("#users-preview").hide();
    });

    $("#grpsForUsers").change(()=>{
        let groupID = $("#grpsForUsers").val();
        $.ajax({
            url:'/task/get_users_by_group',
            type:'POST',
            data:{idGroup:groupID},
            success:(res)=>{
                usersForTask = [];
                let users = JSON.parse(res);
                let users_html = ``;
                users.forEach(el => {
                    users_html += `<input type="checkbox" class="userCheck" data-userid="${el.idUser}" id="u${el.idUser}"><label class="m-1" for="u${el.idUser}">${el.name}(${el.username})</label><br>`;
                })
                $("#selectedUsers-preview").html(users_html);
            }
        })
    });

    document.getElementById("selectedUsers-preview").addEventListener('click',(e)=>{
            if(e.target.checked && e.target.classList.contains("userCheck")){
                usersForTask.push(e.target.getAttribute("data-userid"));
            }else if(!e.target.checked && e.target.classList.contains("userCheck")){
                let userid = e.target.getAttribute("data-userid");
                usersForTask = usersForTask.filter(e => e !== userid);
            }
    });

    document.querySelectorAll("#groups-preview input[type='checkbox']").forEach(elt => {
        elt.addEventListener('click',()=>{
            if(elt.checked){
                groupsForTask.push(elt.getAttribute("data-groupid"));
            }else{
                let groupid = elt.getAttribute("data-groupid");
                groupsForTask = groupsForTask.filter(e => e !== groupid);
            }
        });
    })

    $("#btnCreateTask").click(()=>{
        let taskTitle = $("#taskTitle").val();
        let taskDueDate = $("#taskDueTo").val();
        let taskStatus = 1; /////////////// draft
        if($("#SPublic").is(":checked")){
            taskStatus = 2; //// public
        }
        let taskFor = 1; //////////////////groups
        if($("#ForUsers").is(":checked")){
            taskFor = 2; /// users
        }
        let taskType = 1; /////////// quiz
        if($("#TaskEx").is(":checked")){
            taskType = 2; ///// exercice
        }
        let participants = JSON.stringify(groupsForTask);
        if(taskFor == 2){
            participants = JSON.stringify(usersForTask);
        }
        if(taskType == 1){
            $.ajax({
                url:'/quiz/create',
                type:'POST',
                data:{taskTitle:taskTitle,taskDueDate:taskDueDate,taskStatus:taskStatus,taskFor:taskFor,participants:participants},
                success:(res)=>{
                    if(res == 'ok'){
                        document.querySelectorAll("#groups-preview input[type='checkbox']").forEach(elt => {
                            elt.checked = false;
                        });
                        window.location.href = "/quiz";
                    }else{
                        alert("Something went wrong");
                    }
                }
            });
        }else{
            $.ajax({
                url:'/exercice/create',
                type:'POST',
                data:{taskTitle:taskTitle,taskDueDate:taskDueDate,taskStatus:taskStatus,taskFor:taskFor,participants:participants},
                success:(res)=>{
                    if(res == 'ok'){
                        document.querySelectorAll("#groups-preview input[type='checkbox']").forEach(elt => {
                            elt.checked = false;
                        });
                        window.location.href = "/exercice";
                    }else{
                        alert("Something went wrong");
                    }
                }
            });
        }
    });
  </script>
  </body>
</html>