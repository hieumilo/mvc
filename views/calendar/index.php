<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?= assets('assets/css/fullCalendar.css') ?>" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Todo List</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/work">Work</a></li>
                    <li class="active"><a href="/calendar">Calendar</a></li>
                </ul>
            </div>
        </nav>
        <div id='wrap'>

        <div id='calendar' data-events='<?= json_encode($works) ?>'></div>

        <div style='clear:both'></div>
        </div>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
        <script language="javascript" src="<?= assets('assets/js/fullCalendar.js') ?>"></script>
        <script language="javascript" src="<?= assets('assets/js/calendar.js') ?>"></script>
    </body>
</html>
