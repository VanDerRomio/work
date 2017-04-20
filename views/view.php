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
				case ALL_TEAM:
					return "allTeam.twig";
					break;
				case ADD_TEAM:
					return "addTeam.twig";
					break;
				case DELETE_TEAM:
					return "deleteTeam.twig";
					break;
				case EDIT_TEAM:
					return "editTeam.twig";
					break;
				//******************************
				case ADD_PLAYER:
					return "addPlayer.twig";
					break;
				case DELETE_PLAYER:
					return "deletePlayer.twig";
					break;
				case EDIT_PLAYER:
					return "editPlayer.twig";
					break;
				case TEAM:
					return "team.twig";
					break;
				//*****************************
				case PAGE_404:
					return "404.twig";
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