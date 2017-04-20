<?php
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/configName.php');

if(strpos($_SERVER['HTTP_REFERER'], HTTP_SITE) === 0 && isset($_GET['js']) && $_GET['js'] == 'result'){
    if($_POST['url'] != ''){
        echo @file_get_contents(HTTP_SITE.'/assets/js/'.$_POST['url']);
    }
}