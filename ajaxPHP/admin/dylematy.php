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

//видаляємо дилемат
if(isset($_POST['delete'])) {
    if($_POST['delete'] != ''){
        $delete = htmlentities($_POST['delete'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare('DELETE FROM ask '
        .'WHERE id=:id');
    if($result->execute(array('id'=>$delete))){
        if($result->rowCount() != 0) {
            $arrBack['error'] = 'ok';
            die (json_encode($arrBack, true));
        }
        else{
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//privat/public дилемат
if(isset($_POST['privat'])) {
    if($_POST['privat'] != ''){
        $privat = htmlentities($_POST['privat'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT privat "
        . "FROM ask "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$privat))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['privat'];
        $result = $db->prepare('UPDATE ask '
            . 'SET privat=:privat '
            . 'WHERE id=:id');
        if ($result->execute(array('privat' => (($value=='1')?'0':'1'), 'id' => $privat))) {
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

//активовуємо дилемат
if(isset($_POST['active'])) {
    if($_POST['active'] != ''){
        $active = htmlentities($_POST['active'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT active "
        . "FROM ask "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$active))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['active'];
        $result = $db->prepare('UPDATE ask '
            . 'SET active=:active '
            . 'WHERE id=:id');
        if ($result->execute(array('active' => (($value=='1')?'0':'1'), 'id' => $active))) {
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

//зберігаємо дані дилемата після редагування
if(isset($_POST['edit_save'])) {
    if(isset($_POST['id']) && isset($_POST['kategoria']) && isset($_POST['text']) && isset($_POST['img1']) && isset($_POST['img2']) && isset($_POST['ask1']) && isset($_POST['ask2'])){
        $editArray = array(
            'id'=>htmlentities($_POST['id'], ENT_QUOTES),
            'kategoria'=>htmlentities($_POST['kategoria'], ENT_QUOTES),
            'text'=>htmlentities($_POST['text'], ENT_QUOTES),
            'img1'=>htmlentities($_POST['img1'], ENT_QUOTES),
            'img2'=>htmlentities($_POST['img2'], ENT_QUOTES),
            'ask1'=>htmlentities($_POST['ask1'], ENT_QUOTES),
            'ask2'=>htmlentities($_POST['ask2'], ENT_QUOTES),
        );
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("UPDATE ask "
        . "SET kategoria=:kategoria, text=:text, img1=:img1, img2=:img2, ask1=:ask1, ask2=:ask2 "
        . "WHERE id=:id ");

    if($result->execute(array(
        'id'=>$editArray['id'],
        'kategoria'=>$editArray['kategoria'],
        'text'=>$editArray['text'],
        'img1'=>$editArray['img1'],
        'img2'=>$editArray['img2'],
        'ask1'=>$editArray['ask1'],
        'ask2'=>$editArray['ask2'],
    ))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);

        $arrBack['error'] = 'ok';
        die (json_encode($arrBack, true));
    } else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//готовимо дані дилемата для редагування
if(isset($_POST['edit_select'])) {
    if($_POST['edit_select'] != ''){
        $edit_select = htmlentities($_POST['edit_select'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT id, kategoria, text, img1, img2, ask1, ask2 "
        . "FROM ask "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$edit_select))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        if($res['id'] != '') {
            $arrBack['dylemat'] = $res;
            $arrBack['error'] = 'ok';
            $resultK = $db->query("SELECT * "
                . "FROM menu "
                . "WHERE language='pl' "
                . "ORDER BY id ASC");
            $kateg = $resultK->fetchAll(PDO::FETCH_ASSOC);
            $arrBack['kategoria'] = $kateg;
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

//виводимо усі дилемати
if(isset($_POST['kategoria'])) {
    if($_POST['kategoria'] != ''){
        $kategoria = htmlentities($_POST['kategoria'], ENT_QUOTES);
    }
    else{
        $kategoria = '';
    }
}
else{
    $kategoria = '';
}
if(isset($_POST['nextPage'])){
    if($_POST['nextPage'] != ''){
        $nextPage = intval(htmlentities($_POST['nextPage'], ENT_QUOTES));
        if($nextPage > 0)
            $nextPage = $nextPage * 10;
    }
    else{
        $nextPage = 0;
    }
}
else{
    $nextPage = 0;
}

$nextPageMax = 10;

$arrBack = array();
//кількість всіх дилематів
$result = $db->query("SELECT id "
    . "FROM ask ");
$arrBack['count_all'] = $result->rowCount();
//кількість сьогодні доданих дилематів
$result = $db->query('SELECT id '
    . 'FROM ask '
    . 'WHERE DATE(date)=DATE(NOW())');
$arrBack['count_now'] = $result->rowCount();
//кількість активованих дилематів
$result = $db->query("SELECT id "
    . "FROM ask "
    . "WHERE active=1");
$arrBack['count_active'] = $result->rowCount();
//кількість приватних дилематів
$result = $db->query("SELECT id "
    . "FROM ask "
    . "WHERE privat=1");
$arrBack['count_privat'] = $result->rowCount();

$resultK = $db->query("SELECT * "
    . "FROM menu "
    . "WHERE language='pl' "
    . "ORDER BY id ASC");
$kateg = $resultK->fetchAll(PDO::FETCH_ASSOC);
$arrBack['kategoria'] = $kateg;
$arrBack['count_kategoria'] = array();


$result = $db->query("SELECT kategoria "
    . "FROM ask ");
$kategDyl = $result->fetchAll(PDO::FETCH_ASSOC);
foreach ($kategDyl as $value_kat) {
    foreach ($arrBack['kategoria'] as $value) {
        if($value_kat['kategoria'] == $value['id']){
            $arrBack['count_kategoria'][$value['kategoria']]++;
        }
    }
}

//додані дилемати
$result = $db->prepare("SELECT * "
    . "FROM ask "
    . "ORDER BY date DESC "
    . "LIMIT ?,?");

$result->bindValue(1, $nextPage, PDO::PARAM_INT);
$result->bindValue(2, $nextPageMax, PDO::PARAM_INT);

if ($result->execute()) {
    $resultDylemat = $result->fetchAll(PDO::FETCH_ASSOC);
    $arrBack['page'] = $nextPage/10;
    $arrBack['dylemats'] = $resultDylemat;
}
else {
    $arrBack['error'] = 'error';
}

echo (json_encode($arrBack, true));