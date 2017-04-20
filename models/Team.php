<?php
class Team
{
	//ді з командами
	public static function getTeamList()
	{
		$returnArray = array();
		$db = DB::getConnection();

		$result = $db->query('SELECT * '
			. 'FROM team ');
		if($data = $result->fetchAll(PDO::FETCH_ASSOC)){
			//масив з обєктами
			$returnArray['data'] = $data;
			//силка на редагування команди
			$returnArray['btn_edit'] = HTTP_EDIT_TEAM;
			//силка додавання команди
			$returnArray['btn_add'] = HTTP_ADD_TEAM;
			//силка одної команди
			$returnArray['btn_team'] = HTTP_SHOW_TEAM;
			//силка видалення команди
			$returnArray['btn_delete'] = HTTP_DELETE_TEAM;
			//статус відповіді
			$returnArray['answer'] = 'ok';
		}
		else
		{
			//статус відповіді
			$returnArray['answer'] = 'error';
		}
		return $returnArray;
	}
	public static function addTeam()
	{
		$returnArray = array();
		if(isset($_POST['name']) && isset($_POST['date']) && $_POST['name'] != '' && $_POST['date'] != ''){
			$name = htmlentities($_POST['name'], ENT_QUOTES);
			$date = htmlentities($_POST['date'], ENT_QUOTES);

			$db = DB::getConnection();

			$result = $db->prepare('INSERT INTO team '
				. '(name, date_create) '
				. 'VALUES (:name, :date_create)');
			if($result->execute(array('name'=>$name, 'date_create'=>$date))){

				//статус відповіді
				$returnArray['answer'] = 'save';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}
		else{
			$returnArray['answer'] = 'form';
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
	public static function deleteTeam($id)
	{
		$returnArray = array();
		$db = DB::getConnection();

		$result = $db->prepare('DELETE FROM team '
			. 'WHERE id=:id');
		if ($result->execute(array('id' => $id))) {
			if ($result->rowCount() != 0) {

				$returnArray['answer'] = 'delete';
			}
			else {
				$returnArray['answer'] = 'error';
			}
		} else {
			$returnArray['answer'] = 'error';
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
	public static function editTeam($id)
	{
		$returnArray = array();
		$db = DB::getConnection();

		//якщо є данні, то збрерігаємо, інакше виводим дані команди
		if(isset($_POST['name']) && isset($_POST['date']) && $_POST['name'] != '' && $_POST['date'] != ''){
			$name = htmlentities($_POST['name'], ENT_QUOTES);
			$date = htmlentities($_POST['date'], ENT_QUOTES);

			$result = $db->prepare('UPDATE team '
				. 'SET name=:name, date_create=:date_create '
				. 'WHERE id=:id');
			if($result->execute(array('name'=>$name, 'date_create'=>$date, 'id'=>$id))){

				$returnArray['btn_index_page'] = HTTP_SITE;
				//статус відповіді
				$returnArray['answer'] = 'save';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}
		else{
			$result = $db->prepare('SELECT * '
				. 'FROM team '
				. 'WHERE id=:id ');
			if($result->execute(array('id'=>$id))){
				$data = $result->fetch(PDO::FETCH_ASSOC);
				//масив з обєктами
				$returnArray['data'] = $data;

				$returnArray['btn_index_page'] = HTTP_SITE;
				//силка видалення команди
				$returnArray['btn_delete'] = HTTP_DELETE_TEAM;
				//статус відповіді
				$returnArray['answer'] = 'form';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}

	//дії щодо гравців
	public static function ShowTeam($id)
	{
		$returnArray = array();
		$db = DB::getConnection();
		$result = $db->prepare('SELECT name '
			. 'FROM team '
			. 'WHERE id=:id ');
		if($result->execute(array('id'=>$id))) {
			$data = $result->fetch(PDO::FETCH_ASSOC);
			$returnArray['team'] = $data['name'];
		}

		$result = $db->prepare('SELECT * '
			. 'FROM player '
			. 'WHERE id_team=:id_team ');
		if($result->execute(array('id_team'=>$id))){
			$data = $result->fetchAll(PDO::FETCH_ASSOC);
			//масив з обєктами
			$returnArray['data'] = $data;
			$returnArray['id'] = $id;
			//силка на редагування команди
			$returnArray['btn_edit'] = HTTP_EDIT_PLAYER;
			//силка додавання команди
			$returnArray['btn_add'] = HTTP_ADD_PLAYER;
			//силка видалення команди
			$returnArray['btn_delete'] = HTTP_DELETE_PLAYER;
			//статус відповіді
			$returnArray['answer'] = 'ok';
		}
		else
		{
			//статус відповіді
			$returnArray['answer'] = 'error';
		}
		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
	public static function addPlayer($id)
	{
		$returnArray = array();
		if(isset($_POST['id_team']) && $_POST['id_team'] != ''
			&& isset($_POST['first_name']) && $_POST['first_name'] != ''
			&& isset($_POST['last_name']) && $_POST['last_name'] != ''
			&& isset($_POST['birth']) && $_POST['birth'] != ''
			&& isset($_POST['position']) && $_POST['position'] != ''){

			$id_team = htmlentities($_POST['id_team'], ENT_QUOTES);
			$first_name = htmlentities($_POST['first_name'], ENT_QUOTES);
			$last_name = htmlentities($_POST['last_name'], ENT_QUOTES);
			$birth = htmlentities($_POST['birth'], ENT_QUOTES);
			$position = htmlentities($_POST['position'], ENT_QUOTES);

			$db = DB::getConnection();

			$result = $db->prepare('INSERT INTO player '
				. '(id_team, first_name, last_name, birth, position) '
				. 'VALUES (:id_team, :first_name, :last_name, :birth, :position)');
			if($result->execute(array('id_team'=>$id_team, 'first_name'=>$first_name, 'last_name'=>$last_name, 'birth'=>$birth, 'position'=>$position))){

				//статус відповіді
				$returnArray['answer'] = 'save';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}
		else{
			$returnArray['answer'] = 'form';
			$returnArray['id'] = $id;
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
	public static function editPlayer($id)
	{
		$returnArray = array();
		$db = DB::getConnection();

		//якщо є данні, то збрерігаємо, інакше виводим дані команди
		if(isset($_POST['first_name']) && $_POST['first_name'] != ''
			&& isset($_POST['last_name']) && $_POST['last_name'] != ''
			&& isset($_POST['birth']) && $_POST['birth'] != ''
			&& isset($_POST['position']) && $_POST['position'] != ''){

			$first_name = htmlentities($_POST['first_name'], ENT_QUOTES);
			$last_name = htmlentities($_POST['last_name'], ENT_QUOTES);
			$birth = htmlentities($_POST['birth'], ENT_QUOTES);
			$position = htmlentities($_POST['position'], ENT_QUOTES);

			$result = $db->prepare('UPDATE player '
				. 'SET first_name=:first_name, last_name=:last_name, birth=:birth, position=:position '
				. 'WHERE id=:id');
			if($result->execute(array('first_name'=>$first_name, 'last_name'=>$last_name, 'birth'=>$birth, 'position'=>$position, 'id'=>$id))){

				$returnArray['btn_index_page'] = HTTP_SITE;
				//статус відповіді
				$returnArray['answer'] = 'save';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}
		else{
			$result = $db->prepare('SELECT * '
				. 'FROM player '
				. 'WHERE id=:id ');
			if($result->execute(array('id'=>$id))){
				$data = $result->fetch(PDO::FETCH_ASSOC);
				//масив з обєктами
				$returnArray['data'] = $data;

				$returnArray['btn_index_page'] = HTTP_SITE;
				//силка видалення команди
				$returnArray['btn_delete'] = HTTP_DELETE_TEAM;
				//статус відповіді
				$returnArray['answer'] = 'form';
			}
			else
			{
				//статус відповіді
				$returnArray['answer'] = 'error';
			}
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
	public static function deletePlayer($id)
	{
		$returnArray = array();
		$db = DB::getConnection();

		$result = $db->prepare('DELETE FROM player '
			. 'WHERE id=:id');
		if ($result->execute(array('id' => $id))) {
			if ($result->rowCount() != 0) {

				$returnArray['answer'] = 'delete';
			}
			else {
				$returnArray['answer'] = 'error';
			}
		} else {
			$returnArray['answer'] = 'error';
		}

		$returnArray['btn_index_page'] = HTTP_SITE;
		return $returnArray;
	}
}