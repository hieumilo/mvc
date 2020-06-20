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
        <div class="container">
            <h1>welcome</h1>
            <a href="/work" class="mr-3">work</a>
            <a href="/calendar">calendar</a>
        </div>
        <div class="container">
            <h1 class="text-center">work</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>start</th>
                        <th>end</th>
                        <th>status</th>
                        <th>
                            <a href="/work/create" class="btn btn-info">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($works as $work){ ?>
                        <tr>
                            <td scope="row"><?= $work->id ?></td>
                            <td><?= $work->work_name ?></td>
                            <td><?= $work->start_date ?></td>
                            <td><?= $work->end_date ?></td>
                            <td><?= \Models\Work::STATUS[$work->status] ?></td>
                            <td>
                                <a href="/work/<?= $work->id ?>/edit" class="btn btn-info">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" class="btn btn-danger remove-work" data-id="<?= $work->id ?>">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Optional JavaScript -->
        <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script language="javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
        <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script language="javascript" src="<?= assets('assets/work.js') ?>"></script>
    </body>
</html>
