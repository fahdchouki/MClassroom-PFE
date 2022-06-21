<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BURL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BURL ?>assets/css/registre.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Raleway:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>Register</title>
</head>
<body>


<div class="container">
        <?php 
            if(isset($_COOKIE['errors'])){
                // pre(unserialize($_COOKIE['errors']));
            }
        ?>
    <div class="cont">
        <div class="rows">
        <div class="title"><h3><span>M</span>Classroom</h3></div>
    <form action="<?php url("auth/store") ?>" method="post">
        <div class="user-details">
            <div class="input-box">
                <span class="details">Fullname :</span>
                <input type="text" name="fullname">
            </div>
            <div class="input-box">
                <span class="details">Username :</span>
                <input type="text" name="username">
            </div>
            <div class="input-box">
                <span class="details">Email :</span>
                <input type="email" name="email">
            </div>
            <div class="input-box">
                <span class="details" id="me">You are a :</span> <br>
                <select name="type">
                    <option value="1">student</option>
                    <option value="2">teacher</option>
                </select>
            </div>
            <div class="input-box">
                <span class="details">Password :</span>
                <input type="password" name="pass">
            </div>
            <div class="input-box">
                <span class="details">retype password :</span>
                <input type="password" name="rpass">
            </div>
        </div>
        <div class="buttons">
            <span>Already have account ? <a href="<?php url("auth/login") ?>">Login</a></span>
            <input type="submit" value="REGISTER" name="reg" id="sub">
        </div>
    </form>
    </div>
    </div>
</div>



    <script src="<?= BURL ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= BURL ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= BURL ?>assets/js/jquery.bootstrap-growl.min.js"></script>


    <script>

        $("#subb").click(function(){

            $(".bootstrap-growl").remove();

            var fullname = $("input[name='fullname']").val();
            var username = $("input[name='username']").val();
            var email = $("input[name='email']").val();
            var pass = $("input[name='pass']").val();
            var repass = $("input[name='rpass']").val();

            if(email == "" || pass == "" || rpass == "" || fullname == "" || username == ""){
                $.bootstrapGrowl('Please fill all the fields', 
                {type: 'success',
                delay: 4000,
                stackup_spacing: 10,
                allow_dismiss: false
            });

                return false;
            }
             else if(pass != repass){
                $.bootstrapGrowl('Password does not match',{type: 'success',
                delay: 4000,
                stackup_spacing: 10,
                allow_dismiss: false
            });

                return false;
            }
            else{
                return true;
            }
        });


</script>

</body>
</html>