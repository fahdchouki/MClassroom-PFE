<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom dashboard</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
  </head>
  <body>
  <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
        <?php if($isQuiz): ?>
        <div class="quiz-area py-2" id="quiz-area">
            <button class="btn btn-warning btnSendAnswers" id="btnSendAnswers">Submit</button>
            <?php $quesCounter = 0; foreach($quizContent as $quiz): $counter = 0; ?>
                <div class="question-prev bg-light my-2 p-2">
                    <div class="question-content p-2 my-2"><?= $quiz->content ?></div>
                    <div class="options-prev p-2 my-2">
                    <?php foreach($quiz->options as $option): ?>
                        <input type="checkbox" data-answer="<?= $counter ?>" data-question="<?= $quesCounter ?>" id="istrueOption<?= $quesCounter.$counter ?>"><label for="istrueOption<?= $quesCounter.$counter ?>" class="ps-2"><?= ($counter+1) . ") " . $option[0] ?></label><br>
                    <?php $counter++; endforeach; $quesCounter++; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="content-wrapper">
        <div class="quiz-area py-2" id="quiz-area">
            <div class="question-prev bg-light my-2 p-2">
                <div class="question-content p-2 my-2"><?= $exerciceContent ?></div>
                <textarea id="answer" class="form-control" placeholder="Type your answer here..."></textarea>
                <button class="btn btn-warning btnSendAnswers my-3" id="btnSendAnswer">Submit</button>
            </div>
        </div>
    </div>
    <?php endif; ?>

  <?php require_once INCS . "footer.view.php" ?>

  <?php if($isQuiz): ?>
    <script>
        $(document).ready(()=>{

            let quizAnswers = [];

            document.querySelectorAll("#quiz-area input[type='checkbox']").forEach(elt => {
                elt.addEventListener('click',()=>{
                    if(elt.checked){
                        let questionIndex = elt.getAttribute("data-question");
                        let answerIndex = elt.getAttribute("data-answer");
                        let ans = questionIndex + "|" + answerIndex;
                        quizAnswers.push(ans);
                    }else{
                        let questionIndex = elt.getAttribute("data-question");
                        let answerIndex = elt.getAttribute("data-answer");
                        let ans = questionIndex + "|" + answerIndex;
                        quizAnswers = quizAnswers.filter(e => e !== ans);
                    }
                });
            });

            $("#btnSendAnswers").click(()=>{
                $.ajax({
                    url:'/task/submit_task',
                    type:'POST',
                    data:{quizAnswers:JSON.stringify(quizAnswers)},
                    success:(res)=>{
                        if(res == 'ok'){
                            window.location.href = '/task';
                        }else{
                            alert("Something went wrong");
                        }
                    }
                });
            });

        });
    </script>
  <?php else: ?>
    <script>
        $(document).ready(()=>{
            $("#btnSendAnswer").click(()=>{
                let answer = $("#answer").val();
                $.ajax({
                    url:'/task/submit_task',
                    type:'POST',
                    data:{exerciceAnswer:answer},
                    success:(res)=>{
                        if(res == 'ok'){
                            window.location.href = '/task';
                        }else{
                            alert("Something went wrong");
                        }
                    }
                });
            });
        });
    </script>
  <?php endif; ?>

  </body>
</html>