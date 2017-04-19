<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.12.2016
 * Time: 16:56
 */

include_once ROOT.'/models/IndexPage.php';

class IndexPageController
{
	/**
	 * @return bool
	 */
	public function actionIndex()
	{
		$indexList = array();

		$indexList = IndexPage::getInfoList();
		$indexList['index'] = 'index';

		View::setContent(INDEX_PAGE, $indexList);
		return true;
	}

	/**
	 * @return bool
	 */
	public function actionRegister()
	{
		$indexList = array();

		$indexList = IndexPage::getInfoList();
		$indexList['index'] = 'registr';

		View::setContent(INDEX_PAGE, $indexList);
		return true;
	}

	/**
	 * @return bool
	 */
	public function actionEnter()
	{
		$indexList = array();

		$indexList = IndexPage::getInfoList();
		$indexList['cookie'] = IndexPage::getCookieList();
		$indexList['index'] = 'enter';

		View::setContent(INDEX_PAGE, $indexList);
		return true;
	}
}