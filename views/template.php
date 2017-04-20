<?php
$cont = View::getContent();
require_once ROOT.'/extensions/vendor/autoload.php';

?>

<!DOCTYPE HTML>
<html>
<head>
    <title><?=HTTP_SITE_NAME; ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/mystyle.css">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $js = [
            'myscript.js'
        ];

        $(document).ready(function () {
            for(var i = 0; i<$js.length;i++){
                $.post('<?=HTTP_SITE.'/ajaxPHP/returnJS.php?js=result';?>', {url: $js[i]}).done(function (data) {
                    eval(data);
                });
            }
        });
    </script>
</head>

<body class="contentIndexPage">
<!-- Wrapper -->
<div id="wrapper">
    <!-- основний контент для вставки -->
    <?php
    $loader = new Twig_Loader_Filesystem(ROOT.'/views');
    $twig = new Twig_Environment($loader, ['cache'=>false]);

    echo $twig->render($view->getIncludeView(), $cont);
    ?>
</div>
<!-- Footer -->
<footer id="footer" class="m-05">
    <ul class="copyright">
        <li class="copy">&copy; Copyright 2016<span>|</span>CSS Template.<br> Design by <a target="_blank" href="mailto:master1988roma@gmail.com">Sydorchuk Roman</a></li>
    </ul>
</footer>
</body>
</html>