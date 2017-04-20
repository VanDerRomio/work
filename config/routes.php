<?php
return array(
	'ShowTeam/([0-9]+)'=>'team/ShowTeam/$1',

	'addPlayer/([0-9]+)'=>'team/addPlayer/$1',
	'deletePlayer/([0-9]+)'=>'team/deletePlayer/$1',
	'editPlayer/([0-9]+)'=>'team/editPlayer/$1',

	'addTeam'=>'team/addTeam',
	'deleteTeam/([0-9]+)'=>'team/deleteTeam/$1',
	'editTeam/([0-9]+)'=>'team/editTeam/$1',

	'page404'=>'page404/index',

	''=>'team/index',													//при заходженні на сугубо назву сайта, наприклад: site.com
);