<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MClassroom dashboard</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <style>
      .content-wrapper{
        background-image: url("<?= BURL . 'dashboard/assets/images/learning.jpg' ?>");
        background-size: 30%;
        background-position: center bottom;
        background-repeat: no-repeat;
      }
      .cards{
        padding: 10px;
      }
      .dash-card{
        border-radius: 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100px;
        width: 18rem;
        background-color: #fff;
        margin: 20px auto;
        position: relative;
        box-shadow: 0px 8px 11px #00000020;
      }
      .dash-card .number{
        height: 110px;
        background-color: orange;
        color: white;
        font-size: 1.8rem;
        width: 110px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 10px solid #fff;
        margin-left: -20px;
        font-weight: bold;
      }
      .dash-card .det{
        padding: 10px 20px;
      }
      .dash-card .det a.detBtn{
        position: absolute;
        bottom: -10px;
        right: 20px;
        background-color: blueviolet;
        text-decoration: none;
        padding: 10px 30px;
        color: white;
        border-radius: 15px;
        font-size: .9rem;
      }
      .dash-card p.dash-card-title{
        font-size: 2.2rem !important;
        position: absolute !important;
        top: 50%;
        left: 50%;
        transform: translate(-20%, -68%);
        font-weight: bolder;
        opacity: .7;
      }
      table.table{
        background-color: white;
      }
      .table-cont{
        padding: 15px;
        position: relative;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 8px 11px #00000020;
        margin: 20px auto;
      }
      .table-cont .legend{
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: -12px;
        left: 20px;  
        background-color: blueviolet;
        border-radius: 30px;
      }
      .table-cont .legend p.legText{
        color: white;
        padding: 5px 30px;
        font-size: .9rem;
        margin: 0;
      }
    </style>
  </head>
  <body>
  <?php require_once INCS . "header.view.php" ?>
  <div class="content-wrapper">
    <div class="cards row">
      <div class="col">
        <div class="dash-card">
            <div class="number" style="background-color: #5E50F9;"><span><?= $eventsCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Event</p>
              <a href="<?= BURL . 'event' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="dash-card">
            <div class="number" style="background-color: #E91E63;"><span><?= $coursesCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Course</p>
              <a href="<?= BURL . 'course' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="dash-card">
            <div class="number" style="background-color: #1bcfb4;"><span><?= $groupsCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Group</p>
              <a href="<?= BURL . 'group' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="dash-card">
            <div class="number" style="background-color: #fed713;"><span><?= $quizsCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Quiz</p>
              <a href="<?= BURL . 'task' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="dash-card">
            <div class="number" style="background-color: #3e4b5b;"><span><?= $exercicesCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Exercice</p>
              <a href="<?= BURL . 'task' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
      <div class="col">
        <div class="dash-card">
            <div class="number"><span><?= $livechatsCount ?></span></div>
            <div class="det">
              <p class="dash-card-title">Livechat</p>
              <a href="<?= BURL . 'livechat' ?>" class="detBtn">Details</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once INCS . "footer.view.php" ?>
  </body>
</html>