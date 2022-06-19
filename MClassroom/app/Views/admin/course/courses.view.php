<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | MClassroom</title>
<!-- CSS only -->
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/bootstrap-4.6.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
</head>
<body>
    <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
    <div class="table-responsive p-4">
        <?php if(auth()->isTeacher()): ?>
        <table class="table table-bordered m-3 bg-light" id="coursesTable">
            <thead>
            <tr>
                <th>Title <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Groups </th>
                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($courses as $course): ?>
                    <tr>
                        <td><?= $course['title'] ?></td>
                        <td>
                            <?php
                                if($course['status'] == 1){
                                    echo "Draft";
                                }else{
                                    echo "Public";
                                }
                            ?>
                        </td>
                        <td><?= $course['groups'] ?></td>
                        <td><?= $course['created_at'] ?></td>
                        <td style="text-align: center;">
                            <button class="btn btn-info btnShowCourse" data-attached="<?= json_decode($course['content'])->attachedFilename ?>" data-course-title="<?= $course['title'] ?>" data-course-file="<?= json_decode($course['content'])->courseFileName ?>">Show</button>
                            <a class="btn btn-success" href="/course/edit/<?= $course['idCourse'] ?>">Edit</a>
                            <button class="btn btn-danger btnDelCourse" data-courseid="<?= $course['idCourse'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php else: ?>
            <table class="table table-bordered m-3 bg-light" id="coursesTable">
            <thead>
            <tr>
                <th>Title <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Group  <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($courses as $course): ?>
                    <tr>
                        <td><?= $course['title'] ?></td>
                        <td><?= $course['label'] ?></td>
                        <td><?= $course['created_at'] ?></td>
                        <td style="text-align: center;">
                            <button class="btn btn-info btnShowCourse" data-attached="<?= json_decode($course['content'])->attachedFilename ?>" data-course-title="<?= $course['title'] ?>" data-course-file="<?= json_decode($course['content'])->courseFileName ?>">Show</button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php endif ?>
        </div>
    </div>
    <!-- show modal -->
    <button type="button" class="btn btn-primary d-none btnPopup" data-bs-toggle="modal" data-bs-target="#showCourseModal"></button>

    <div class="modal fade" id="showCourseModal" tabindex="-1" aria-labelledby="showCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCourseModalLabel">Course title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light" id="coursePreview">
                
            </div>
            <div class="modal-footer bg-light">
                <a id="exportBtn" href="#" class="btn btn-dark">Download Attached File</a>
            </div>
            </div>
        </div>
    </div>
    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
        <script>
            $(document).ready(function() {
                $('#coursesTable').DataTable();
                [...document.querySelectorAll(".btnDelCourse")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idCourse = el.getAttribute("data-courseid");
                        if(confirm("Are you sure you want to delete this course ?")){
                            $.ajax({
                                url:'/course/delete',
                                type:'POST',
                                data:{idCourse:idCourse},
                                success:(res)=>{
                                    if(res != 'ok'){
                                        alert("Couldn't delete this course");
                                    }else{
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                });

                [...document.querySelectorAll(".btnShowCourse")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let course_title = el.getAttribute("data-course-title");
                        let course_attached = el.getAttribute("data-attached");
                        let course_file = el.getAttribute("data-course-file");
                        $.ajax({
                            url:`/uploads/courses/${course_file}`,
                            context: document.body,
                            success: function(response) {
                                $("#showCourseModalLabel").html(course_title);
                                if(course_attached){
                                    $("#exportBtn").attr('download',course_attached);
                                    $("#exportBtn").attr('href','/uploads/courses/' + course_attached);
                                }
                                $("#coursePreview").html(response);
                                $(".btnPopup").trigger('click');
                            }
                        })
                    });
                });
            });
        </script>
</body>
</html>