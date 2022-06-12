<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event | MClassroom</title>
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?php echo BURL . 'dashboard/' ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo BURL . 'dashboard/' ?>assets/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo BURL . 'dashboard/' ?>assets/css/evo-calendar.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo BURL . 'dashboard/' ?>assets/css/evo-calendar.midnight-blue.min.css"/>
</head>
<body>
<?php require_once INCS . "header.view.php" ?>
                <div id="calendar"></div>
<?php require_once INCS . "footer.view.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo BURL . 'dashboard/' ?>assets/js/evo-calendar.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#calendar').evoCalendar({
        format: "MM dd, yyyy",
        titleFormat: "MM",
        calendarEvents: [
        {
            id: "d8jai7s",
            name: "Mr Robot",
            description: "take a break before you burn out",
            date: "June/2/2022",
            type: "event",
            everyYear: !0
        },
        {
            id: "d8jai7s",
            name: "Other boring event",
            description: "take a break before you burn out",
            badge: "One day break",
            date: "June/2/2022",
            type: "birthday",
            everyYear: !0
        },{
            id: "d8jai7s",
            name: "Mr Robot t jumia",
            description: "A test event for figma design",
            date: "June/12/2022",
            type: "birthday",
            everyYear: !0
        }, {
            id: "sKn89hi",
            name: "1-Week Coding Bootcamp",
            description: "A test event for figma design",
            badge: "5-day event",
            date: "June/5/2022",
            type: "event",
            everyYear: !0
        }, {
            id: "sKn89hi",
            name: "1-Week Coding Bootcamp",
            description: "A test event for figma design",
            badge: "5-day event",
            date: "June/15/2022",
            type: "event",
            everyYear: !0
        }]
    });

        })
    </script>
</body>
</html>