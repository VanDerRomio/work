<?php 
include_once ROOT.'/models/Team.php';

class TeamController
{
	//ді з командами
	public function actionIndex()
	{
		$indexList = array();
		$indexList = Team::getTeamList();
		View::setContent(ALL_TEAM, $indexList);
		return true;
	}
	public function actionAddTeam()
	{
		$List = array();
		$List = Team::addTeam();
		View::setContent(ADD_TEAM, $List);
		return true;
	}
	public function actionDeleteTeam($id)
	{
		$List = array();
		$List = Team::deleteTeam($id);
		View::setContent(DELETE_TEAM, $List);
		return true;
	}
	public function actionEditTeam($id)
	{
		$List = array();
		$List = Team::editTeam($id);
		View::setContent(EDIT_TEAM, $List);
		return true;
	}

	//дії щодо гравців
	public function actionShowTeam($id)
	{
		$indexList = array();
		$indexList = Team::ShowTeam($id);
		View::setContent(TEAM, $indexList);
		return true;
	}
	public function actionAddPlayer($id)
	{
		$List = array();
		$List = Team::addPlayer($id);
		View::setContent(ADD_PLAYER, $List);
		return true;
	}
	public function actionEditPlayer($id)
	{
		$List = array();
		$List = Team::editPlayer($id);
		View::setContent(EDIT_PLAYER, $List);
		return true;
	}
	public function actionDeletePlayer($id)
	{
		$List = array();
		$List = Team::deletePlayer($id);
		View::setContent(DELETE_PLAYER, $List);
		return true;
	}
}