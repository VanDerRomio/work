<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.04.2017
 * Time: 14:59
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/settings.php');
$db = DB::getConnection();

//show/hide вертикальну рекламу
if(isset($_POST['reklama_vert'])) {
    if(Settings::getValue('reklama_vert') == '1'){
        $arrBack['error'] = (Settings::setValue('reklama_vert', '0'))?'ok':'error';
    }
    else{
        $arrBack['error'] = (Settings::setValue('reklama_vert', '1'))?'ok':'error';
    }
    die (json_encode($arrBack, true));
}

//show/hide гоотзонтальну рекламу
if(isset($_POST['reklama_gor'])) {
    if(Settings::getValue('reklama_gor') == '1'){
        $arrBack['error'] = (Settings::setValue('reklama_gor', '0'))?'ok':'error';
    }
    else{
        $arrBack['error'] = (Settings::setValue('reklama_gor', '1'))?'ok':'error';
    }
    die (json_encode($arrBack, true));
}

//завантажуємо рекламу
if(isset($_POST['load'])) {
    $arrBack['reklama_vert'] = Settings::getValue('reklama_vert');
    $arrBack['reklama_gor'] = Settings::getValue('reklama_gor');

    $result = $db->query('SELECT * FROM reklama');
    $arrBack['reklama'] = $result->fetch(PDO::FETCH_ASSOC);
    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

//зберігаємо рекламу
if(isset($_POST['gorBig']) && isset($_POST['gorMiddle']) && isset($_POST['gorSmall']) && isset($_POST['vertMiddle']) && isset($_POST['vertSmall'])){
    $gorBig = $_POST['gorBig'];
    $gorMiddle = $_POST['gorMiddle'];
    $gorSmall = $_POST['gorSmall'];

    $vertMiddle = $_POST['vertMiddle'];
    $vertSmall = $_POST['vertSmall'];

    $result = $db->prepare('UPDATE reklama '
        . 'SET gorBig=:gorBig, gorMiddle=:gorMiddle, gorSmall=:gorSmall, vertMiddle=:vertMiddle, vertSmall=:vertSmall');
    if ($result->execute(array('gorBig' => $gorBig, 'gorMiddle' => $gorMiddle, 'gorSmall' => $gorSmall, 'vertMiddle' => $vertMiddle, 'vertSmall' => $vertSmall))) {
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
else{
    $arrBack['answer'] = 'niestety nie udało się zapisać danych';
    $arrBack['error'] = 'error';
    die (json_encode($arrBack, true));
}