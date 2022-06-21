<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups | MClassroom</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/chat.css">
</head>
<body>
<?php require_once INCS . "header.view.php" ?>
              <div class="chatgroups" style="padding: 10px;" data-userid="<?= auth()->isStudent() ? auth()->getStudentID() : auth()->getTeacherID() ?>" data-admin="<?= $allGroups[0]['grp_admin'] ?>">
                <div class="app">
                  <div class="wrapper">
                  <div class="conversation-area" id="conversation-area">
                    <?php foreach($allGroups as $grp): ?>
                      <div class="msg grp-conv" data-groupid="<?= $grp['grpID'] ?>" data-grouplabel="<?= $grp['label'] ?>">
                      <img class="msg-profile" src="<?= BURL . 'uploads/groups/' . $grp['group_icon'] ?>" alt="" />
                      <div class="msg-detail">
                        <div class="msg-username"><?= $grp['label'] ?></div>
                        <div class="msg-content">
                          <style>
                            .msg-message img{
                              width: 30px;
                              height: 30px;
                              margin-right: 20px;
                            }
                          </style>
                        <span class="msg-message"><?= is_null($grp['content']) ? 'No message yet' : $grp['content'] ?></span>
                        <span class="msg-date text-center"><?= is_null($grp['created_at']) ? '' : formatDate($grp['created_at'],'d M H:i') ?></span>
                        </div>
                      </div>
                      </div>
                    <?php endforeach ?>
                    <div class="overlay"></div>
                  </div>
                  <div class="chat-area blank-chat-area" style="background-color: #0b232e;"></div>
                  <div class="chat-area fill-chat-area" style="display: none;">
                    <div class="chat-area-header">
                      <div id="backToGroupsBtn">X</div>
                      <div class="chat-area-title"> <p id="group-chat-title" style="margin-bottom: 0px;" ></p> <span id="group-chat-members" style="font-weight: normal;font-size: .8rem;"></span></div>
                      <div class="chat-area-menu">
                        <style>
                          .chat-area-menu{
                            position: relative;
                          }
                          .chat-area-menu-options{
                            position: absolute;
                            top: 20px;
                            right: 20px;
                            width: 150px;
                            background: aliceblue;
                            padding: 5px;
                          }
                          .chat-area-menu-options button{
                            display: block;
                            width: 100%;
                            padding: 10px 8px;
                            border: none;
                            background: none;
                            margin: 10px 2px;
                            font-size: .9rem;
                          }
                          .chat-area-menu-options button:hover{
                            background-color: #f1f1f1;
                          }
                        </style>
                        <i class="mdi mdi-settings showOptionsBtn" style="cursor: pointer;"></i>
                        <div class="chat-area-menu-options d-none">
                          <button data-bs-toggle="modal" data-bs-target="#memSettingsModal" id="memSettBtn">Members</button>
                          <?php if(auth()->isStudent()): ?>
                            <button data-bs-toggle="modal" data-stdid="<?= auth()->getStudentID() ?>" id="exitGroupBtn" >Exit</button>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="chat-area-main" style="min-height: 100%;">
                    </div>
                    <div class="chat-area-footer">
                      <div id="emojiContainer" class="emojiContainer d-none" style="position: absolute !important;top: -50px;background: aliceblue;user-select:none;padding:15px">
                        <span class="emojiCode">&#128512;</span>
                        <span class="emojiCode">&#128513;</span>
                        <span class="emojiCode">&#128514;</span>
                        <span class="emojiCode">&#128515;</span>
                        <span class="emojiCode">&#128516;</span>
                        <span class="emojiCode">&#128517;</span>
                        <span class="emojiCode">&#128525;</span>
                        <span class="emojiCode">&#128549;</span>
                        <span class="emojiCode">&#128557;</span>
                        <span class="emojiCode">&#128077;</span>
                      </div>
                      <div class="imgShowContainer d-none" id="imgShowContainer" style="position: absolute !important;bottom: 75px;background: aliceblue;user-select:none;padding:10px">
                        <div class="imgContShow">
                            <img alt="" id="imgShow">
                        </div>
                        <button id="btnCloseImg" class="btn btn-secondary btn-sm my-2">Close</button>
                        <button id="btnSendImg" class="btn btn-info btn-sm my-2">Send</button>
                      </div>
                      <style>
                        .imgShowContainer{
                          max-width: 60%;
                          max-height: 300px;
                        }
                        .imgContShow{
                          width: 100%;
                        }
                        .imgContShow img{
                          max-height: 220px;
                          max-width: 150px;
                        }
                              #inputMessage{
                                width: 100%;
                                height: 50px;
                                background: aliceblue;
                                margin: 1px 3px;
                                padding: 15px;
                                overflow: hidden;
                              }
                              .emojiCode{
                                cursor: pointer;
                              }
                            </style>
                      <label for="inputMessageFile" class="me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <path d="M21 15l-5-5L5 21" /></svg>
                        </label>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile" id="btnShowEmojis" class="btnShowEmojis">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01" /></svg>
                        <div class="inputField" data-msg="" placeholder="Type something here..." id="inputMessage" contenteditable="true"></div>
                        <input type="file" class="d-none" id="inputMessageFile" />
                        <i class="mdi mdi-send btn btn-rounded btn-sm btn-info" id="btnSendMsg"></i>
                    </div>
                  </div>
                  </div>
                </div>
              </div>

        <!-- modal for options -->
        <div class="modal fade" id="memSettingsModal" tabindex="-1" aria-labelledby="memSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="memSettingsModalLabel">Members</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="memForm">
                <div class="mb-3">
                  <?php if(auth()->isTeacher()): ?>
                  <input type="text" class="form-control" id="searchUsername" placeholder="Type member username">
                  <style>
                    .s-cont{
                      margin:5px 0px;
                      background-color: #b4c7f0;
                      padding: 8px;
                      width:100%;
                      display:flex;
                      justify-content:space-between;
                    }
                    .btn-action{
                      cursor: pointer;
                    }
                  </style>
                  <div class="usernamesResult" id="usernamesResult" style="max-height: 250px;overflow-y:scroll">
                  </div>
                  <?php endif; ?>
                </div>
                <div class="mb-3" id="addUsersArea"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnMemClose">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Show Image Modal -->
      <button type="button" class="d-none" data-bs-toggle="modal" data-bs-target="#showImage" id="openImgShow"> </button>
      <div class="modal fade" id="showImage" tabindex="-1" aria-labelledby="showImageLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="showImageLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img src="" alt="" id="showImgInModal">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end of show image modal -->
      <?php require_once INCS . "footer.view.php" ?>
        <script>

          $("#backToGroupsBtn").click(()=>{
            document.getElementById("backToGroupsBtn").style.display = "none";
            document.getElementById("conversation-area").style.width = "100%";
          });
          $(window).resize(()=>{
            if(window.innerWidth <= 780){
                      document.getElementById("conversation-area").style.width = "100%";
            }else{
              document.getElementById("conversation-area").style.width = "auto";            
            }
          });


          document.querySelector(".chat-area").scrollTop = document.querySelector(".chat-area").scrollHeight;
          document.querySelector("#emojiContainer").addEventListener('click',(el)=>{
            if(el.target.classList.contains('emojiCode')){
              $("#inputMessage").append(el.target.innerText);
            }
          });

          document.querySelector("#btnShowEmojis").addEventListener('click',(el)=>{
            document.querySelector("#emojiContainer").classList.toggle("d-none");
          });

          $('input#inputMessageFile').change(function (e) {
            var tmppath = URL.createObjectURL(event.target.files[0]);
            $("#imgShow").attr('src',tmppath);
            document.querySelector("#imgShowContainer").classList.remove("d-none");
          });

          $("#btnCloseImg").click(()=>{
            document.querySelector("#imgShowContainer").classList.add("d-none");
          });

          $("#btnSendImg").click(()=>{
            let imgToSend = $("#inputMessageFile").prop("files")[0];
            let group_id = $("#memSettBtn").attr('data-groupid');
            let dataUserID = $(".chatgroups").attr("data-userid");
            let form_data = new FormData();
            form_data.append("imgToSend",imgToSend);
            form_data.append("group_id",group_id);
            form_data.append("dataUserID",dataUserID);
            $.ajax({
                url:"/message/store_msg",
                type:"POST",
                cache:false,
                processData:false,
                contentType:false,
                dataType:'script',
                data:form_data,
                success:function(res){
                    if(res == "ok"){
                      document.querySelector("#imgShowContainer").classList.add("d-none");
                    }else{
                        alert('something went wrong');
                    }
                }
            });
          });

          document.querySelector(".chat-area-main").addEventListener('click',(e)=>{
            if(e.target.classList.contains("clickMeImg")){
              $("#showImgInModal").attr('src',e.target.getAttribute('src'));
              document.getElementById("openImgShow").click();
            }
          });

          // document.querySelector(".chat-area").scrollTop = document.querySelector(".chat-area").scrollHeight;



          let group_id = '';
          localStorage.setItem('grouplabel','');
          localStorage.setItem('groupactive',0);
          localStorage.setItem('group_el','');
          function getAllGroups(){
            
            $.ajax({
              url:'/group/get_refresh',
              type:'GET',
              data:{getall:1},
              success:(resp)=>{
                let allGroups = JSON.parse(resp);
                let grps = '';
                allGroups.forEach(grp=>{
                  grps += `<div class="msg grp-conv ${localStorage.getItem('groupactive') == grp.grpID ? 'active' : ''}" data-groupid="${grp.grpID}" data-grouplabel="${grp.label}">
                      <img class="msg-profile" src="<?= BURL . 'uploads/groups/' ?>${grp.group_icon}" alt="" />
                      <div class="msg-detail">
                        <div class="msg-username">${grp.label}</div>
                        <div class="msg-content">
                        <style>
                            .msg-message img{
                              width: 30px;
                              height: 30px;
                              margin-right: 20px;
                            }
                          </style>
                        <span class="msg-message">${grp.content == null ? 'No message yet' : grp.content}</span>
                        <span class="msg-date text-center">${grp.created_atF || ''}</span>
                        </div>
                      </div>
                      </div>`;
                });
                grps += `<div class="overlay"></div>`;
                $('.conversation-area').html(grps);
                getGroupMessages(localStorage.getItem('groupactive'),localStorage.getItem('group_el'))
                
              }
            });
          }
          const mediaQuery = window.matchMedia('(max-width: 780px)');
          document.querySelector(".conversation-area").addEventListener('click',(ev)=>{
                    if (mediaQuery.matches) {                 
                      document.getElementById("backToGroupsBtn").style.display = "inline-block";
                      document.getElementById("conversation-area").style.width = "0%";
                    }else{
                      document.getElementById("conversation-area").style.width = "auto";
                    }
                  if(ev.target.classList.contains('grp-conv')){
                    let el = ev.target;
                    let group_id = el.getAttribute('data-groupid');
                    localStorage.setItem('groupactive',group_id);
                    localStorage.setItem('group_el',el);
                    localStorage.setItem('grouplabel',el.getAttribute('data-grouplabel'));
                    el.classList.add('active');
                    [...document.getElementsByClassName("grp-conv")].forEach((elt)=>{elt != el ? elt.classList.remove('active') : ''})
                    getGroupMessages(group_id,el)
                  }
                  // document.querySelector(".chat-area").scrollTop = document.querySelector(".chat-area").scrollHeight;
                  if(ev.target.parentElement.classList.contains('grp-conv')){
                    let el = ev.target.parentElement;
                    let group_id = el.getAttribute('data-groupid');
                    localStorage.setItem('groupactive',group_id);
                    localStorage.setItem('group_el',el);
                    localStorage.setItem('grouplabel',el.getAttribute('data-grouplabel'));
                    el.classList.add('active');
                    [...document.getElementsByClassName("grp-conv")].forEach((elt)=>{elt != el ? elt.classList.remove('active') : ''})
                    getGroupMessages(group_id,el)
                  }
                  if(ev.target.parentElement.parentElement.classList.contains('grp-conv')){
                    let el = ev.target.parentElement.parentElement;
                    let group_id = el.getAttribute('data-groupid');
                    localStorage.setItem('groupactive',group_id);
                    localStorage.setItem('group_el',el);
                    localStorage.setItem('grouplabel',el.getAttribute('data-grouplabel'));
                    el.classList.add('active');
                    [...document.getElementsByClassName("grp-conv")].forEach((elt)=>{elt != el ? elt.classList.remove('active') : ''})
                    getGroupMessages(group_id,el)
                  }
                  if(ev.target.parentElement.parentElement.parentElement.classList.contains('grp-conv')){
                    let el = ev.target.parentElement.parentElement.parentElement;
                    let group_id = el.getAttribute('data-groupid');
                    localStorage.setItem('groupactive',group_id);
                    localStorage.setItem('group_el',el);
                    localStorage.setItem('grouplabel',el.getAttribute('data-grouplabel'));
                    el.classList.add('active');
                    [...document.getElementsByClassName("grp-conv")].forEach((elt)=>{elt != el ? elt.classList.remove('active') : ''})
                    getGroupMessages(group_id,el)
                  }
                });
                
                [...document.getElementsByClassName("grp-conv")].forEach(el => {
                  el.addEventListener('click',function(e){
                  let group_id = el.getAttribute('data-groupid');
                  localStorage.setItem('groupactive',group_id);
                  localStorage.setItem('group_el',el);
                  localStorage.setItem('grouplabel',el.getAttribute('data-grouplabel'));
                  el.classList.add('active');
                  [...document.getElementsByClassName("grp-conv")].forEach((elt)=>{elt != el ? elt.classList.remove('active') : ''})
                  getGroupMessages(group_id,el);
          });
          });

          function getGroupMessages(group_id,el){
            if(group_id != 0 && el != ''){
            $.ajax({
                url:'/group/get_group_chats',
                type:'POST',
                data:{grpID:group_id},
                success:function(resp){
                  let chats = resp.length > 0 ? JSON.parse(resp) : [];
                  $("#group-chat-title").html(localStorage.getItem('grouplabel'));
                  $("#group-chat-members").html((chats.groupInfo[0] == undefined ? 0 : chats.groupInfo[0].members) + " Members");
                  $("#memSettBtn").attr('data-groupid',chats.groupInfo[0].idGroup); ////////////
                  $("#exitGroupBtn").attr('data-groupid',chats.groupInfo[0].idGroup);/////////////////////////
                  let msgs = '';
                  let dataUserID = $(".chatgroups").attr("data-userid");
                  chats.groupMsgs.forEach(msg => {
                    msgs += `<div class="chat-msg ${msg.idUser == dataUserID ? 'owner' : ''}">
                                <div class="chat-msg-profile">
                                <img class="chat-msg-img" src="<?= BURL.'uploads/profiles/' ?>${msg.photo}" alt="" />
                                <div class="chat-msg-date"><span>${msg.name} - </span>${msg.created_atF}</div>
                                </div>
                                <div class="chat-msg-content">
                                  <div class="chat-msg-text" style="width: 100%;word-break: break-word;">${msg.content}</div>
                                </div>
                              </div>`;
                  })

                  $(".chat-area-main").html(msgs);
                  
                  $(".blank-chat-area").remove();
                  // document.querySelector(".chat-area-menu-options").classList.add("d-none");
                  $(".fill-chat-area").css('display','block');
                  setTimeout(()=>{
                    getAllGroups();
                  },3000)
                }
              });
            }
          }

          document.querySelector(".showOptionsBtn").onclick = () => {
            document.querySelector(".chat-area-menu-options").classList.toggle("d-none");
          }

          // show group members
          document.getElementById("memSettBtn").addEventListener('click',()=>{
            group_id = $("#memSettBtn").attr('data-groupid');
            let adminID = $(".chatgroups").attr('data-admin');
            $.ajax({
              url:'/group/get_group_members',
              type:'POST',
              data:{grpID:group_id},
              success:(resp)=>{
                $mems = JSON.parse(resp);
                let member = "";
                let btnRemove = '';
                $mems.forEach(m =>{
                  if(adminID == $(".chatgroups").attr("data-userid")){
                    btnRemove = `<i class="mdi mdi-delete text-danger btn-action btnDelMem" data-userid='${m.idUser}' data-grpid='${group_id}'></i>`;
                    if(m.idUser == adminID){
                      m.username = 'You';
                      btnRemove = '';
                    }
                  }
                  if(m.idUser == $(".chatgroups").attr("data-userid")){
                    m.username = 'You';
                  }
                  member += `<p class="d-inline-block m-1" style="background-color: #b4c7ff;padding: 5px 8px;">
                            <span class="member-username">${m.username}</span> 
                            ${btnRemove}
                          </p>`;
                        })
                $("#addUsersArea").html(member);
                
              }
            })
          });
        document.getElementById("addUsersArea").addEventListener('click',(e)=>{
          if(e.target.classList.contains('btnDelMem')){
            if(confirm('Are you sure you want to remove member from group ?')){
              let userID = e.target.getAttribute('data-userid');
              let groupID = e.target.getAttribute('data-grpid');
              $.ajax({
                url:'/group/delete_member',
                type:'POST',
                data:{user_id:userID,group_id:groupID},
                success:(resp)=>{
                  if(resp != 'ok'){
                      alert('Unable to remove member')
                  }else{
                    e.target.parentElement.remove();
                  }
                } }) } } } );
            

          $("#btnMemClose").click(()=>{
              $("#searchUsername").val('');
              $("#usernamesResult").html('');
          });

          $("#memSettingsModal").click(()=>{
              $("#searchUsername").val('');
              $("#usernamesResult").html('')
          })

          // search users by usernames
            $("#searchUsername").keyup(function(){
                let searchQuery = $("#searchUsername").val().split(" ")[0];
                $.ajax({
                    url:"/group/search_user",
                    method: "POST",
                    data: {searchByUsername:searchQuery,grpID:group_id},
                    success: function(response){
                        let user = "";
                        let adminID = $(".chatgroups").attr('data-admin');
                        response = response.length > 1 ? JSON.parse(response) : [];
                        response.forEach(el =>{
                            if(el.idUser != adminID){
                              user += `<div class="s-cont">
                                        <div><span class="memberUsername">${el.username}</span> | <span class="memberName">${el.name}</span></div> 
                                        <i class="mdi mdi-plus text-dark bg-info btn-action addMemberBtn" data-userid="${el.idUser}" data-username="${el.username}"></i>
                                      </div>`;
                            }
                        })
                        $("#usernamesResult").html(user);
                    }
                });
            });
          if(document.getElementById('usernamesResult') != null){
              document.getElementById('usernamesResult').addEventListener('click',function(e){
                  if(e.target.classList.contains('addMemberBtn')){
                      let username = e.target.getAttribute("data-username");
                      let userid = e.target.getAttribute("data-userid");
                      group_id = $("#memSettBtn").attr('data-groupid');
                      $.ajax({
                        url:'/group/add_member',
                        type:'POST',
                        data:{userID:userid,groupID:group_id},
                        success:function(resp){
                          if(resp == 'ok'){
                            e.target.parentElement.remove();
                            username = `<p class="d-inline-block m-1" style="background-color: #b4c7ff;padding: 5px 8px;">
                                      <span class="member-username">${username}</span> 
                                      <i class="mdi mdi-delete text-danger btn-action"></i>
                                    </p>`;
                            $("#addUsersArea").prepend(username);
                          }else{
                            alert('error adding member')
                          }
                        }
                      });
                  }
              });
            }

        // exit from group
        if(document.getElementById("exitGroupBtn") != null){
          document.getElementById("exitGroupBtn").addEventListener('click',()=>{
              let grpID = $("#exitGroupBtn").attr('data-groupid');
              let stdID = $("#exitGroupBtn").attr('data-stdid');
              $.ajax({
                url:'/group/exit_from_group',
                type:'POST',
                data:{groupID:grpID,studentID:stdID},
                success:(resp)=>{
                  if(resp == 'ok'){
                    localStorage.setItem('groupactive',0);
                    localStorage.setItem('group_el','');
                    window.location.reload();
                  }else{
                    alert('Unable to exit from group');
                  }
                }
              })
  
            });
        }

        // send message

        $("#btnSendMsg").click(()=>{
          let msg =$("#inputMessage").html();
          let group_id = $("#memSettBtn").attr('data-groupid');
          let dataUserID = $(".chatgroups").attr("data-userid");
          $.ajax({
            url:'/message/store_msg',
            type:'POST',
            data:{senderID:dataUserID,groupID:group_id,msgContent:msg},
            success:(resp)=>{
              if(resp == 'ok'){
                $("#inputMessage").html('');
                let newMsg = `<div class="chat-msg owner">
                                <div class="chat-msg-profile">
                                <img class="chat-msg-img" src="<?= BURL.'uploads/profiles/' . auth()->getSessUserInfo()['photo'] ?>" alt="" />
                                <div class="chat-msg-date"><span><?= auth()->getSessUserInfo()['name'] ?> - </span>now</div>
                                </div>
                                <div class="chat-msg-content">
                                  <div class="chat-msg-text">${msg}</div>
                                </div>
                              </div>`;

                  $(".chat-area-main").append(newMsg);
                  getAllGroups();
              }
            }
          })
        });
      
        // setInterval(()=>{
        //   getAllGroups();
        // },1000)

        // update();
        </script>
  </body>
</html>