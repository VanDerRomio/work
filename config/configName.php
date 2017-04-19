<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 05.12.2016
 * Time: 23:53
 */
//забороняємо доступ до сторінки напряму, лише через index сторінку

//facebook
define('CLIENT_ID_FB', '1552720118101590');
define('CLIENT_SECRET_FB', 'def82e49b3b74ff0c1d42b6bf7137f99');

//GPlus
define('CLIENT_ID_GPus', '990499644414-931egdfqg947q1erq8ptrmcs29m121kt.apps.googleusercontent.com');
define('CLIENT_SECRET_GPlus', 'J58nqBUmKmN4vxg3zG8XO4v9');

//VK
define('CLIENT_ID_VK', '5932623');
define('CLIENT_SECRET_VK', 'Jz9LJ1SAgtgdSfIBbRM4');
define('SERVIS_KEY_VK', '6b4bddc06b4bddc06b1cbeac9c6b115b8f66b4b6b4bddc0338684f60ff665f3cc5dd3f6');

//--------------------------------------------------------------------------------------------------
//define('HTTP_SITE_NAME', 'dylematy-org.esy.es');

//define('HTTP_SITE_NAME', 'masterm4.beget.tech');

define('HTTP_SITE_NAME', 'colepsze.pl');

define('HTTP_SITE', 'http://'.HTTP_SITE_NAME);

define('EMAIL', 'master1988roma@gmail.com');

define('HTTP_LANG_PL', HTTP_SITE.'/language/pl');
define('HTTP_LANG_EN', HTTP_SITE.'/language/en');
define('HTTP_LANG_RU', HTTP_SITE.'/language/ru');
define('HTTP_LANG_UA', HTTP_SITE.'/language/ua');

define('HTTP_REGISTRATION_PAGE', HTTP_SITE.'/register');
define('HTTP_ENTER_PAGE', HTTP_SITE.'/enter');
define('HTTP_REPAIR_PASS_PAGE', HTTP_SITE.'/repairPass');

define('HTTP_ENTER_FACEBOOK_BACK', HTTP_SITE.'/enterFacebook');
define('HTTP_ENTER_VK', HTTP_SITE.'/enterVK');
define('HTTP_ENTER_TWITTER', HTTP_SITE.'/enterTwitter');
define('HTTP_ENTER_GPLUS', HTTP_SITE.'/enterGPlus');

define('HTTP_ACTIVATION_USER', HTTP_SITE.'/activationUser');
define('HTTP_SAVE_USER', HTTP_SITE.'/saveUser');
define('HTTP_INSITE_USER', HTTP_SITE.'/insite');
define('HTTP_OUT_USER',HTTP_SITE.'/outUser');

define('HTTP_ADD_DYLEMAT', HTTP_SITE.'/addDylemat');

define('HTTP_SHOW_DYLEMAT', HTTP_SITE.'/showDylemat');

define('HTTP_SHOW_INFO_DYLEMAT', HTTP_SITE.'/showInfoDylemat/');

define('HTTP_SHOW_MY_DYLEMAT', HTTP_SITE.'/myDylemat');

define('HTTP_ABOUT', HTTP_SITE.'/about');
define('HTTP_CONTACT', HTTP_SITE.'/contact');
define('HTTP_CONTACT_SAVE', HTTP_SITE.'/contact/save');
define('HTTP_REGULAMIN', HTTP_SITE.'/regulamin');

define('HTTP_404', HTTP_SITE.'/page404');
define('HTTP_ADMIN', HTTP_SITE.'/admin');
//-------------------------------------------------------------------------------
//наступні змінні використовуються лише для виводу виглядів (views)
//-------------------------------------------------------------------------------
define('INDEX_PAGE', 'indexPage');

define('REGISTRATION_PAGE', 'registerPage');
define('ENTER_PAGE', 'enterPage');

define('FACEBOOK_PAGE', 'enterFacebook');
define('VK_PAGE', 'enterVK');
define('TWITTER_PAGE', 'enterTwitter');
define('GPLUS_PAGE', 'enterGPlus');

define('ACTIVATION_PAGE', 'activation');
define('REPAIR_PASS_PAGE', 'repairPass');

define('NOINSITE', 'noinsite');
define('INSITE', 'insite');

define('ADD_DYLEMAT', 'addDylemat');

define('SHOW_DYLEMAT', 'showDylemat');

define('SHOW_INFO_DYLEMAT', 'showInfoDylemat');

define('ABOUT', 'aboutView');
define('CONTACT', 'contactView');
define('REGULAMIN', 'regulaminView');

define('NOIMG', '../images/noimage.png');

define('PAGE_404', 'page404');
/*
define('HTTP_MENU', HTTP_SITE.'/menu');


define('HTTP_CONTACT', HTTP_SITE.'/contact');
define('HTTP_CONTACT_SAVE', HTTP_SITE.'/contact/save');

define('HTTP_SUBSCRIBE', HTTP_SITE.'/views/subscribeForm.php');
define('HTTP_SUBSCRIBE_SAVE', HTTP_SITE.'/subscribe/save');

define('NEWS', 'newsView');
define('NEWITEM', 'newItem');

define('MENU', 'menuView');
define('MENUITEM', 'menuItem');

define('ABOUT', 'aboutView');
define('CONTACT', 'contactView');
define('SUBSCRIBE', 'subscribeView');

//************************
// ADMIN
//************************
define('HTTP_ADMIN', HTTP_SITE.'/admin/');
*/
