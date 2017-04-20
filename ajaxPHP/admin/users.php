<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 24.03.2017
 * Time: 20:42
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
$db = DB::getConnection();

//видаляємо всіх користувачів, які не підтвердили свою електронну пошту
if(isset($_POST['delete_user_no_active'])) {
    $result = $db->query('DELETE FROM users '
        .'WHERE date_end_link<NOW() AND active=0 AND admin=0');

    $arrBack['user'] = $result->fetchAll(PDO::FETCH_ASSOC);
    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}

//видаляємо користувача
if(isset($_POST['delete'])) {
    if($_POST['delete'] != ''){
        $delete = htmlentities($_POST['delete'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare('DELETE FROM users '
        .'WHERE id=:id AND admin=0');
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

//блокуємо користувача
if(isset($_POST['block'])) {
    if($_POST['block'] != ''){
        $block = htmlentities($_POST['block'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT block "
        . "FROM users "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$block))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['block'];
        $result = $db->prepare('UPDATE users '
            . 'SET block=:block '
            . 'WHERE id=:id');
        if ($result->execute(array('block' => (($value=='1')?'0':'1'), 'id' => $block))) {
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

//активовуємо користувача
if(isset($_POST['active'])) {
    if($_POST['active'] != ''){
        $active = htmlentities($_POST['active'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT active "
        . "FROM users "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$active))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        $value = $res['active'];
        $result = $db->prepare('UPDATE users '
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

//готовимо дані користувача для редагування
if(isset($_POST['edit_select'])) {
    if($_POST['edit_select'] != ''){
        $edit_select = htmlentities($_POST['edit_select'], ENT_QUOTES);
    }
    else{
        $arrBack['error'] = 'error';
        die (json_encode($arrBack, true));
    }

    $result = $db->prepare("SELECT id, name, email, firstName, lastName, age, gender, locale, city, link_social, verified, image "
        . "FROM users "
        . "WHERE id=:id ");

    if($result->execute(array('id'=>$edit_select))) {
        $res = $result->fetch(PDO::FETCH_ASSOC);
        if($res['id'] != '') {
            $arrBack['user'] = $res;
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

//виводимо усіх користувачів
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
//кількість всіх користувачів
$result = $db->query("SELECT id "
    . "FROM users ");
$arrBack['count_all'] = $result->rowCount();
//кількість сьогодні зареєстрованих користувачів
$result = $db->query('SELECT id '
    . 'FROM users '
    . 'WHERE DATE(date_login)=DATE(NOW())');
$arrBack['count_now_reg'] = $result->rowCount();
//кількість користувачів, які сьогодні заходили
$result = $db->query('SELECT id '
    . 'FROM users '
    . 'WHERE DATE(date_in_site)=DATE(NOW())');
$arrBack['count_now'] = $result->rowCount();
//кількість активованих користувачів
$result = $db->query("SELECT id "
    . "FROM users "
    . "WHERE active=1");
$arrBack['count_active'] = $result->rowCount();
//кількість заблокованих користувачів
$result = $db->query("SELECT id "
    . "FROM users "
    . "WHERE block=1");
$arrBack['count_block'] = $result->rowCount();
//кількість admin користувачів
$result = $db->query("SELECT id "
    . "FROM users "
    . "WHERE admin=1");
$arrBack['count_admin'] = $result->rowCount();

//додані дилемати
$result = $db->prepare("SELECT * "
    . "FROM users "
    . "ORDER BY date_login DESC "
    . "LIMIT ?,?");

$result->bindValue(1, $nextPage, PDO::PARAM_INT);
$result->bindValue(2, $nextPageMax, PDO::PARAM_INT);

if ($result->execute()) {
    $resultUsers = $result->fetchAll(PDO::FETCH_ASSOC);
    $arrBack['page'] = $nextPage/10;
    $arrBack['users'] = $resultUsers;
    $arrBack['count'] = $result->rowCount();
    $arrBack['add_dylemat']=0;
    $arrBack['click_dylemat']=0;
    $con = 0;
    foreach ($arrBack['users'] as $user){
        $result = $db->prepare("SELECT id "
            . "FROM ask "
            . "WHERE id_user=:id_user ");

        $result->execute(array('id_user'=>$user['id']));
        $arrBack['users'][$con]['add_dylemat'] = $result->rowCount();

        $result = $db->prepare("SELECT id "
            . "FROM userAsk "
            . "WHERE id_user=:id_user ");

        $result->execute(array('id_user'=>$user['id']));
        $arrBack['users'][$con]['click_dylemat'] = $result->rowCount();
        $con++;
    }
}
else {
    $arrBack['error'] = 'error';
}

echo (json_encode($arrBack, true));