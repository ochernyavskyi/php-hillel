<?php require __DIR__ . '/../parts/header.template.php';?>

<title><?= $title;?></title>
</head>
<body>

<?php require __DIR__ . '/../parts/nav.template.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 style="margin: 20px 0;">Advertisement</h1>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Body</th>
                    <th scope="col">Created</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ads as $key) { ?>
                    <tr>
                        <th scope="row"><?= $key['id'];?></th>
                        <td><?= $key['title'];?></td>
                        <td><?= $key['body'];?></td>
                        <td>
                            <?php
                            $date = new DateTime($key['created_at']);
                            echo $date->format('Y-m-d');
                            ?>
                        </td>
                        <td>
                            <a href="/ads/edit?id=<?= $key['id'];?>">Edit</a>
                            <a href="/ads/delete?id=<?= $key['id'];?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php require __DIR__ . '/../parts/script.template.php';?>

</body>
</html>