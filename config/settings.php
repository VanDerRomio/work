<?php
class Settings
{
	public static function getValue($key)
	{
		$db = DB::getConnection();
		//запит до БД
		$result = $db->prepare('SELECT _value '
			.'FROM settings '
			.'WHERE _key=? '
			.'LIMIT 1');
		$result->setFetchMode(PDO::FETCH_ASSOC);

		if($result->execute(array($key,)))
		{
			$value = $result->fetch();
			return $value['_value'];
		}
		else
		{
			return false;
		}
	}

	public static function setValue($key, $value)
	{
		$db = DB::getConnection();
		//запит до БД
		$resultUpdate = $db->prepare('UPDATE settings SET _value=:value WHERE _key=:key');

		$resultUpdate->execute(array(
			'value'=>$value,
			'key'=>$key,));

		if($resultUpdate)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//визначаємо закінчення слова "дилемат"
	public static function returnEnd($end){
		$endAdd = array();
		if($end > 10){
			$end = substr(count($end) - 1, 1);
		}
		switch ($end){
			case '0':
			case '5':
			case '6':
			case '7':
			case '8':
			case '9':
				$endAdd['pl'] = 'dylematów';
				$endAdd['en'] = 'dilemmas';
				$endAdd['ru'] = 'дилемм';
				$endAdd['ua'] = 'дилем';
				break;
			case '1':
				$endAdd['pl'] = 'dylemat';
				$endAdd['en'] = 'dilemma';
				$endAdd['ru'] = 'дилемму';
				$endAdd['ua'] = 'дилему';
				break;
			case '2':
			case '3':
			case '4':
				$endAdd['pl'] = 'dylematy';
				$endAdd['en'] = 'dilemma';
				$endAdd['ru'] = 'дилеммы';
				$endAdd['ua'] = 'дилеми';
				break;
		}
		return $endAdd;
	}

	public static function getTextPage($page, $lang='')
	{
		if($lang == '') {
			if (isset($_SESSION['language'])) {
				$lang = $_SESSION['language'];
			} else if (isset($_COOKIE['language'])) {
				$lang = $_COOKIE['language'];
			} else {
				$lang = 'pl';
			}
		}
		
		$db = DB::getConnection();
		//запит до БД
		$result = $db->prepare('SELECT text '
			. 'FROM language '
			. 'WHERE lang=:lang AND page=:page '
			. 'LIMIT 1');
		if ($result->execute(array('lang' => $lang, 'page' => $page))) {
			$value = $result->fetch(PDO::FETCH_ASSOC);

			return $value['text'];
		} else {
			return false;
		}
	}
}