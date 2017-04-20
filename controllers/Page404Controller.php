<?php 
include_once ROOT.'/models/Page404.php';

class Page404Controller
{
	public function actionIndex()
	{
		$List = array();
		$List = Page404::getList();

		View::setContent(PAGE_404, $List);
		return true;
	}
}