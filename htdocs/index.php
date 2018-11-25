<!doctype html>
<html>
    <head>
        <title>Home</title>
        <link href="main.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="container">
            <div class="header">
                <?php
                require_once 'include/inc_logo.php';
                ?>
            </div>
            <div class="sidebar1">
                <span>
                    <?php
                    require_once 'include/inc_nav.php';
                    require_once 'include/inc_sidebar1.php';
                    ?>
                </span>
            </div>
            <div class="sidebar2">
                <span>
                    <?php
                    require_once 'include/inc_sidebar2.php';
                    ?>
                </span>
            </div>
            <div class="content">
                <?php
                require_once 'include/inc_form.php';
                ?>

            </div>
            <div class="footer">
                <?php require_once 'include/inc_footer.php'; ?>
            </div>
        </div>
    </body>
</html>
