<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom | Quiz</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/bootstrap-4.6.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <style>
        label{
            user-select: none;
        }
    </style>
  </head>
  <body>
    <?php require_once INCS . "header.view.php" ?>
        <div class="content-wrapper">
            <div class="editing-area p-2 bg-light">
                <div class="quiz-area py-2">
                    <textarea id="quizEditor"></textarea>
                    <div class="options mt-3">
                        <h6 class="text-secondary my-3"><span class="text-danger">*</span> Leave option empty if you don't need it</h6>
                        <input type="text" id="option1" placeholder="Option 1" class="option my-2 p-2 form-control">
                        <input type="checkbox" id="istrueOption1"><label for="istrueOption1" class="ps-2">Is Correct</label>
                        <input type="text" id="option2" placeholder="Option 2" class="option my-2 p-2 form-control">
                        <input type="checkbox" id="istrueOption2"><label for="istrueOption2" class="ps-2">Is Correct</label>
                        <input type="text" id="option3" placeholder="Option 3" class="option my-2 p-2 form-control">
                        <input type="checkbox" id="istrueOption3"><label for="istrueOption3" class="ps-2">Is Correct</label>
                        <input type="text" id="option4" placeholder="Option 4" class="option my-2 p-2 form-control">
                        <input type="checkbox" id="istrueOption4"><label for="istrueOption4" class="ps-2">Is Correct</label>
                    </div>
                </div>
                <hr>
                <button class="btn btn-warning" id="btnAddQuestion">Add Question</button>
                <div class="text-right">
                    <button class="btn btn-danger" id="btnCancelQuiz">Discard Quiz</button>
                    <button class="btn btn-info" id="btnSaveQuiz">Save Quiz</button>
                </div>
            </div>
            <div class="preview-area my-3" id="preview-area"></div>
        </div>
    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {

            let questionsObject = [];


            $('#quizEditor').summernote({
                height: 120,
                minHeight: 120,
            });
            $("#btnAddQuestion").click(()=>{

                let quesCont = $('#quizEditor').summernote('code');

                let option1 = $("#option1").val();
                let option2 = $("#option2").val();
                let option3 = $("#option3").val();
                let option4 = $("#option4").val();

                let isTrueOption1 = $("#istrueOption1").is(":checked") ? true : false;
                let isTrueOption2 = $("#istrueOption2").is(":checked") ? true : false;
                let isTrueOption3 = $("#istrueOption3").is(":checked") ? true : false;
                let isTrueOption4 = $("#istrueOption4").is(":checked") ? true : false;

                if(option1 != "" && option2 != ""){
                    if(option3 != ""){
                        if(option4 != ""){
                            let quesObj = {
                            content:quesCont,
                            options:{
                                option1:[option1,isTrueOption1],
                                option2:[option2,isTrueOption2],
                                option3:[option3,isTrueOption3],
                                option4:[option4,isTrueOption4],
                                }
                            };
                            questionsObject.push(quesObj);
                            let qHtml = `<div class="question-prev bg-light my-2 p-2">
                                            <div class="question-content p-2 my-2">${quesCont}</div>
                                            <div class="options-prev p-2 my-2"><tr>
                                                <p class="pb-1 text-${isTrueOption1 ? 'success' : 'danger'}" >1) ${option1}</p>
                                                <p class="pb-1 text-${isTrueOption2 ? 'success' : 'danger'}" >2) ${option2}</p>
                                                <p class="pb-1 text-${isTrueOption3 ? 'success' : 'danger'}" >3) ${option3}</p>
                                                <p class="pb-1 text-${isTrueOption4 ? 'success' : 'danger'}" >4) ${option4}</p>
                                            </div>
                                        </div>`;
                            $("#preview-area").append(qHtml);
                        }else{
                            let quesObj = {
                            content:quesCont,
                            options:{
                                option1:[option1,isTrueOption1],
                                option2:[option2,isTrueOption2],
                                option3:[option3,isTrueOption3],
                                }
                            };
                            questionsObject.push(quesObj);
                            let qHtml = `<div class="question-prev bg-light my-2 p-2">
                                            <div class="question-content p-2 my-2">${quesCont}</div>
                                            <div class="options-prev p-2 my-2"><tr>
                                                <p class="pb-1 text-${isTrueOption1 ? 'success' : 'danger'}" >1) ${option1}</p>
                                                <p class="pb-1 text-${isTrueOption2 ? 'success' : 'danger'}" >2) ${option2}</p>
                                                <p class="pb-1 text-${isTrueOption3 ? 'success' : 'danger'}" >3) ${option3}</p>
                                            </div>
                                        </div>`;
                            $("#preview-area").append(qHtml);
                        }
                    }else{

                        let quesObj = {
                            content:quesCont,
                            options:{
                                option1:[option1,isTrueOption1],
                                option2:[option2,isTrueOption2],
                            }
                        };
                        questionsObject.push(quesObj);
                        let qHtml = `<div class="question-prev bg-light my-2 p-2">
                                        <div class="question-content p-2 my-2">${quesCont}</div>
                                        <div class="options-prev p-2 my-2"><tr>
                                            <p class="pb-1 text-${isTrueOption1 ? 'success' : 'danger'}" >1) ${option1}</p>
                                            <p class="pb-1 text-${isTrueOption2 ? 'success' : 'danger'}" >2) ${option2}</p>
                                        </div>
                                    </div>`;
                        $("#preview-area").append(qHtml);                      
                    }
                    $('#quizEditor').summernote('code','');
                    [...document.querySelectorAll(".options input")].forEach(el=>{
                        el.value = '';
                        el.checked = false;
                    });
                }else{
                    alert("Question must have at least 2 options");
                }
            });

            $("#btnSaveQuiz").click(()=>{
                $.ajax({
                    url:'/quiz/store',
                    type:'POST',
                    data:{quizContent:JSON.stringify(questionsObject)},
                    success:(res)=>{
                        if(res == 'ok'){
                            alert("Task created with success");
                            window.location.reload();
                        }else{
                            alert("Something went wrong");
                        }
                    }
                });
            });

            $("#btnCancelQuiz").click(()=>{
                $.ajax({
                    url:'/quiz/discard',
                    type:'POST',
                    data:{discard:true},
                    success:(res)=>{
                        if(res == 'ok'){
                            window.location.reload();
                        }else{
                            alert("Something went wrong");
                        }
                    }
                });
            });

        });
    </script>
  </body>
</html>