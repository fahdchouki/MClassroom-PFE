<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | MClassroom</title>
<!-- CSS only -->
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/bootstrap-4.6.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
</head>
<body>
    <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
                <div class="bg-light p-4">
                    <h4 class="my-3 text-primary">Title : </h4>
                    <input type="text" class="form-control p-4" id="cTitle" value="<?= $course['title'] ?>">
                    <h4 class="my-3 text-primary">status : </h4>
                    <input type="radio" class="ml-3" name="c-status" id="s1" <?= $course['status'] == 1 ? 'checked' : '' ?>><label class="ml-2" for="s1" > Draft</label>
                    <input type="radio" class="ml-3" name="c-status" id="s3" <?= $course['status'] == 3 ? 'checked' : '' ?>><label class="ml-2" for="s3" > Public</label>
                    <h4 class="my-3 text-primary">Content :</h4>
                    <textarea id="cSummernote" name="editordata"></textarea>
                    <h4 class="my-3 text-primary">Attach file :</h4>
                    <?php if(trim($attachedFilename) != ""): ?>
                    <a href="<?= BURL . 'uploads/courses/' . $attachedFilename ?>" class="d-block m-4"><?= explode("_",$attachedFilename,2)[1] ?></a>
                    <?php endif ?>
                    <input type="file" class="form-control p-5" name="" id="cFile">
                    <h4 class="my-3 text-primary">For Groups : </h4>
                    <select class="form-select" multiple id="c_for_groups">
                        <?php foreach($grps as $grp): ?>
                            <option value="<?= $grp['idGroup'] ?>" <?= in_array($grp,$course_grps) ? 'selected' : '' ?> > <?= $grp['label'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" id="courseID" value="<?= $course['idCourse'] ?>">
                    <input type="hidden" id="fileCourseName" value="<?= $courseFileName ?>">
                    <input type="hidden" id="fileName" value="<?= $attachedFilename ?>">
                    <button id="btnSaveCourse" class="btn btn-primary px-5 btn-rounded mt-5 ml-auto d-block">Save</button>
                </div>
    </div>
    <?php require_once INCS . "footer.view.php" ?>
         <!-- include libraries(jQuery, bootstrap) -->
        <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo BURL . 'dashboard/' ?>assets/js/summernote-bs4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#cSummernote').summernote({
                    height: 300,
                    minHeight: 120,
                });

                $("#cSummernote").summernote('code',`<?= $courseContent ?>`);

                $("#btnSaveCourse").click(()=>{
                    let cTitle = $("#cTitle").val();
                    let cStatus = 1; // draft
                    if($("#s3").is(":checked")){
                        cStatus = 3;  // public
                    }
                    let cContent = $(".note-editing-area .note-editable").html();
                    let cAttachedFile = $("#cFile").prop("files")[0];
                    let cGroups = $("#c_for_groups").val();
                    let courseID = $("#courseID").val();
                    let fileCourseName = $("#fileCourseName").val();
                    let fileName = $("#fileName").val();

                    let form_data = new FormData();
                    form_data.append("cTitle",cTitle);
                    form_data.append("cStatus",cStatus);
                    form_data.append("cContent",cContent);
                    form_data.append("cAttachedFile",cAttachedFile);
                    form_data.append("cGroups",cGroups);

                    form_data.append("courseID",courseID);
                    form_data.append("fileCourseName",fileCourseName);
                    form_data.append("fileName",fileName);

                    $.ajax({
                        url:"/course/update",
                        type:"POST",
                        cache:false,
                        processData:false,
                        contentType:false,
                        dataType:'script',
                        data:form_data,
                        success:function(res){
                            if(res == 'ok'){
                                alert("updated with success");
                                window.location.href = "/course";
                            }else{
                                alert('something went wrong');
                            }
                        }
                    });

                });
            });
        </script>
</body>
</html>