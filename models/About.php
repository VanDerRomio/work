<?php 
class About
{
	/**повернення масиву даних
	 *
	 * @return array|mixed
	 */
	public static function getAboutList()
	{
		$db = DB::getConnection();

		$aboutList = array();
		//запит до БД
		$result = $db->query('SELECT * FROM about');
		
		$aboutList = $result->fetch(PDO::FETCH_ASSOC);

		return $aboutList;
	}
}