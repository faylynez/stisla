<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Components &rsaquo; Table &mdash; Stisla</title>
    <!-- Start GA -->
    <?php include 'act/layout/filecss.php' ?>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <?php include 'act/layout/nav.php' ;

            include 'act/layout/side.php' ;

            // <!-- Main Content -->
            
            if(!empty($_GET['page'] == 'tabel')){
                require 'act/admin/table.php';
            }elseif(!empty($_GET['page'] == 'form')){
                require 'act/admin/form.php';
            }elseif(!empty($_GET['page'] == 'dashboard')){
                require 'act/admin/dashboard.php';
            }


            include 'act/layout/footer.php' ?>
        </div>
    </div>

    <!-- General JS Scripts -->
    <?php include 'act/layout/filejs.php' ?>
</body>

</html>