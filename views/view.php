<?php

class View
{
	public static $content_array = array();
	public static $nameContent;

//задаємо значення даних
	public static function setContent($name, $value)
	{
		View::$content_array = $value;
		View::$nameContent = $name;
	}
//видаляємо значення даних
	public static function unsetContent($name)
	{
		unset(View::$content_array[$name], $nameContent);
	}

//повертаємо стрічку назви файла для вставки в контент
	public static function getIncludeView()
	{
		//echo "Получение '$name'\n";
		if (isset(View::$content_array))
		{
			switch(View::$nameContent)
			{
				case INDEX_PAGE:
					return ROOT."/views/indexPage.php";
					break;
				case ACTIVATION_PAGE:
					return ROOT."/views/activation.php";
					break;
				case REPAIR_PASS_PAGE:
					return ROOT."/views/repairPass.php";
					break;
				case ADD_DYLEMAT:
					return ROOT."/views/addDylemat.php";
					break;
				case SHOW_DYLEMAT:
					return ROOT."/views/showDylemat.php";
					break;
				case SHOW_INFO_DYLEMAT:
					return ROOT."/views/showInfoDylemat.php";
					break;
				case ABOUT:
					return ROOT."/views/about.php";
					break;
				case REGULAMIN:
					return ROOT."/views/regulamin.php";
					break;
				case CONTACT:
					return ROOT."/views/contact.php";
					break;
				case NOINSITE:
					return ROOT."/views/noinsite.php";
					break;
				case INSITE:
					return ROOT."/views/insite.php";
					break;
				case FACEBOOK_PAGE:
					return ROOT."/views/social_enter.php";
					break;
				case VK_PAGE:
					return ROOT."/views/social_enter.php";
					break;
				case TWITTER_PAGE:
					return ROOT."/views/social_enter.php";
					break;
				case GPLUS_PAGE:
					return ROOT."/views/social_enter.php";
					break;
				case PAGE_404:
					return ROOT."/views/404.php";
					break;
			}
		}
	}
//повертаємо значення даних
	public static function getContent()
	{
		return View::$content_array;
	}
}