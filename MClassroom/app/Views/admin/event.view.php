<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event | MClassroom</title>
    <link rel="stylesheet" type="text/css" href="<?php echo BURL . 'dashboard/' ?>assets/css/simple-calendar.css"/>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
</head>
<body>
<?php require_once INCS . "header.view.php" ?>
            <div class="content-wrapper">
                <div class="bg-light p-2" id="calendar"></div>
                
                <div class="d-none" id="eventsObjDiv"><?= $eventsStr ?></div>
                <?php if(auth()->isTeacher()): ?>
                    <h2 class="text-center p-3 my-3 bg-dark text-light">All Events</h2>
                    <div class="table-responsive p-4 mt-3" style="max-height: 400px;background:#fff">
                    <button class="btn btn-warning my-2" data-bs-toggle="modal" data-bs-target="#eventAddModal">Add Event</button>
                    <table class="table table-bordered m-3 mt-5 bg-light" id="eventsTable">
                        <thead>
                            <tr>
                                <th>Title <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Group <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Status <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Start Date <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>End Date <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Created At <img src="<?php echo BURL . 'dashboard/' ?>assets/images/icon-sort.png"></th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($events as $event): ?>
                                <tr>
                                    <td><?= $event['title'] ?></td>
                                    <td><?= $event['label'] ?></td>
                                    <td><?= strtotime($event['end_date']) <= time() ? '<span class="badge text-light bg-warning">Expired</span>' : '<span class="badge text-light bg-primary">Valid</span>' ?></td>
                                    <td><?= formatDate($event['start_date'],'D d, M Y H:i') ?></td>
                                    <td><?= formatDate($event['end_date'],'D d, M Y H:i') ?></td>
                                    <td><?= formatDate($event['created_at'],'D d, M Y H:i') ?></td>
                                    <td>
                                        <button class="btn btn-danger btnDelEvent" data-eventid="<?= $event['idEvent'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="eventAddModal" tabindex="-1" aria-labelledby="eventAddModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventAddModalLabel">Add event to calendar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <label for="eventTitle">Event Title</label>
                                <input type="text" class="form-control my-2" id="eventTitle">
                                <label for="eventStart">Start Date</label>
                                <input type="datetime-local" value="<?= date("Y-m-d\TH:i",time()) ?>" class="form-control my-2" id="eventStart">
                                <label for="eventEnd">End Date</label>
                                <input type="datetime-local" value="<?= date("Y-m-d\TH:i",time() + 3600) ?>" class="form-control my-2" id="eventEnd">
                                <label for="eventGroup">Event Group</label>
                                <select id="eventGroup" class="form-control p-3 mt-2">
                                    <option hidden>-- Select group --</option>
                                    <?php foreach($groups as $grp): ?>
                                        <option value="<?= $grp['idGroup'] ?>"><?= $grp['label'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="btnSaveNewEvent" class="btn btn-primary">Save</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
<?php require_once INCS . "footer.view.php" ?>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/bs4.datatables.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/jquery.simple-calendar.min.js"></script>
    <script>
        $(document).ready(function() {

            let eventsObject = JSON.parse(document.getElementById("eventsObjDiv").innerHTML);

            let container = $("#calendar").simpleCalendar({
                disableEmptyDetails:true,
            });

            let $calendar = container.data('plugin_simpleCalendar')
            getAndSetEvents();

            function getAndSetEvents(){
                var events = [];
                eventsObject.forEach(el=>{
                    events.push({
                        startDate: el.start_date,
                        endDate: el.end_date,
                        summary: el.title + " | Group : " + el.label
                    });
                });
                $calendar.setEvents(events);
            }

            <?php if(auth()->isTeacher()): ?>
            $("#eventsTable").DataTable();
                
                

            $("#btnSaveNewEvent").click(()=>{
                // to add event from modal
                // check if start date is less than current date and greater than end date and title if empty
                let title = $("#eventTitle").val();
                let start = $("#eventStart").val();
                let end = $("#eventEnd").val();
                let group = $("#eventGroup").val();

                if(title.trim() == ""){
                    alert("Event title is mandatory");
                }else if((new Date(start)) <= (new Date())){
                    alert("Start date can't be " + start);
                }else if(start > end){
                    alert("End date is invalid");
                }else if(isNaN(group)){
                    alert("Select Group !!");
                }else{
                    $.ajax({
                        url:'event/add_event',
                        type:'POST',
                        data:{title:title,start:start,end:end,groupid:group},
                        success:(res)=>{
                            if(res == 'ok'){
                                // let newEvent = {
                                //         startDate: start,
                                //         endDate: end,
                                //         summary:title, 
                                // }
                                // $calendar.addEvent(newEvent);
                                window.location.reload();
                            }else{
                                alert("Something went wrong")
                            }
                        }
                    });
                }

            });

            [...document.querySelectorAll(".btnDelEvent")].forEach(el=>{
                    el.addEventListener('click',()=>{
                        let idEvent = el.getAttribute("data-eventid");
                        if(confirm("Are you sure you want to delete this event ?")){
                            $.ajax({
                                url:'/event/delete',
                                type:'POST',
                                data:{idEvent:idEvent},
                                success:(res)=>{
                                    if(res != 'ok'){
                                        alert("Couldn't delete this event");
                                    }else{
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                });
            <?php endif; ?>

        });
    </script>
</body>
</html>