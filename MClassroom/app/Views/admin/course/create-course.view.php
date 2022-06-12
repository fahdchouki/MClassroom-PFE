<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | MClassroom</title>
<!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.11/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
</head>
<body>
    <?php require_once INCS . "header.view.php" ?>
                <form method="post">
                    <input type="text" class="form-control" placeholder="course title"><br>
                    <label for="">status : </label><br>
                        <input type="checkbox" name="" id="">private <br>
                        <input type="checkbox" name="" id="">public <br>
                        <input type="checkbox" name="" id="">draft <br><br>
                    <label for="">Content :</label>
                    <textarea id="summernote" name="editordata"></textarea>
                    <br>
                    <label for="">Attach file :</label> <br>
                    <input type="file" name="" id=""> <br> <br>
                    <button>Create</button>
                    <br>
                    <br>
                    <br>
                    <br>
                  </form>
    <?php require_once INCS . "footer.view.php" ?>
         <!-- include libraries(jQuery, bootstrap) -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs4-summernote@0.8.10/dist/summernote-bs4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 300,   //set editable area's height
                });
            });
        </script>
</body>
</html>