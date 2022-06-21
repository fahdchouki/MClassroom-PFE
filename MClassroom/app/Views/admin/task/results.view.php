<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>MClassroom | Task Results</title>
        <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/bootstrap-4.6.min.css">
        <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
        <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
        <style>
            td{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php require_once INCS . "header.view.php" ?>
        <div class="content-wrapper">
            <div class="table-responsive p-4">
                <table class="table table-bordered m-3 bg-light" id="submitionsTable">
                    <thead>
                        <th>Student <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                        <th>Group <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                        <th>Submited At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <?php foreach($submitions as $s): ?>
                            <tr>
                                <td><?= $s['name'] . " ( " . $s['username'] . " ) " ?></td>
                                <td><?= $s['label'] ?></td>
                                <td><?= formatDate($s['submit_date'],'D d, M Y') ?></td>
                                <td>
                                    <button class="btn btn-info btnShowAnswer" data-user="<?= $s['name'] . " ( " . $s['username'] . " ) " ?>" data-tasktype="<?= $s['task_type'] ?>" data-taskidtype="<?= $s['id_type'] ?>" data-taskid="<?= $s['idTask'] ?>">Show Answer</button>
                                    <div class="d-none answerContent"><?= $s['content'] ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- show modal -->
        <button type="button" id="btnShowAnswerModal" class="btn btn-primary d-none btnPopup" data-bs-toggle="modal" data-bs-target="#showAnswerModal"></button>

        <div class="modal fade" id="showAnswerModal" tabindex="-1" aria-labelledby="showAnswerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="showAnswerModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="answerPreview">                 
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <?php require_once INCS . "footer.view.php" ?>
        <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
        <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
        <script>
             $(document).ready(function() {
                $('#submitionsTable').DataTable();

                [...document.querySelectorAll(".btnShowAnswer")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idTask = el.getAttribute("data-taskid");
                        let idTaskType = el.getAttribute("data-taskidtype");
                        let taskType = el.getAttribute("data-tasktype");
                        let answerContent = el.nextElementSibling.textContent;
                        $.ajax({
                            url:'/task/get_task_content',
                            type:'POST',
                            data:{idTask:idTask,idTaskType:idTaskType,taskType:taskType},
                            success:(res)=>{
                                if(taskType == 1){
                                    answerContent = JSON.parse(el.nextElementSibling.textContent);
                                    let quizContent = JSON.parse(res);
                                    if(quizContent){
                                        let ques = "";
                                        let mark = 0;
                                        let counter = 1;
                                        for (let i = 0; i < quizContent.length; i++) {
                                            ques += `<b>Question #${counter}</b><div class="question-content p-4 my-2 bg-light">${quizContent[i].content}</div>`;
                                            counter++;
                                            let isAnswered = false;
                                            for (let j = 0; j < answerContent.length; j++) {
                                                if(answerContent[j][0] == i){
                                                    isAnswered = true;
                                                    for (let o = 0; o < Object.keys(quizContent[i].options).length; o++) {
                                                        if(answerContent[j][2] == o){
                                                            if(quizContent[i].options['option' + (o+1)][1] == true){
                                                                mark++;
                                                                ques += `<p style="width:max-content;" class="my-2 p-3 text-success text-center bg-light">${quizContent[i].options['option' + (o+1)][0]}</p>`;
                                                            }else{
                                                                ques += `<p style="width:max-content;" class="my-2 p-3 text-danger text-center bg-light">${quizContent[i].options['option' + (o+1)][0]}</p>`;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            if(!isAnswered){
                                                ques += `<p style="width:max-content;" class="my-2 p-3 text-center bg-light">Not answered !!</p>`;
                                            }
                                            ques += `<hr/>`;
                                        }
                                        $("#showAnswerModalLabel").html(el.getAttribute("data-user") + `<span class="btn btn-success" > ${mark}/${quizContent.length} correct answers</span>`);
                                        $("#answerPreview").html(ques);
                                        $("#btnShowAnswerModal").trigger('click');
                                    }
                                }else{
                                    let exerciceContent = res;
                                    $("#showAnswerModalLabel").html(el.getAttribute("data-user"));
                                    ctn = `<div class="question-content p-2 my-2 bg-light">${exerciceContent}</div><hr />
                                            <div class="question-content p-3 my-2 bg-light" style="width:max-content">${answerContent}</div>`;
                                    $("#answerPreview").html(ctn);
                                    $("#btnShowAnswerModal").trigger('click');
                                }
                            }
                        });
                    });
                });
             });
        </script>
    </body>
</html>