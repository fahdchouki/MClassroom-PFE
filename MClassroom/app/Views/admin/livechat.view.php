<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom | Livechat</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
  </head>
  <body>
    <?php require_once INCS . "header.view.php" ?>
    <div class="content-wrapper">
        <h2 class="text-center p-3 my-3 bg-dark text-light">All Livechats</h2>
        <div class="table-responsive p-4 mt-3" style="max-height: 400px;background:#fff">
            <?php if(auth()->isTeacher()): ?>
                    <button class="btn btn-warning my-2" data-bs-toggle="modal" data-bs-target="#livechatAddModal">Add Livechat</button>
                    <table class="table table-bordered m-3 mt-5 bg-light" id="livechatsTable">
                        <thead>
                            <tr>
                                <th>Subject <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Group <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Channel <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Schedualed For <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $channels = ['Google Meet','Microsoft Teams','Zoom','Discord'];
                            foreach($livechats as $livechat): ?>
                                <tr>
                                    <td><?= $livechat['subject'] ?></td>
                                    <td><?= strtotime($livechat['for_date']) <= time() ? '<span class="badge text-light bg-warning">Expired</span>' : '<span class="badge text-light bg-primary">Valid</span>' ?></td>
                                    <td><?= $livechat['label'] ?></td>
                                    <td><?= $channels[$livechat['channel'] - 1] ?></td>
                                    <td><?= formatDate($livechat['for_date'],'D d, M Y H:i') ?></td>
                                    <td><?= formatDate($livechat['created_at'],'D d, M Y H:i') ?></td>
                                    <td>
                                        <button class="btn btn-danger btnDelLivechat" data-livechatid="<?= $livechat['idLive'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="livechatAddModal" tabindex="-1" aria-labelledby="livechatAddModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="livechatAddModalLabel">New Livechat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <label for="livechatTitle">Livechat Subject</label>
                                    <input type="text" class="form-control my-2" id="livechatTitle">
                                    <label for="livechatStart">Schedualed For</label>
                                    <input type="datetime-local" value="<?= date("Y-m-d\TH:i",time()) ?>" class="form-control my-2" id="livechatStart">
                                    <label for="livechatGroup">Livechat Group</label>
                                    <select id="livechatGroup" class="form-control p-3 my-2">
                                        <option hidden>-- Select group --</option>
                                        <?php foreach($groups as $grp): ?>
                                            <option value="<?= $grp['idGroup'] ?>"><?= $grp['label'] ?></option>
                                            <?php endforeach ?>
                                    </select>
                                    <label for="livechatGroup">Livechat Channel</label>
                                    <select id="livechatChannel" class="form-control p-3 mt-2">
                                        <option hidden>-- Select channel --</option>
                                        <option value="1">Google Meet</option>
                                        <option value="2">Microsoft Teams</option>
                                        <option value="3">Zoom</option>
                                        <option value="4">Discord</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="btnSaveNewLivechat" class="btn btn-primary">Save</button>
                            </div>
                            </div>
                        </div>
                    </div>
            <?php else: ?>
                <table class="table table-bordered m-3 mt-5 bg-light" id="livechatsTable">
                        <thead>
                            <tr>
                                <th>Subject <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Group <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Channel <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Schedualed For <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $channels = ['Google Meet','Microsoft Teams','Zoom','Discord'];
                            foreach($livechats as $livechat): ?>
                                <tr>
                                    <td><?= $livechat['subject'] ?></td>
                                    <td><?= strtotime($livechat['for_date']) <= time() ? '<span class="badge text-light bg-warning">Expired</span>' : '<span class="badge text-light bg-primary">Valid</span>' ?></td>
                                    <td><?= $livechat['label'] ?></td>
                                    <td><?= $channels[$livechat['channel'] - 1] ?></td>
                                    <td><?= formatDate($livechat['for_date'],'D d, M Y H:i') ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
            <?php endif; ?>
        </div>
    </div>
  <?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
    <script>
        $(document).ready(function() {
            
            $("#livechatsTable").DataTable();
            <?php if(auth()->isTeacher()): ?>
                
                
                document.querySelector("table").addEventListener('click',(e)=>{
                    if(e.target.classList.contains('btnDelLivechat')){
                        let idLivechat = e.target.getAttribute("data-livechatid");
                            if(confirm("Are you sure you want to delete this livechat ?")){
                                $.ajax({
                                    url:'/livechat/delete',
                                    type:'POST',
                                    data:{idLivechat:idLivechat},
                                    success:(res)=>{
                                        if(res != 'ok'){
                                            alert("Couldn't delete this livechat");
                                        }else{
                                            window.location.reload();
                                        }
                                    }
                                });
                    }
                    }
                });

            $("#btnSaveNewLivechat").click(()=>{
                let title = $("#livechatTitle").val();
                let forDate = $("#livechatStart").val();
                let group = $("#livechatGroup").val();
                let channel = $("#livechatChannel").val();

                if(title.trim() == ""){
                    alert("Livechat Subject is mandatory");
                }else if((new Date(forDate)) <= (new Date())){
                    alert("Livechat date can't be " + forDate);
                }else if(isNaN(group)){
                    alert("Select Group !!");
                }else if(isNaN(channel)){
                    alert("Select channel");
                }else{
                    $.ajax({
                        url:'livechat/create',
                        type:'POST',
                        data:{title:title,forDate:forDate,channel:channel,groupid:group},
                        success:(res)=>{
                            if(res == 'ok'){
                                window.location.reload();
                            }else{
                                alert("Something went wrong")
                            }
                        }
                    });
                }

            });

            
            <?php endif; ?>

        });
    </script>
  </body>
</html>