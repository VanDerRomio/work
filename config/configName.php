<?php
//define('HTTP_SITE_NAME', 'masterm4.beget.tech');

define('HTTP_SITE_NAME', 'loc.work.ua');

define('HTTP_SITE', 'http://'.HTTP_SITE_NAME);

define('HTTP_EDIT_TEAM', HTTP_SITE.'/editTeam/');
define('HTTP_ADD_TEAM', HTTP_SITE.'/addTeam');
define('HTTP_DELETE_TEAM', HTTP_SITE.'/deleteTeam/');

define('HTTP_SHOW_TEAM', HTTP_SITE.'/ShowTeam/');

define('HTTP_EDIT_PLAYER', HTTP_SITE.'/editPlayer/');
define('HTTP_ADD_PLAYER', HTTP_SITE.'/addPlayer/');
define('HTTP_DELETE_PLAYER', HTTP_SITE.'/deletePlayer/');

define('HTTP_404', HTTP_SITE.'/page404');
//-------------------------------------------------------------------------------
//наступні змінні використовуються лише для виводу виглядів (views)
//-------------------------------------------------------------------------------
define('ALL_TEAM', 'allTeam');
define('TEAM', 'team');

define('ADD_PLAYER', 'addPlayer');
define('DELETE_PLAYER', 'deletePlayer');
define('EDIT_PLAYER', 'editPlayer');

define('ADD_TEAM', 'addTeam');
define('DELETE_TEAM', 'deleteTeam');
define('EDIT_TEAM', 'editTeam');

define('PAGE_404', 'page404');