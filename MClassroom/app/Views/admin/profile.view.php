<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom | Profile</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
  </head>
  <body>
  <?php require_once INCS . "header.view.php" ?>
  <!-- <pre> -->
    <div class="content-wrapper">
    <div class="userForm p-3 bg-light mx-auto" style="max-width: 500px;">
        <div class="profileImg bg-dark" style="width: 120px;height:120px;border-radius:50%;overflow:hidden;margin:10px auto;">
          <img src="<?= BURL . "uploads/profiles/" . $infoUser['photo'] ?>" alt="" id="userImg" style="width:100%;height:100%;" >
        </div>
        <label for="photoUpload" class="d-block mx-auto mb-4 mt-2 btn btn-secondary" style="width: max-content !important;">Change photo</label>
        <input type="file" name="" id="photoUpload" class="d-none">
        <label for="">Name</label>
        <input class="form-control my-3" type="text" id="name" value="<?= $infoUser['name'] ?>">
        <label for="" class="<?= auth()->isTeacher() ? '' : 'd-none' ?>">School Subject</label>
        <input class="form-control my-3 <?= auth()->isTeacher() ? '' : 'd-none' ?>" type="text" id="school_subject" value="<?= $infoUser['school_subject'] ?>">
        <label for="">Username</label>
        <input class="form-control my-3" type="text" id="username" value="<?= $infoUser['username'] ?>">
        <label for="">Email</label>
        <input class="form-control my-3" type="email" id="email" value="<?= $infoUser['email'] ?>">
        <label for="">New Password</label>
        <input class="form-control my-3" type="password" id="password" placeholder="leave it empty if no change desired">
        <input type="checkbox" id="showPass"><label for="showPass" style="user-select: none;font-size:.9rem;margin:15px 5px;">Show Passwords</label>
        <button class="btn btn-dark mt-3 w-100" id="btnSaveProfile">Save Changes</button>
    </div>
    </div>
  <!-- </pre> -->
  <?php require_once INCS . "footer.view.php" ?>
  <script>
    $("#showPass").click(()=>{
      if($("#showPass").is(":checked")){
        $("#password").attr('type','text');
      }else{
        $("#password").attr('type','password');
      }
    });

    $('input#photoUpload').change(function (e) {
            var tmppath = URL.createObjectURL(event.target.files[0]);
            $("#userImg").attr('src',tmppath);
      });

    $("#btnSaveProfile").click(()=>{
      let photoUpload = $("#photoUpload").prop("files")[0];
      let name = $("#name").val();
      let school_subject = $("#school_subject").val();
      let username = $("#username").val();
      let email = $("#email").val();
      let password = $("#password").val() || '';

      let form_data = new FormData();
      form_data.append("photoUpload",photoUpload);
      form_data.append("name",name);
      form_data.append("school_subject",school_subject);
      form_data.append("username",username);
      form_data.append("email",email);
      form_data.append("password",password);

      $.ajax({
        url:'/user/update_profile',
        type:"POST",
        cache:false,
        processData:false,
        contentType:false,
        dataType:'script',
        data:form_data,
        success:function(res){
            if(res == 'ok'){
                alert("updated with success");
                window.location.reload();
            }else{
                alert(res);
            }
        }
      });
    });
  </script>
  </body>
</html>