<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.12.2016
 * Time: 16:59
 */

class IndexPage
{
	/**виводимо информацію про активність користувача на сайті
	 *
	 * @return array|mixed
	 */
	public static function getInfoList()
	{
		$returnArray = array();
		
		if(isset($_SESSION['active_user'])) {
			$db = DB::getConnection();

			//кількість оцінених дилематів
			$resultAsk = $db->prepare('SELECT id '
			. 'FROM userAsk '
			. 'WHERE id_user=:id_user');
			if($resultAsk->execute(array('id_user'=>$_SESSION['active_user']['id']))) {
				$result1Ask = $resultAsk->fetchAll(PDO::FETCH_ASSOC);

				$arrBackAsk['countAsk'] = $resultAsk->rowCount();
				$arrBackAsk['ask'] = $result1Ask;

				$arrBackAsk['endAsk'] = Settings::returnEnd($arrBackAsk['countAsk']);
			}
			else
			{
				$arrBackAsk['error'] = 'errorBD';
			}
			$returnArray['ask'] = $arrBackAsk;

			//кількість доданих дилематів
			$resultAdd = $db->prepare('SELECT id '
			. 'FROM ask '
			. 'WHERE id_user=:id_user');
			if($resultAdd->execute(array('id_user'=>$_SESSION['active_user']['id']))) {
				$result1Add = $resultAdd->fetchAll(PDO::FETCH_ASSOC);

				$arrBackAdd['countAdd'] = $resultAdd->rowCount();
				$arrBackAdd['add'] = $result1Add;

				$arrBackAdd['endAdd'] = Settings::returnEnd($arrBackAdd['countAdd']);
			}
			else
			{
				$arrBackAdd['error'] = 'errorBD';
			}
			$returnArray['add'] = $arrBackAdd;
		}
		else{
			$cookie = self::getCookieList();
			if(isset($cookie['email'])){
				$returnArray['cookie']['email'] = $cookie['email'];
				if(isset($cookie['pass']))
					$returnArray['cookie']['pass'] = $cookie['pass'];
				if(isset($cookie['checked']))
					$returnArray['cookie']['checked'] = $cookie['checked'];
			}
		}

		return $returnArray;
	}
	
	/**читаємо куки, якщо води є збереженні
	 * 
	 * @return array
	 */
	public static function getCookieList(){
		$Cookie = array();
		$returnArray = array();
		//перевіряємо чи є збереженні куки, якщо є, то пидаємо
		if(isset($_COOKIE['email'])){
			$Cookie['email'] = $_COOKIE['email'];
			$Cookie['checked'] = '1';

			if(isset($_COOKIE['pass'])){
				//перетворюємо пароль
				$newPassCookie = $_COOKIE['pass'];
				$id1 = substr($newPassCookie, 0, 12);									// id1 = перші 12 символів
				$id2 = substr($newPassCookie, 12, strlen($newPassCookie));				// id2 = решта символів

				$id2 = strrev($id2);													// id2 = реверс строки

				$newPassCookie = $id1.$id2;												// обєднуємо дві строки
				$Cookie['pass'] = $newPassCookie;
			}
			
		}
		
		return $Cookie;
	}

	//**********************************************
	//реєстрація проста
	//**********************************************
	public static function registerEasy()
	{
		header("Content-Type: application/json; charset=UTF-8");
	}
}