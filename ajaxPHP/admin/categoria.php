<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 24.03.2017
 * Time: 20:43
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
$db = DB::getConnection();

//видаляємо категорію
if(isset($_POST['delete'])) {
    if($_POST['delete'] != ''){
        $delete = htmlentities($_POST['delete'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $arrBack = array();
    $language = array('pl', 'en', 'ru', 'ua');
    //видаляємо в pl
    $result = $db->prepare("DELETE FROM menu "
        . "WHERE sort_id=:sort_id AND language=:language");

    foreach ($language as $lang_value) {
        if ($result->execute(array('sort_id' => $delete, 'language' => $lang_value))) {
            if ($result->rowCount() != 0) {
                $arrBack['answer'] .= "usunięto w \"$lang_value\"\n";
            } else {
                $arrBack['answer'] .= "nie usunięto w \"$lang_value\"\n";
            }
        } else {
            $arrBack['answer'] .= "nie usunięto w \"$lang_value\"\n";
        }
    }

    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

//show/hide категорію
if(isset($_POST['visible'])) {
    if($_POST['visible'] != ''){
        $visible = htmlentities($_POST['visible'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT visible "
        . "FROM menu "
        . "WHERE sort_id=:sort_id "
        . "LIMIT 1");

    if($result->execute(array('sort_id'=>$visible))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['visible'];
        $result = $db->prepare('UPDATE menu '
            . 'SET visible=:visible '
            . 'WHERE sort_id=:sort_id');
        if ($result->execute(array('visible' => (($value=='1')?'0':'1'), 'sort_id' => $visible))) {
            $arrBack['error'] = 'ok';
            die (json_encode($arrBack, true));
        } else {
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//up категорію
if(isset($_POST['up'])) {
    if($_POST['up'] != ''){
        $up = intval(htmlentities($_POST['up'], ENT_QUOTES));
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare('UPDATE menu '
        . 'SET sort_id=:val '
        . 'WHERE sort_id=:sort_id');
    if ($result->execute(array('val' => (-1*$up), 'sort_id' => $up))) {
        $result1 = $db->prepare('UPDATE menu '
            . 'SET sort_id=:val '
            . 'WHERE sort_id=:sort_id');
        if ($result1->execute(array('val' => ($up), 'sort_id' => ($up-1)))) {
            $result2 = $db->prepare('UPDATE menu '
                . 'SET sort_id=:val '
                . 'WHERE sort_id=:sort_id');
            if ($result2->execute(array('val' => ($up-1), 'sort_id' => (-1*$up)))) {
                $arrBack['error'] = 'ok';
                die (json_encode($arrBack, true));
            } else {
                $arrBack['error'] = 'error';
                die (json_encode($arrBack, true));
            }
        } else {
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    } else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//up категорію
if(isset($_POST['down'])) {
    if($_POST['down'] != ''){
        $down = intval(htmlentities($_POST['down'], ENT_QUOTES));
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    //кількість всіх пунктів категорій
    $result = $db->query("SELECT DISTINCT sort_id "
        . "FROM menu "
        . "ORDER BY sort_id DESC "
        . "LIMIT 1");
    $maxID = $result->fetch(PDO::FETCH_ASSOC);

    if($maxID['sort_id'] == $down){
        $arrBack['error'] = 'ok';
        die (json_encode($arrBack, true));
    }
    else {
        $result = $db->prepare('UPDATE menu '
            . 'SET sort_id=:val '
            . 'WHERE sort_id=:sort_id');
        if ($result->execute(array('val' => (-1 * $down), 'sort_id' => $down))) {
            $result1 = $db->prepare('UPDATE menu '
                . 'SET sort_id=:val '
                . 'WHERE sort_id=:sort_id');
            if ($result1->execute(array('val' => ($down), 'sort_id' => ($down + 1)))) {
                $result2 = $db->prepare('UPDATE menu '
                    . 'SET sort_id=:val '
                    . 'WHERE sort_id=:sort_id');
                if ($result2->execute(array('val' => ($down + 1), 'sort_id' => (-1 * $down)))) {
                    $arrBack['error'] = 'ok';
                    die (json_encode($arrBack, true));
                } else {
                    $arrBack['error'] = 'error';
                    die (json_encode($arrBack, true));
                }
            } else {
                $arrBack['error'] = 'error';
                die (json_encode($arrBack, true));
            }
        } else {
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    }
}

//зберігаємо дані категорії після редагування
if(isset($_POST['edit_save'])) {
    if(isset($_POST['id']) && isset($_POST['sort_id']) && isset($_POST['lang1']) && isset($_POST['lang2']) && isset($_POST['lang3']) && isset($_POST['lang4'])){
        $editArray = array(
            'id'=>intval(htmlentities($_POST['id'], ENT_QUOTES)),
            'sort_id'=>intval(htmlentities($_POST['sort_id'], ENT_QUOTES)),
            'lang1'=>htmlentities($_POST['lang1'], ENT_QUOTES),
            'lang2'=>htmlentities($_POST['lang2'], ENT_QUOTES),
            'lang3'=>htmlentities($_POST['lang3'], ENT_QUOTES),
            'lang4'=>htmlentities($_POST['lang4'], ENT_QUOTES),
        );
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $arrBack['answer'] = '';

    //обновляємо sort_id в language=pl
    $result = $db->prepare("UPDATE menu "
        . "SET sort_id=:sort_id "
        . "WHERE id=:id AND language='pl'");
    if($result->execute(array('sort_id'=>$editArray['sort_id'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"sort_id" zapisany w "pl"'."\n";
    }
    else {
        $arrBack['answer'] .= '"sort_id" nie zapisany w "pl"'."\n";
    }

    //обновляємо sort_id в language=en
    $result = $db->prepare("UPDATE menu "
        . "SET sort_id=:sort_id "
        . "WHERE id=:id AND language='en'");
    if($result->execute(array('sort_id'=>$editArray['sort_id'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"sort_id" zapisany w "en"'."\n";
    }
    else {
        $arrBack['answer'] .= '"sort_id" nie zapisany w "en"'."\n";
    }

    //обновляємо sort_id в language=ru
    $result = $db->prepare("UPDATE menu "
        . "SET sort_id=:sort_id "
        . "WHERE id=:id AND language='ru'");
    if($result->execute(array('sort_id'=>$editArray['sort_id'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"sort_id" zapisany w "ru"'."\n";
    }
    else {
        $arrBack['answer'] .= '"sort_id" nie zapisany w "ru"'."\n";
    }

    //обновляємо sort_id в language=ua
    $result = $db->prepare("UPDATE menu "
        . "SET sort_id=:sort_id "
        . "WHERE id=:id AND language='ua'");
    if($result->execute(array('sort_id'=>$editArray['sort_id'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"sort_id" zapisany w "ua"'."\n";
    }
    else {
        $arrBack['answer'] .= '"sort_id" nie zapisany w "ua"'."\n";
    }

    //-----------------------------------------------------------------------------------------
    $arrBack['answer'] .= "\n";
    //обновляємо kategoria в language=pl і id
    $result = $db->prepare("UPDATE menu "
        . "SET kategoria=:kategoria "
        . "WHERE id=:id AND language='pl'");
    if($result->execute(array('kategoria'=>$editArray['lang1'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"'.$editArray['lang1'].'" zapisany w "pl"'."\n";
    }
    else {
        $arrBack['answer'] .= '"'.$editArray['lang1'].'" nie zapisany w "pl"'."\n";
    }

    //обновляємо kategoria в language=en і id
    $result = $db->prepare("UPDATE menu "
        . "SET kategoria=:kategoria "
        . "WHERE id=:id AND language='en'");
    if($result->execute(array('kategoria'=>$editArray['lang2'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"'.$editArray['lang2'].'" zapisany w "en"'."\n";
    }
    else {
        $arrBack['answer'] .= '"'.$editArray['lang2'].'" nie zapisany w "en"'."\n";
    }

    //обновляємо kategoria в language=ru і id
    $result = $db->prepare("UPDATE menu "
        . "SET kategoria=:kategoria "
        . "WHERE id=:id AND language='ru'");
    if($result->execute(array('kategoria'=>$editArray['lang3'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"'.$editArray['lang3'].'" zapisany w "ru"'."\n";
    }
    else {
        $arrBack['answer'] .= '"'.$editArray['lang3'].'" nie zapisany w "ru"'."\n";
    }

    //обновляємо kategoria в language=ua і id
    $result = $db->prepare("UPDATE menu "
        . "SET kategoria=:kategoria "
        . "WHERE id=:id AND language='ua'");
    if($result->execute(array('kategoria'=>$editArray['lang4'], 'id'=>$editArray['id']))) {
        $arrBack['answer'] .= '"'.$editArray['lang4'].'" zapisany w "ua"'."\n";
    }
    else {
        $arrBack['answer'] .= '"'.$editArray['lang4'].'" nie zapisany w "ua"'."\n";
    }


    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

//готовимо дані категорії для редагування
if(isset($_POST['edit_select'])) {
    if($_POST['edit_select'] != ''){
        $edit_select = htmlentities($_POST['edit_select'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT * "
        . "FROM menu "
        . "WHERE sort_id=:sort_id "
        . "ORDER BY language ASC "
        . "LIMIT 10");

    if($result->execute(array('sort_id'=>$edit_select))) {
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        if($res[0]['id'] != '') {
            $arrBack['kategoria'] = $res;
            $arrBack['error'] = 'ok';
            die (json_encode($arrBack, true));
        }
        else{
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    }
    else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//додаємо категорію
if(isset($_POST['add_kategor'])) {
    if(isset($_POST['pl']) && isset($_POST['en']) && isset($_POST['ru']) && isset($_POST['ua'])){
        $addArray = array(
            'pl'=>htmlentities($_POST['pl'], ENT_QUOTES),
            'en'=>htmlentities($_POST['en'], ENT_QUOTES),
            'ru'=>htmlentities($_POST['ru'], ENT_QUOTES),
            'ua'=>htmlentities($_POST['ua'], ENT_QUOTES),
        );
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $arrBack['answer'] = '';

    //дізнаємося максимальний id
    $result = $db->query("SELECT id "
        . "FROM menu "
        . "ORDER BY id DESC "
        . "LIMIT 1");
    $maxID = $result->fetch(PDO::FETCH_ASSOC);

    //додаємо kategoria з language=pl, sort_id і id
    $resultInsert = $db->prepare('INSERT INTO menu (id, sort_id, kategoria, language) '
        .' VALUES (:id, :sort_id, :kategoria, :language)');
    if($resultInsert->execute(array(
        'id'=>intval($maxID['id']) + 1,
        'sort_id'=>intval($maxID['id']) + 1,
        'kategoria'=>$addArray['pl'],
        'language'=>@'pl',
    ))){
        $arrBack['answer'] .= '"'.$addArray['pl'].'" dodano w język "pl"'."\n";
    }
    else{
        $arrBack['answer'] .= '"'.$addArray['pl'].'" nie dodano w język "pl"'."\n";
    }

    //додаємо kategoria з language=en, sort_id і id
    $resultInsert = $db->prepare('INSERT INTO menu (id, sort_id, kategoria, language) '
        .' VALUES (:id, :sort_id, :kategoria, :language)');
    if($resultInsert->execute(array(
        'id'=>intval($maxID['id']) + 1,
        'sort_id'=>intval($maxID['id']) + 1,
        'kategoria'=>$addArray['en'],
        'language'=>@'en',
    ))){
        $arrBack['answer'] .= '"'.$addArray['en'].'" dodano w język "en"'."\n";
    }
    else{
        $arrBack['answer'] .= '"'.$addArray['en'].'" nie dodano w język "en"'."\n";
    }

    //додаємо kategoria з language=ru, sort_id і id
    $resultInsert = $db->prepare('INSERT INTO menu (id, sort_id, kategoria, language) '
        .' VALUES (:id, :sort_id, :kategoria, :language)');
    if($resultInsert->execute(array(
        'id'=>intval($maxID['id']) + 1,
        'sort_id'=>intval($maxID['id']) + 1,
        'kategoria'=>$addArray['ru'],
        'language'=>@'ru',
    ))){
        $arrBack['answer'] .= '"'.$addArray['ru'].'" dodano w język "ru"'."\n";
    }
    else{
        $arrBack['answer'] .= '"'.$addArray['ru'].'" nie dodano w język "ru"'."\n";
    }

    //додаємо kategoria з language=ua, sort_id і id
    $resultInsert = $db->prepare('INSERT INTO menu (id, sort_id, kategoria, language) '
        .' VALUES (:id, :sort_id, :kategoria, :language)');
    if($resultInsert->execute(array(
        'id'=>intval($maxID['id']) + 1,
        'sort_id'=>intval($maxID['id']) + 1,
        'kategoria'=>$addArray['ua'],
        'language'=>@'ua',
    ))){
        $arrBack['answer'] .= '"'.$addArray['ua'].'" dodano w język "ua"'."\n";
    }
    else{
        $arrBack['answer'] .= '"'.$addArray['ua'].'" nie dodano w język "ua"'."\n";
    }

    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

$arrBack = array();
//кількість всіх пунктів категорій
$result = $db->query("SELECT DISTINCT id "
    . "FROM menu "
    . "ORDER BY sort_id ASC");
$arrBack['count_all'] = $result->rowCount();
$kategID = $result->fetchAll();

//рахуємо кількість дилематів в кожній категорії
$result = $db->query("SELECT kategoria "
    . "FROM ask ");
$kategDyl = $result->fetchAll(PDO::FETCH_ASSOC);
$temp = array();
$arrBack['info'] = array();

foreach ($kategID as $value) {
    foreach ($kategDyl as $value_kat) {
        if($value['id'] == $value_kat['kategoria']){
            $temp[$value['id']]++;
        }
    }
}

$result = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='pl' "
    . "ORDER BY sort_id ASC ");
$name_kateg = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($name_kateg as $name){
    foreach ($temp as $key=>$value){
        if($name['id'] == $key){
            $arrBack['info'][$name['kategoria']] = $value;
            break;
        }
        else
            $arrBack['info'][$name['kategoria']] = 0;
    }
}

//кількість всіх активних пунктів категорій
$result = $db->query("SELECT DISTINCT id "
    . "FROM menu "
    . "WHERE visible=1 ");
$arrBack['count_visible'] = $result->rowCount();

//групуємо категоріїї по мовам
$resultK = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='pl' "
    . "ORDER BY sort_id ASC");
$arrBack['pl'] = $resultK->fetchAll(PDO::FETCH_ASSOC);
$resultK = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='en' "
    . "ORDER BY sort_id ASC");
$arrBack['en'] = $resultK->fetchAll(PDO::FETCH_ASSOC);
$resultK = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='ru' "
    . "ORDER BY sort_id ASC");
$arrBack['ru'] = $resultK->fetchAll(PDO::FETCH_ASSOC);
$resultK = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='ua' "
    . "ORDER BY sort_id ASC");
$arrBack['ua'] = $resultK->fetchAll(PDO::FETCH_ASSOC);

echo (json_encode($arrBack, true));