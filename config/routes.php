<?php
return array(
	'language/([a-zA-Z]+)'=>'language/index/$1',

	'saveUser'=>'activation/saveUser',

	'insite'=>'insite/index',
	'outUser'=>'insite/outUser',

	'activationUser/([0-9a-zA-Z.$]+)'=>'activation/activationUser/$1',
	'activationUser'=>'activation/activationUser',

	'repairPass/([0-9a-zA-Z.$]+)'=>'repairPass/repairPass/$1',
	'repairPass'=>'repairPass/repairPass',

	'addDylemat'=>'addDylemat/index',									//виводимо форму для заповнення даними

	'showDylemat/([0-9]+)'=>'showDylemat/view/$1',					//перегляд одного питання
	'showDylemat'=>'showDylemat/index',									//перегляд питань

	'myDylemat/([0-9]+)'=>'showInfoDylemat/myDylemat/$1',		//перегляд моїх дилематів відповідно мого id
	'showInfoDylemat/([0-9]+)'=>'showInfoDylemat/view/$1',		//перегляд всіх дилематів відповідної категорії
	'showInfoDylemat'=>'showInfoDylemat/index',					//перегляд всіх дилематів в категорії по замовчуванні

	'about'=>'about/index',													//виводимо about

	'regulamin'=>'regulamin/index',										//виводимо regulamin

	'contact'=>'contact/index',											//виводимо форму для заповнення даними

	//'subscribe'=>'subscribe/index', 	//відправляємо дані користувача для підписки для збереження в БД

	'enterFacebook'=>'social/enterFacebook',							//сторінка входу
	'enterVK'=>'social/enterVK',							//сторінка входу
	'enterTwitter'=>'social/enterTwitter',							//сторінка входу
	'enterGPlus'=>'social/enterGPlus',							//сторінка входу

	'register'=>'indexPage/register',									//сторінка реєстрації
	'enter'=>'indexPage/enter',											//сторінка входу

	'page404'=>'page404/index',

	''=>'indexPage/index',													//при заходженні на сугубо назву сайта, наприклад: site.com

);