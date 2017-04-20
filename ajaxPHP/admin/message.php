<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 24.03.2017
 * Time: 20:42
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/MailTo.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/configName.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/settings.php');

$db = DB::getConnection();

//видаляємо повідомлення
if(isset($_POST['delete'])) {
    if($_POST['delete'] != ''){
        $delete = htmlentities($_POST['delete'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare('DELETE FROM contactAsk '
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

//змінюємо статус користувача: user/admin
if(isset($_POST['admin'])) {
    if($_POST['admin'] != ''){
        $admin = htmlentities($_POST['admin'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT admin "
        . "FROM users "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$admin))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['admin'];
        $result = $db->prepare('UPDATE users '
            . 'SET admin=:admin '
            . 'WHERE id=:id');
        if ($result->execute(array('admin' => (($value=='1')?'0':'1'), 'id' => $admin))) {
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

//зберігаємо дані користувача після редагування
if(isset($_POST['edit_save'])) {
    if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['age'])
        && isset($_POST['gender']) && isset($_POST['locale']) && isset($_POST['city']) && isset($_POST['link_social']) && isset($_POST['verified']) && isset($_POST['image'])){
        $editArray = array(
            'id'=>htmlentities($_POST['id'], ENT_QUOTES),
            'name'=>htmlentities($_POST['name'], ENT_QUOTES),
            'email'=>htmlentities($_POST['email'], ENT_QUOTES),
            'firstName'=>htmlentities($_POST['firstName'], ENT_QUOTES),
            'lastName'=>htmlentities($_POST['lastName'], ENT_QUOTES),
            'age'=>htmlentities($_POST['age'], ENT_QUOTES),
            'gender'=>htmlentities($_POST['gender'], ENT_QUOTES),
            'locale'=>htmlentities($_POST['locale'], ENT_QUOTES),
            'city'=>htmlentities($_POST['city'], ENT_QUOTES),
            'link_social'=>htmlentities($_POST['link_social'], ENT_QUOTES),
            'verified'=>htmlentities($_POST['verified'], ENT_QUOTES),
            'image'=>htmlentities($_POST['image'], ENT_QUOTES),
        );
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("UPDATE users "
        . "SET name=:name, email=:email, firstName=:firstName, lastName=:lastName, age=:age, gender=:gender, locale=:locale, city=:city, "
        . "link_social=:link_social, verified=:verified, image=:image "
        . "WHERE id=:id ");

    if($result->execute(array(
        'id'=>$editArray['id'],
        'name'=>$editArray['name'],
        'email'=>$editArray['email'],
        'firstName'=>$editArray['firstName'],
        'lastName'=>$editArray['lastName'],
        'age'=>$editArray['age'],
        'gender'=>$editArray['gender'],
        'locale'=>$editArray['locale'],
        'city'=>$editArray['city'],
        'link_social'=>$editArray['link_social'],
        'verified'=>$editArray['verified'],
        'image'=>$editArray['image']))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);

        $arrBack['error'] = 'ok';
        die (json_encode($arrBack, true));
    } else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }
}

//готовимо дані конкретного повідомлення
if(isset($_POST['select'])) {
    if($_POST['select'] != ''){
        $select = htmlentities($_POST['select'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    //змінюємо статус повіломлення на "прочитано"
    $result = $db->prepare('UPDATE contactAsk '
        . 'SET show_email=1 '
        . 'WHERE id=:id');
    $result->execute(array('id' => $select));

    //дістаємо саме повідомлення
    $result = $db->prepare("SELECT * "
        . "FROM contactAsk "
        . "WHERE id=:id ");
    if($result->execute(array('id'=>$select))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        if($res['id'] != '') {
            $arrBack['message'] = $res;
            $arrBack['error'] = 'ok';
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

    //дістаємо попередні повідомлення користувача і адміністрації
    $result = $db->prepare("SELECT * "
        . "FROM contactAsk "
        . "WHERE email=:email "
        . "ORDER BY date DESC");
    if($result->execute(array('email'=>$arrBack['message']['email']))) {
        $res = $result->fetchAll(PDO::FETCH_ASSOC);
        $arrBack['history'] = $res;
        $arrBack['error'] = 'ok';
    }
    else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    die (json_encode($arrBack, true));
}

//готовимо для нового конкретного повідомлення для користувача
if(isset($_POST['selectNew'])) {
    if($_POST['selectNew'] != ''){
        $select = htmlentities($_POST['selectNew'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    //дістаємо попередні повідомлення користувача і адміністрації
    $resultU = $db->prepare("SELECT email "
        . "FROM users "
        . "WHERE id=:id ");
    if($resultU->execute(array('id'=>$select))) {
        $res = $resultU->fetch(PDO::FETCH_ASSOC);
        if($res['email'] != '') {
            $arrBack['message']['id'] = 'no';
            $arrBack['message']['id_user'] = $select;
            $arrBack['message']['email'] = $res['email'];

            $result = $db->prepare("SELECT * "
                . "FROM contactAsk "
                . "WHERE email=:email "
                . "ORDER BY date DESC");
            if ($result->execute(array('email' => $res['email']))) {
                $res = $result->fetchAll(PDO::FETCH_ASSOC);

                $arrBack['history'] = $res;
            }
            $arrBack['error'] = 'ok';
        }
        else {
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }
    }
    else {
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    die (json_encode($arrBack, true));
}

//відправляємо повідомлення користувачу
if(isset($_POST['send_message'])) {
    if(isset($_POST['email']) && isset($_POST['thema']) && isset($_POST['text']) && isset($_POST['id_user']) && isset($_POST['id'])) {
        if ($_POST['email'] != '' && $_POST['thema'] != '' && $_POST['text'] != '' &&  $_POST['id_user'] != '' &&  $_POST['id'] != '') {
            $email = htmlentities($_POST['email'], ENT_QUOTES);
            $thema_message = htmlentities($_POST['thema'], ENT_QUOTES);
            $message = htmlentities($_POST['text'], ENT_QUOTES);
            $id_user = htmlentities($_POST['id_user'], ENT_QUOTES);
            $id = htmlentities($_POST['id'], ENT_QUOTES);
        } else {
            $arrBack['error'] = 'error';
            die (json_encode($arrBack, true));
        }

        $result = $db->prepare("SELECT name "
            . "FROM users "
            . "WHERE id=:id ");
        if($result->execute(array('id'=>$id_user))) {
            $res = $result->fetch(PDO::FETCH_ASSOC);
            $userName = $res['name'];
        }
        else {
            $userName = '';
        }

        $nameFind = array("siteName", "httpSiteName", "nameUser", "insertThema");
        $nameReplace = array(HTTP_SITE_NAME, HTTP_SITE, $userName, $thema_message);
        $message_send = str_replace($nameFind, $nameReplace, Settings::getValue('textSendMail'));

        $from = 'Roma <' . EMAIL . '>';
        $thema_email = 'Email from Administration ' . HTTP_SITE . '!';
        if (MailTo::sendMail($email, $thema_email, $message_send, $from)) {
            $mailSend = '1';
        } else {
            $mailSend = '0';
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $resultInsert = $db->prepare('INSERT INTO contactAsk (id_user, send_admin, name, email, thema, text, ip) '
            .' VALUES (:id_user, :send_admin, :name, :email, :thema, :text, :ip)');

        $resultInsert->execute(array(
            'id_user'=>$id_user,
            'send_admin'=>1,
            'name'=>'Administrator',
            'email'=>$email,
            'thema'=>$thema_message,
            'text'=>$message,
            'ip'=>$ip
        ));

        $arrBack['error'] = 'ok';
        if($id != 'no') {
            $arrBack['id'] = $id;
        }
        else{
            $arrBack['id'] = $db->lastInsertId();
        }
        die (json_encode($arrBack, true));
    }
    else{
        $arrBack['error'] = 'empty';
        die (json_encode($arrBack, true));
    }
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
$countRow = 0;
$arrBack = array();

//кількість всіх повідомлень
$result = $db->query("SELECT id "
    . "FROM contactAsk ");
$arrBack['count_all'] = $result->rowCount();

//остатні додані повідомлення
$result = $db->prepare("SELECT * "
    . "FROM contactAsk "
    . "ORDER BY date DESC "
    . "LIMIT ?,?");

$result->bindValue(1, $nextPage, PDO::PARAM_INT);
$result->bindValue(2, $nextPageMax, PDO::PARAM_INT);

if ($result->execute()) {
    $resultUsers = $result->fetchAll(PDO::FETCH_ASSOC);
    $arrBack['messages'] = $resultUsers;
    $arrBack['page'] = $nextPage/10;
}
else {
    $arrBack['error'] = 'error';
}

echo (json_encode($arrBack, true));