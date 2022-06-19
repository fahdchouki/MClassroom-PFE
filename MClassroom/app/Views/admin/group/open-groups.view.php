<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | MClassroom</title>
<!-- CSS only -->
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
</head>
<body>
    <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
<!-- table of groups -->
<div class="table-wrapper my-4" style="width: 100%;overflow-x:scroll">
            <table class="table table-bordered table-light"  id="controlOptionsArea">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Group Name</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allGroups as $group): ?>
                        <tr>
                            <td>
                                <img src="<?= $group['group_icon'] ? BURL . 'uploads/groups/' . $group['group_icon'] : 'default_icon.jpg'  ?>" alt="">
                            </td>
                            <td>
                                <?= $group['label'] ?>
                            </td>
                            <td><?= $group['created_at'] ?></td>
                            <td class="text-center"><button data-groupid="<?= $group['idGroup'] ?>" class="btn btn-info btn-sm btnJoinGroup">Join</button></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            </div>
    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
    <script>
        $("#controlOptionsArea").DataTable();
        document.getElementById('controlOptionsArea').addEventListener('click',function(e){
            if(e.target.classList.contains('btnJoinGroup')){
                let grpID = e.target.getAttribute("data-groupid");
                let userID = <?= auth()->isTeacher() ? auth()->getTeacherID() : auth()->getStudentID() ?> ;
                $.ajax({
                    url:"/group/add_member",
                    type:"POST",
                    data:{groupID:grpID,userID:userID},
                    success:function(resp){
                        if(resp == 'ok'){
                            e.target.parentElement.parentElement.remove();
                        }else{
                            alert("Unable to join group");
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>