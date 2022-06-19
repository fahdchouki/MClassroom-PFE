<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks | MClassroom</title>
<!-- CSS only -->
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/bootstrap-4.6.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <style>
      #taskPreview div{
        font-size: .8rem !important;
      }
    </style>
</head>
<body>
    <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
    <div class="table-responsive p-4">
        <?php if(auth()->isTeacher()): ?>
        <table class="table table-bordered m-3 bg-light" id="tasksTable">
            <thead>
            <tr>
                <th>Title <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Type <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Due To <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($tasks as $task): ?>
                    <tr>
                        <td><?= $task['title'] ?></td>
                        <td>
                            <?php
                                if($task['status'] == 1){
                                    echo "Draft";
                                }else{
                                    echo "Public";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($task['task_type'] == 1){
                                    echo "Quiz";
                                }else{
                                    echo "Exercice";
                                }
                            ?>
                        </td>
                        <td><?= date("D d, M Y",strtotime($task['deadline'])) ?> <?= $task['deadline'] < date("Y-m-d",time()) ? '<span class="badge bg-danger">expired</span>' : '<span class="badge bg-success">valid</span>' ?></td>
                        <td><?= date("D d, M Y",strtotime($task['created_at'])) ?></td>
                        <td style="text-align: center;">
                            <button class="btn btn-info btnPartTask" data-taskid="<?= $task['idTask'] ?>">Participants</button>
                            <a class="btn btn-warning" href="<?= BURL . 'task/results/' . $task['idTask'] ?>">Show Submits</a>
                            <button class="btn btn-danger btnDelTask" data-taskid="<?= $task['idTask'] ?>" data-tasktype="<?= $task['task_type'] ?>" data-taskidtype="<?= $task['id_type'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php else: ?>
          <table class="table table-bordered m-3 bg-light" id="tasksTable">
            <thead>
            <tr>
                <th>Title <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Group <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Type <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Due To <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($tasks as $task): ?>
                    <tr>
                        <td><?= $task['title'] ?></td>
                        <td>
                            <?php
                                if(isset($task['group_label'])){
                                    echo $task['group_label'];
                                }else{
                                    echo "Direct";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($task['submit_date'] == null){
                                    echo "<span class='badge bg-danger'>Not Submitted</span>";
                                }else{
                                    echo "<span class='badge bg-warning'>Submitted</span>";
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($task['task_type'] == 1){
                                    echo "Quiz";
                                }else{
                                    echo "Exercice";
                                }
                            ?>
                        </td>
                        <td><?= date("D d, M Y",strtotime($task['deadline'])) ?> <?= $task['deadline'] < date("Y-m-d",time()) ? '<span class="badge bg-danger">expired</span>' : '<span class="badge bg-success">valid</span>' ?></td>
                        <td><?= date("D d, M Y",strtotime($task['created_at'])) ?></td>
                        <td style="text-align: center;">
                            <?php if($task['deadline'] < date("Y-m-d",time())) : ?>
                              <button class="btn btn-dark" >Can't Submit</button>
                            <?php else: ?>
                                <button class="btn btn-success btnSubmitTask" data-taskid="<?= $task['idTask'] ?>" data-tasktype="<?= $task['task_type'] ?>" data-taskidtype="<?= $task['id_type'] ?>">Submit</button>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif ?>
        </div>
    </div>
    <!-- show modal -->
    <button type="button" class="btn btn-primary d-none btnPopup" data-bs-toggle="modal" data-bs-target="#showTaskModal"></button>

    <div class="modal fade" id="showTaskModal" tabindex="-1" aria-labelledby="showTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showTaskModalLabel">Task Participants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="taskPreview" style="max-height: 500px;overflow-y:scroll"></div>
            </div>
            </div>
        </div>
    </div>

    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
        <script>

            $(document).ready(function() {

                $('#tasksTable').DataTable();


                [...document.querySelectorAll(".btnDelTask")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idTask = el.getAttribute("data-taskid");
                        let idTaskType = el.getAttribute("data-taskidtype");
                        let taskType = el.getAttribute("data-tasktype");
                        if(confirm("Are you sure you want to delete this task ?")){
                            $.ajax({
                                url:'/task/delete',
                                type:'POST',
                                data:{idTask:idTask,idTaskType:idTaskType,taskType:taskType},
                                success:(res)=>{
                                    if(res != 'ok'){
                                        alert("Couldn't delete this task");
                                    }else{
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                });

                
                [...document.querySelectorAll(".btnSubmitTask")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idTask = el.getAttribute("data-taskid");
                        let idTaskType = el.getAttribute("data-taskidtype");
                        let taskType = el.getAttribute("data-tasktype");
                            $.ajax({
                                url:'/task/can_submit',
                                type:'POST',
                                data:{idTask:idTask,idTaskType:idTaskType,taskType:taskType},
                                success:(res)=>{
                                    if(res != 'ok'){
                                        alert("Couldn't submit this task");
                                    }else{
                                        window.location.href = '/task/submit';
                                    }
                                }
                            });
                    });
                });

                [...document.querySelectorAll(".btnPartTask")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idTask = el.getAttribute("data-taskid");

                        $.ajax({
                                url:'/task/participants',
                                type:'POST',
                                data:{idTask:idTask},
                                success:(res)=>{
                                  let part = JSON.parse(res);
                                  if('label' in part[0]){
                                    let p = "";
                                    part.forEach(el=>{
                                      p += `<div class="bg-light p-2 m-2 d-inline-block">
                                            <img src="<?= BURL . 'uploads/groups/' ?>${el.group_icon}" alt="" width="30px" height="30px" style="border-radius:50%"><span class="ps-2">${el.label}</span>
                                          </div>`;
                                    })
                                    $("#taskPreview").html(p);
                                  }else{
                                    let p = "";
                                    part.forEach(el=>{
                                      p += `<div class="bg-light p-2 m-2 d-inline-block">
                                            <img src="<?= BURL . 'uploads/profiles/' ?>${el.photo}" alt="" width="30px" height="30px" style="border-radius:50%"><span class="ps-2">${el.name} (${el.username})</span>
                                          </div>`;
                                    })
                                    $("#taskPreview").html(p);
                                  }
                                  $(".btnPopup").trigger('click');
                                }
                            });
                    });
                });
            });
        </script>
</body>
</html>