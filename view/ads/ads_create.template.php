<?php require __DIR__ . '/../parts/header.template.php';?>

    <title><?= $title; ?></title>
</head>
<body>

<?php require __DIR__ . '/../parts/nav.template.php';?>

<div class="container">
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6">
            <form action="/ads/create" method="POST">
                <div class="form-group">
                    <h1>Advertisement create</h1>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo isset($_SESSION['data']['title']) ? $_SESSION['data']['title'] : '' ;?>">
                    <span style="color:red;font-size: 14px;"><?= error('title'); ?></span>
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <input type="text" class="form-control" name="body" value="<?php echo isset($_SESSION['data']['body']) ? $_SESSION['data']['body'] : '' ;?>">
                    <span style="color:red;font-size: 14px;"><?= error('body'); ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-lg-3">

        </div>
    </div>
</div>
<?php require __DIR__ . '/../parts/script.template.php';?>


</body>
</html>