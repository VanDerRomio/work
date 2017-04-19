<?php 
include_once ROOT.'/models/Page404.php';

class Page404Controller
{
	public function actionIndex()
	{
		$aboutList = array();

		View::setContent(PAGE_404, $aboutList);
		return true;
	}
}