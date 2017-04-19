<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 01.11.2016
 * Time: 15:53
 **/

//створюємо масив для рекламних блоків та перевіряємо чи можна вставляти рекламу
$arrayRekl = array();
if ($settings->getValue('reklama_vert') == '1') {
    if ($settings->getValue('reklama_vert_left') == '1') {
        $arrayRekl['left'] = '<div id="reklam-block-vartical-left" class="reklam-block-vartical no-upper"></div>';
    }
    if ($settings->getValue('reklama_vert_right') == '1') {
        $arrayRekl['right'] = '<div id="reklam-block-vartical-right" class="reklam-block-vartical no-upper"></div>';
    }
}
else
{
    unset($arrayRekl);
}

$cont = View::getContent();

if(!isset($cont['index'])){
    if ($settings->getValue('reklama_vert') == '1') {
        $rightReklama = '<div class="rightR">' . (isset($arrayRekl['right']) ? $arrayRekl['right'] : '') . '</div>';
    }
    else{
        $rightReklama = '<div></div>';
    }
}
else
    $rightReklama = '<div class="rightRIndex"></div>';

$language = 'pl';
if (isset($_SESSION['language'])) {
    $language = $_SESSION['language'];
}
else{
    if(isset($_COOKIE['language'])){
        $_SESSION['language'] = $_COOKIE['language'];
        $language = $_COOKIE['language'];
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title><?=HTTP_SITE_NAME; ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/mystyle_min.css">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script defer src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Вставьте этот тег в заголовке страницы или непосредственно перед закрывающим тегом основной части. -->
    <script async defer src="https://apis.google.com/js/platform.js">{lang: '<?=$language;?>'}</script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?142"></script>
    <!-- силка необхідна для відправлення повідомлення про дилемат -->
    <script type="text/javascript" src="https://vk.com/js/api/share.js?94" charset="windows-1251"></script>

    <script defer type="text/javascript" src="../assets/js/load_language.js"></script>
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
<!-- FaceBook -->
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8&appId=1552720118101590";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- Twitter -->
<script>window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };

        return t;
    }(document, "script", "twitter-wjs"));</script>
<!-- Language -->
<input type="hidden" name="language" value="<?=$language;?>">
<!--  -->
<div class="leftR"><?=(isset($arrayRekl['left'])?$arrayRekl['left']:'');?></div>

<!-- Wrapper -->
<div id="wrapper">
    <!-- основний контент для вставки -->
    <?php include ($view->getIncludeView()); ?>

    <div>

    </div>
    <!-- Footer -->
    <footer id="footer">
        <ul class="copyright">
            <li class="copy">&copy; Copyright 2016<span>|</span>CSS Template.<br> Design by <a target="_blank" href="mailto:master1988roma@gmail.com">Sydorchuk Roman</a></li>
        </ul>
    </footer>
</div>

<!-- показуємо рекламу вертикальну -->
<?=$rightReklama;?>


<?php if($page != 'index'){include_once (ROOT.'/components/Menu.php');} ?>
<div id="fb-root" class=" fb_reset" style="display: none;"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"></div></div>
<!--заносимо дані користувачів, які заходили на сайт-->
<script>
    $.post('<?=HTTP_SITE . '/ajaxPHP/counterUser.php';?>', {
        from_site: "<?=$_SERVER['HTTP_REFERER'];?>",
        ip: "<?=$_SERVER['REMOTE_ADDR'];?>"
    });
</script>
</body>
</html>