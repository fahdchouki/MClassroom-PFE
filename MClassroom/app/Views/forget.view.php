<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BURL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BURL ?>assets/css/forget.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Raleway:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>forget Passowrd</title>
</head>
<body>


    <div class="container">
        <div class="text-center">
            <h3><span>M</span>Classroom</h3>
        </div>
        <?php if(isset($_COOKIE['npass'])): ?>
                <div class="alert alert-success">
                    <?php 
                            echo "Your new password is : <b>". openssl_decrypt($_COOKIE['npass'],"AES-128-CTR","F0r%e1p@sS") ."</b>  . Please change this password ASAP.<p>Login again : <a href='" 
                                    . BURL . 'auth/login' 
                                    . "'>Link to Login Page</a></p>";
                    ?>
                </div>
            <?php endif ?>
        <?php if(!isset($_COOKIE['forgetEmail'])): ?>
            <div class="rows">
                <form action="<?php url("auth/forget") ?>" method="post">
                    <div class="info">
                        <label for="email">Your Email :</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="go">
                        <input type="submit" name="sendemail" value="Send Code">
                    </div>
                </form>
            </div>
        <?php endif; ?>
        <?php if(isset($_COOKIE['forgetEmail'])): ?>
            <div class="rows">
                <form action="<?php url("auth/forget") ?>" method="post">
                    <div class="info">
                        <label for="email">Code :</label>
                        <input type="text" name="vefcode">
                    </div>
                    <div class="go">
                        <span>Wrong email or code not sent ? <a href="<?php url("auth/forget?resend=1") ?>">Resend</a></span>
                        <input type="submit" name="sendcode" value="Verify Code">
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    
</body>
</html>