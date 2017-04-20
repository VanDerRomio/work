<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 08.04.2017
 * Time: 15:31
 */
date_default_timezone_set('Europe/Warsaw');
require_once($_SERVER['DOCUMENT_ROOT'] . '/components/DB.php');
$db = DB::getConnection();
$returnArray = array();

//завантажуємо текст
if(isset($_POST['load'])) {
    //сьогодні зареєстровано
    $result = $db->query('SELECT id '
        . 'FROM users '
        . 'WHERE DATE(date_login)=DATE(NOW())');
    $arrBack['count_now_reg'] = $result->rowCount();
    //сьогодні заходило
    $result = $db->query('SELECT id '
        . 'FROM users '
        . 'WHERE DATE(date_in_site)=DATE(NOW())');
    $arrBack['count_now'] = $result->rowCount(); 
    //сьогодні додано дилематів
    $result = $db->query('SELECT id '
        . 'FROM ask '
        . 'WHERE DATE(date)=DATE(NOW())');
    $arrBack['count_now_dylem'] = $result->rowCount();

    //рахуємо кількість користувачів за кожен день протягом місяця
    $arrBack['count_user_mount'] = 0;
    $arrBack['countDays'] = date("t", mktime(0, 0, 0, date("n"), 1, date("Y")));

    $result = $db->prepare('SELECT * '
        . 'FROM counter '
        . 'WHERE DATE(date)=DATE(:date)');
    $date_deys_user = array();
    $more_user = array();
    for ($i = 0; $i < $arrBack['countDays']; $i++) {
        $getDate = date("Y-m-d", mktime(0, 0, 0, date("m"), $i + 1, date("Y")));

        if($result->execute(array('date'=>$getDate))) {
            $date_deys_user[$i + 1] = $result->rowCount();

            $var_result = $result->fetchAll(PDO::FETCH_ASSOC);
            if($result->rowCount() != 0){
                $more_user[$i + 1] = $var_result;
            }
        }

        //загальна кількість користувачів, які відвідали сайт цього місяця
        $arrBack['count_user_mount'] += $result->rowCount();
    }

    $arrBack['count_max'] = max($date_deys_user);
    $arrBack['countUser'] = $date_deys_user;
    $arrBack['more_user'] = $more_user;
    $arrBack['mount'] = date("F");

    //рахуємо кількість дилем за кожен день протягом місяця
    $arrBack['count_dylem_mount'] = 0;

    $result = $db->prepare('SELECT id '
        . 'FROM ask '
        . 'WHERE DATE(date)=DATE(:date)');
    $date_deys_dylem = array();
    for ($i = 0; $i < $arrBack['countDays']; $i++) {
        $getDate = date("Y-m-d", mktime(0, 0, 0, date("m"), $i + 1, date("Y")));

        if($result->execute(array('date'=>$getDate))) {
            $date_deys_dylem[$i + 1] = $result->rowCount();
        }

        //загальна кількість дилем, які додали цього місяця
        $arrBack['count_dylem_mount'] += $result->rowCount();
    }

    $arrBack['count_max_dylem'] = max($date_deys_dylem);
    $arrBack['countDylem'] = $date_deys_dylem;

    $arrBack['error'] = 'ok';
    die (json_encode($arrBack, true));
}