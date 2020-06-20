<!doctype html>
<html lang="en">
    <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </head>
    <body>
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
                                <a href="#" class="btn btn-danger remove" data-id="<?= $work->id ?>">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('.remove').click(function(event) {
                    click(12313123);
                });
            });
        </script>
    </body>
</html>
