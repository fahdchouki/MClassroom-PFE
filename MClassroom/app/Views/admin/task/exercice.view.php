<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom | Exercice</title>
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
                <div class="exercice-area py-2">
                    <textarea id="exerciceEditor"></textarea>

                    <button class="btn btn-danger" id="btnCancelExercice">Discard Exercice</button>
                    <button class="btn btn-info" id="btnSaveExercice">Save Exercice</button>
                </div>
            </div>
        </div>
    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#exerciceEditor').summernote({
                height: 120,
                minHeight: 120,
            });

            $("#btnSaveExercice").click(()=>{
                $.ajax({
                    url:'/exercice/store',
                    type:'POST',
                    data:{exerciceContent:$('#exerciceEditor').summernote('code')},
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

            $("#btnCancelExercice").click(()=>{
                $.ajax({
                    url:'/exercice/discard',
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