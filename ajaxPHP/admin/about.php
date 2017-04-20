<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.04.2017
 * Time: 14:59
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
$db = DB::getConnection();

//завантажуємо текст
if(isset($_POST['load'])) {
    $result = $db->query('SELECT text FROM about');
    $arrBack['text'] = $result->fetch(PDO::FETCH_ASSOC);
    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

//зберігаємо текст
if(isset($_POST['save'])) {
    if($_POST['save'] != ''){
        $save = $_POST['save'];//htmlentities($_POST['save'], ENT_QUOTES);
    }
    else{
        $arrBack['answer'] = 'niestety nie udało się zapisać danych';
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
$arrBack['code']=$save;
    $result = $db->prepare('UPDATE about '
        . 'SET text=:text');
    if ($result->execute(array('text' => $save))) {
        if($result->rowCount() != 0) {
            $arrBack['answer'] = 'tekst pomyślnie zapisane';
            die (json_encode($arrBack, true));
        }
        else {
            $arrBack['answer'] = 'niestety nie udało się zapisać danych';
            die (json_encode($arrBack, true));
        }
    }
    else {
        $arrBack['answer'] = 'niestety nie udało się zapisać danych';
        die (json_encode($arrBack, true));
    }
}