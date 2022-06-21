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
        <button type="button" class="btn btn-gradient-primary btn-icon-text btn-icon-prepend" data-bs-toggle="modal" data-bs-target="#createGroupModal"><i class="mdi mdi-account-multiple-plus"></i> Create Group</button>
        <!-- create group modal -->
        <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">New Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="group/create" id="createGroupForm">
                    <div class="mb-3">
                        <label for="group-name" class="col-form-label">Group Name:</label>
                        <input type="text" class="form-control" id="group-name">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="group-icon" class="col-form-label">Group Icon:</label>
                        <input type="file" class="form-control" id="group-icon">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" id="group-type" class="form-check-input"> Public (public group means that everyone can join this group)<i class="input-helper"></i>
                        </label>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseFormGroup" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnCreateGroup">Create</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- end of create group modal -->
        <!-- table of groups -->
        <div class="table-wrapper my-4" style="width: 100%;overflow-x:scroll">
            <table class="table table-bordered table-light"  id="controlOptionsArea">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Group Name</th>
                        <th>Group Type</th>
                        <th>Members</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($groups as $group): ?>
                        <tr>
                            <td>
                                <img src="<?= $group['group_icon'] ? BURL . 'uploads/groups/' . $group['group_icon'] : 'default_icon.jpg'  ?>" alt="">
                            </td>
                            <td>
                                <?= $group['label'] ?>
                            </td>
                            <td><?= $group['group_type'] == 0 ? 'Private' : 'Public' ?></td>
                            <td><?= $group['members'] ?></td>
                            <td><?= $group['created_at'] ?></td>
                            <td class="text-center">
                                <button data-groupid="<?= $group['idGroup'] ?>" class="btn-icon editGrpBtn btn-sm btn btn-success btn-rounded"><i data-groupid="<?= $group['idGroup'] ?>" class="mdi mdi-lead-pencil editGrpBtn"></i></button>
                                <button data-groupid="<?= $group['idGroup'] ?>" class="btn-icon deleteGrpBtn btn-sm btn btn-danger btn-rounded"><i data-groupid="<?= $group['idGroup'] ?>" class="mdi mdi-delete-forever deleteGrpBtn"></i></button>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- edit modal -->
        <button class="btn-icon btn-sm btn btn-info btn-rounded d-none" id="clickBtnEdit" data-bs-toggle="modal" data-bs-target="#editGroupModal"><i class="mdi mdi-eye"></i></button>
        <div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGroupModalLabel">Edit Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGroupForm">
                    <div class="mb-3">
                        <label for="new-group-name" class="col-form-label">Group Name:</label>
                        <input type="text" class="form-control" id="new-group-name">
                        <input type="hidden" id="groupIDInput">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="new-group-icon" class="col-form-label">Group Icon:</label><br>
                        <img width="100px" height="100px" id="img-group-icon">
                        <input type="file" class="form-control" id="new-group-icon">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" id="new-group-type" class="form-check-input"> Public (public group means that everyone can join this group)<i class="input-helper"></i>
                        </label>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseEditFormGroup" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="btnEditGroup">Save</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- end of edit modal -->
    </div>
    <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
    <script>
        $("#controlOptionsArea").DataTable();
        // form create group btn
        $("#btnCreateGroup").on('click',()=>{
            let grpName = $("#group-name").val();
            let grpIcon = $("#group-icon").prop("files")[0];
            let grpType = $("#group-type").is(':checked') ? 1 : 0;
            let grpStatus = $("#group-status").is(':checked') ? 1 : 0;
            let form_data = new FormData();
            form_data.append("groupName",grpName);
            form_data.append("groupIcon",grpIcon);
            form_data.append("groupType",grpType);

            $.ajax({
                url:"/group/create",
                type:"POST",
                cache:false,
                processData:false,
                contentType:false,
                dataType:'script',
                data:form_data,
                success:function(res){
                    if(res == 'ok'){
                        $("#createGroupForm").trigger('reset');
                        $("#btnCloseFormGroup").trigger('click');
                        alert("created with success");
                        window.location.reload();
                    }else{
                        alert('something went wrong');
                    }
                }
            });
            
            
        });
        // edit group

        document.getElementById('controlOptionsArea').addEventListener('click',function(e){
            if(e.target.classList.contains('editGrpBtn')){
                let grpID = e.target.getAttribute("data-groupid");
                $.ajax({
                    url:"/group/get_group_by_id",
                    type:"POST",
                    data:{idGroup:grpID},
                    success:function(resp){
                        let group = JSON.parse(resp);
                        $("#new-group-name").val(group.label);
                        $("#groupIDInput").val(group.idGroup);
                        group.group_icon.length > 0 ? $("#img-group-icon").attr('src',"<?= BURL . 'uploads/groups/' ?>"+group.group_icon+"") : $("#img-group-icon").attr('src',"<?= BURL . 'uploads/groups/default_icon.jpg' ?>");
                        group.group_type == 1 ? $("#new-group-type").attr('checked','true') : '';
                        $("#clickBtnEdit").trigger('click');
                    }
                });
            }
            else if(e.target.classList.contains('deleteGrpBtn')){
                let grpID = e.target.getAttribute("data-groupid");
                if(confirm("Are you sure you want to delete this group ?")){
                    $.ajax({
                        url:"/group/delete",
                        type:"POST",
                        data:{grpID:grpID},
                        success:function(resp){
                            if(resp == 'ok'){
                                alert("Deleted with success");
                                window.location.reload();
                            }else{
                                alert("Unable to delete group");
                            }
                        }
                    });
                }
            }
        });

        $("#btnEditGroup").on('click',()=>{
            let grpID = $("#groupIDInput").val();
            let grpName = $("#new-group-name").val();
            let grpIcon = $("#new-group-icon").prop("files")[0];
            let grpType = $("#new-group-type").is(':checked') ? 1 : 0;
            let form_data = new FormData();
            form_data.append("groupID",grpID);
            form_data.append("groupName",grpName);
            form_data.append("groupIcon",grpIcon);
            form_data.append("groupType",grpType);

            $.ajax({
                url:"/group/update",
                type:"POST",
                cache:false,
                processData:false,
                contentType:false,
                dataType:'script',
                data:form_data,
                success:function(res){
                    if(res == "ok"){
                        $("#editGroupForm").trigger('reset');
                        $("#btnCloseEditFormGroup").trigger('click');
                        alert("updated with success");
                        window.location.reload();
                    }else{
                        alert('something went wrong');
                    }
                }
            });
            
            
        });
    </script>
</body>
</html>