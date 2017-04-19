<?php 
include_once ROOT.'/models/About.php';

class AboutController
{
	public function actionIndex()
	{
		$aboutList = array();
		$aboutList = About::getAboutList();

		View::setContent(ABOUT, $aboutList);
		return true;
	}
}