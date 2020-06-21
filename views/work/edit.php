<!doctype html>
<html lang="en">
    <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Todo List</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/work">Work</a></li>
                    <li><a href="/calendar">Calendar</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <h1 class="text-center">Edit work</h1>
            <form action="/work/<?= $work->id ?>/update" method="POST" id="update-form">
                <div class="form-group">
                    <label for="name">Work name</label>
                    <input type="text" class="form-control" id="name" name="work_name" placeholder="Enter work name" value="<?= $work->work_name ?>">
                </div>
                <div class="form-group">
                    <label for="name">Start date</label>
                    <div style="position: relative">
                        <input type="text" class="form-control datetime" id="start_date" name="start_date" value="<?= $work->start_date ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">End date</label>
                    <div style="position: relative">
                        <input type="text" class="form-control datetime" id="end_date" name="end_date" value="<?= $work->end_date ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Status</label>
                    <select name="status" id="status" class="form-control">
                        <?php foreach(\Models\Work::STATUS as $key => $status){ ?>
                            <option value="<?= $key ?>" <?= $work->status == $key ? 'selected' : '' ?>><?= $status ?></option>
                        <?php } ?>
                    </select>
                </div>
                <a href="/work" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script language="javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
        <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script language="javascript" src="<?= assets('assets/js/work.js') ?>"></script>
    </body>
</html>
