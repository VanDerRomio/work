var rotationImg1 = 0;
var rotationImg2 = 0;

var arrayLanguage = {};

$(function() {
	//******************************************************
	//дії по замочуванні
	//******************************************************
	//глобальні змінні
	//var httpSite = 'http://dylematy-org.esy.es';
	//var httpSite = 'http://masterm4.beget.tech';
	//var httpSite = 'http://colepsze.pl';
	var httpSite = location.hostname;

	var httpShowDylemat = '/showDylemat';
	var httpAddDylemat = '/addDylemat';
	//вписування зображень в одну стрічку та зміна розмірів
	var window_width = window.innerWidth;
	var window_height = window.innerHeight;

	var Width_0 = 568;
	var Width_1 = 768;
	var Width_2 = 1130;
	var Width_3 = 1200;

	var img1_box = $('#img-1>img');
	var img1_width;
	var img1_height;

	var img2_box = $('#img-2>img');
	var img2_width;
	var img2_height;

	var id_user = 0;
	//вибираємо номер зі скритого поля
	var idDylemat = $('input[name=id]').val();

	var img1_yes = '';
	var img2_yes = '';

	var refresh = false;

	var userClick = false;
	var insertAnswer = '';
	var askAnswer_id = '';

	var img1Big = '';
	var img2Big = '';

	var widthBigImg1 = '';
	var heightBigImg1 = '';

	var widthBigImg2 = '';
	var heightBigImg2 = '';

	var kilkistDylem = 0;

	var speed_animation = 700;

	var language = $('input[name=language]').val();

	//*******************************************
	//перевіряємо на якій сторінці ми знаходимося
	//*******************************************
	function truePage(page) {
		if ($('input').is('[name=page]')) {
			return (page == $('input[name=page]').val());
		}
		else
			return false;
	}

	//отримуємо масив даних потрібної мови
	loadLanguage();
	function loadLanguage() {
		switch (language){
			case 'pl':
				arrayLanguage = languageArray_pl;
				break;
			case 'en':
				arrayLanguage = languageArray_en;
				break;
			case 'ru':
				arrayLanguage = languageArray_ru;
				break;
			case 'ua':
				arrayLanguage = languageArray_ua;
				break;
			default:
				arrayLanguage = languageArray_pl;
				break;
		}
	}

	if (truePage('showDylemat'))
		loadDylemat();
	//отримуємо масив даних для показу питання
	function loadDylemat() {
		//якщо користувач увійшов на сайт, то вставляємо відповідне поле з його індефікатором
		if ($('input').is('[name=den1]'))
			id_user = $('input[name=den1]').val();
		else
			id_user = 'no';

		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/returnArrayDylemat.php",
			data: {'idDylem': idDylemat, 'id_user': id_user, 'lang':language},
			cache: false,
			success: function (resp) {
				//console.log(JSON.parse(resp));
				//console.log(resp);
				load_size(JSON.parse(resp));
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
				load_size({'error': 'errorAjax'});
			}
		});
	}

	function load_size(contentShow) {
		if (contentShow['error'] == 'good') {

			kilkistDylem = contentShow['kilkist'];

			idDylemat = contentShow['id'];
			var PrivatCodeToDylemat = contentShow['code'];

			userClick = (contentShow['userClick'] == 'ok');
			insertAnswer = contentShow['askAnswer'];
			askAnswer_id = contentShow['askAnswer_id'];
			//console.log(userClick);

			var img1;
			var img2;

			var width_img1;
			var height_img1;

			var width_img2;
			var height_img2;

			//якщо розширення більше 768рх, то завантажуємо лише великі зображення
			if (window_width > Width_2) {
				img1Big = img1 = contentShow['img1'];
				img2Big = img2 = contentShow['img2'];

				widthBigImg1 = width_img1 = contentShow['img1_width'];
				heightBigImg1 = height_img1 = contentShow['img1_height'];
				widthBigImg2 = width_img2 = contentShow['img2_width'];
				heightBigImg2 = height_img2 = contentShow['img2_height'];
			}
			//якщо розширення менше 768рх, то завантажуємо великі та малі зображення
			else {
				//big
				img1Big = contentShow['img1'];
				img2Big = contentShow['img2'];

				widthBigImg1 = contentShow['img1_width'];
				heightBigImg1 = contentShow['img1_height'];
				widthBigImg2 = contentShow['img2_width'];
				heightBigImg2 = contentShow['img2_height'];

				//small
				img1 = contentShow['img1Small'];
				img2 = contentShow['img2Small'];

				width_img1 = contentShow['img1_small_width'];
				height_img1 = contentShow['img1_small_height'];
				width_img2 = contentShow['img2_small_width'];
				height_img2 = contentShow['img2_small_height'];
			}

			img1_yes = contentShow['img1_yes'];
			img2_yes = contentShow['img2_yes'];
			var ask1 = contentShow['ask1'];
			var ask2 = contentShow['ask2'];

			var coment = contentShow['coment'];

			var text = contentShow['text'];
			var author = contentShow['author'];
			var id_authoraDylemata = contentShow['id_user'];
			var views = contentShow['views'];
			var kategoria = contentShow['kategoria'];
			var privatDylematBool = contentShow['privat'];

			var views_id = contentShow['maxViewDylem_id'];
			var views_text = contentShow['maxViewDylem_text'];

			var lastAdd_id = contentShow['lastInsertDylem_id'];
			var lastAdd_text = contentShow['lastInsertDylem_text'];

			var rand1_id = contentShow['rand_1_Dylem_id'];
			var rand1_text = contentShow['rand_1_Dylem_text'];

			var rand2_id = contentShow['rand_2_Dylem_id'];
			var rand2_text = contentShow['rand_2_Dylem_text'];

			/*var rand3_id = contentShow['rand_3_Dylem_id'];
			 var rand3_ask1 = contentShow['rand_3_Dylem_ask1'];
			 var rand3_ask2 = contentShow['rand_3_Dylem_ask1'];*/
			//***************************************************
			//***************************************************

			$('#katName').html(arrayLanguage['kategoria'] + ': <span class="fs-11">' + kategoria + '</span>');
			$('#nameAuthor').html(arrayLanguage['add_dyl'] + author).attr({
				'href': '/myDylemat/' + id_authoraDylemata,
				'title': arrayLanguage['else_dyl_author']
			});

			//---------------------------------------------------------------------------------
			//змінюємо приватність дилемата
			//---------------------------------------------------------------------------------
			var setPrivatDylemat = $('#setPrivatDylemat');
			if (privatDylematBool == '1') {
				setPrivatDylemat.html('<i class="fa fa-lock" aria-hidden="true"></i>' + arrayLanguage['privat']);
			}
			else {
				setPrivatDylemat.hide();
			}

			if (parseInt(id_authoraDylemata) == parseInt($('input[name=den1]').val())) {
				setPrivatDylemat.show();
				if (privatDylematBool == '1') {
					setPrivatDylemat.removeClass('link-black-green link-black-red').addClass('link-black-red').html('<i class="fa fa-lock" aria-hidden="true"></i>' + arrayLanguage['do_public']);
				}
				else {
					setPrivatDylemat.removeClass('link-black-green link-black-red').addClass('link-black-green').html('<i class="fa fa-unlock" aria-hidden="true"></i>' + arrayLanguage['do_privat']);
				}
			}

			setPrivatDylemat.on('click', function () {
				if (parseInt(id_authoraDylemata) == parseInt($('input[name=den1]').val())) {
					var userIdNow = $('input[name=den1]').val();
					var returnSetPrivat = '';

					setPrivatDylemat.addClass('color-darkblue').html('<i class="color-darkblue fa fa-spinner fa-spin fa-lg fa-fw"></i>' + arrayLanguage['load']);
					$.ajax({
						type: 'POST',
						url: "../ajaxPHP/returnArrayDylemat.php",
						data: {
							'setPrivat': ((privatDylematBool == '1') ? '0' : '1'),
							'dylem_id': idDylemat,
							'user_id': userIdNow,
							'code': PrivatCodeToDylemat
						},
						cache: false,
						success: function (resp) {
							returnSetPrivat = JSON.parse(resp);
							//console.log(resp);
							if (returnSetPrivat['error'] == 'good') {
								if (returnSetPrivat['get'] == '1') {
									window.location.replace(httpShowDylemat + '/' + idDylemat + PrivatCodeToDylemat);
								}
								else {
									window.location.replace(httpShowDylemat + '/' + idDylemat);
								}
							}
							else if (returnSetPrivat['error'] == 'error') {
								//console.log('помилка при оновленні');
							}
							else if (returnSetPrivat['error'] == 'errorBD') {
								//console.log('помилка доступу до бази данних');
							}
							else if (returnSetPrivat['error'] == 'errorIsset') {
								//console.log('не відправленні дані для запроса');
							}
							else {
								//console.log('не можливо розібрати дані...');
							}
						},
						error: function (req, status, err) {
							//console.log('что-то пошло не так', status, err);
						}
					});
				}
			});

			//---------------------------------------------------------------------------------
			//виводимо кнопку видалення дилемата
			//---------------------------------------------------------------------------------
			var deleteDylematButton = $('#deleteDylematButton');
			deleteDylematButton.hide();

			if (parseInt(id_authoraDylemata) == parseInt($('input[name=den1]').val())) {
				deleteDylematButton.show();
			}

			//видаляємо дилемат
			deleteDylematButton.on('click', function () {
				deleteDylematButton.hide();
				if (parseInt(id_authoraDylemata) == parseInt($('input[name=den1]').val())) {
					deleteDylematButton.after('<div id="ddbYN" class="border2 brr-4 bshadow mbottom-05 item-start p-02">' + arrayLanguage['delete_dyl'] + '<br/>'
						+ '<div class="flex-row jc-around"><a href="#" id="deleteDylematButtonYes" class="link-black-red brr-4 bshadow p-lr-20 mbottom-01">' + arrayLanguage['yes'] + '</a>'
						+ '<a href="#" id="deleteDylematButtonNo" class="link-black-green brr-4 bshadow p-lr-20 mbottom-01">' + arrayLanguage['no'] + '</a></div></div>');
				}
				$('#deleteDylematButtonNo').on('click', function () {
					$('#ddbYN').hide('blind', speed_animation, function () {
						deleteDylematButton.show('blind', speed_animation, function () {
							$('#ddbYN').remove();
						});
					});
				});
				$('#deleteDylematButtonYes').on('click', function () {
					if (parseInt(id_authoraDylemata) == parseInt($('input[name=den1]').val())) {
						var userIdNow = $('input[name=den1]').val();
						var returnDeleteDylemat = '';
						$('#ddbYN').hide('blind', speed_animation, function () {
							deleteDylematButton.show('blind', speed_animation, function () {
								deleteDylematButton.addClass('color-darkblue').html('<i class="color-darkblue fa fa-spinner fa-spin fa-lg fa-fw"></i>' + arrayLanguage['do']);
								$('#ddbYN').remove();
							});
						});

						$.ajax({
							type: 'POST',
							url: "../ajaxPHP/returnArrayDylemat.php",
							data: {
								'deleteDylemat': '1',
								'dylem_id': idDylemat,
								'user_id': userIdNow,
								'code': PrivatCodeToDylemat
							},
							cache: false,
							success: function (resp) {
								returnDeleteDylemat = JSON.parse(resp);
								//console.log(resp);
								if (returnDeleteDylemat['error'] == 'good') {
									window.location.replace(httpShowDylemat);
								}
								else if (returnDeleteDylemat['error'] == 'error') {
									//console.log('помилка при оновленні');
								}
								else if (returnDeleteDylemat['error'] == 'errorBD') {
									//console.log('помилка доступу до бази данних');
								}
								else if (returnDeleteDylemat['error'] == 'errorIsset') {
									//console.log('не відправленні дані для запроса');
								}
								else {
									//console.log('не можливо розібрати дані...');
								}
							},
							error: function (req, status, err) {
								//console.log('что-то пошло не так', status, err);
							}
						});
					}
				});
			});

			var sendSocial_gp = $('#sendSocial_gp').attr('data-href');
			$('#sendSocial_gp').attr({'data-href': sendSocial_gp + '/' + idDylemat + PrivatCodeToDylemat});

			var sendSocial_fb = $('#sendSocial_fb').attr('data-href');
			$('#sendSocial_fb').attr({'data-href': sendSocial_fb + '/' + idDylemat + PrivatCodeToDylemat});

			var sendMessageSocial_fb_atrr = $('#sendMessageSocial_fb').attr('data-href');
			$('#sendMessageSocial_fb').attr({'data-href': sendMessageSocial_fb_atrr + '/' + idDylemat + PrivatCodeToDylemat});

			$('#dylemat').html(text);
			$('#views').html(views);
			$('#wynik').html(img1_yes + '<span class="color-orange">:</span>' + img2_yes);
			$('#linkImg1>span').html(ask1);
			$('#linkImg2>span').html(ask2);
			$('#img-1>img').attr({'src': img1, 'alt': img1});
			$('#img-2>img').attr({'src': img2, 'alt': img2});

			var linkLastAdd = $('#linkLastAdd');
			var linkNext1 = $('#linkNext1');
			var linkNext2 = $('#linkNext2');
			var linkViews = $('#linkViews');

			if (!refresh) {
				switch (kilkistDylem) {
					case '1':
						linkLastAdd.hide();
						linkNext1.hide();
						linkNext2.hide();
						linkViews.hide();
						break;
					case '2':
						//lastAdd
						linkLastAdd.attr({
							'href': '/showDylemat/' + lastAdd_id,
							'title': arrayLanguage['last_add']
						})
							.html('<span>' + lastAdd_text + '</span>');

						linkLastAdd.show();
						linkNext1.hide();
						linkNext2.hide();
						linkViews.hide();
						break;
					case '3':
						//lastAdd
						linkLastAdd.attr({
							'href': '/showDylemat/' + lastAdd_id,
							'title': arrayLanguage['last_add']
						})
							.html('<span>' + lastAdd_text + '</span>');

						//views
						linkViews.attr({
							'href': '/showDylemat/' + views_id,
							'title': arrayLanguage['best_view']
						})
							.html('<span>' + views_text + '</span>');

						linkLastAdd.show();
						linkNext1.hide();
						linkNext2.hide();
						linkViews.show();
						break;
					case '4':
						//lastAdd
						linkLastAdd.attr({
							'href': '/showDylemat/' + lastAdd_id,
							'title': arrayLanguage['last_add']
						})
							.html('<span>' + lastAdd_text + '</span>');

						//views
						linkViews.attr({
							'href': '/showDylemat/' + views_id,
							'title': arrayLanguage['best_view']
						})
							.html('<span>' + views_text + '</span>');
//rand1
						linkNext1.attr({
							'href': '/showDylemat/' + rand1_id,
							'title': 'Losowy'
						})
							.html('<span>' + rand1_text + '</span>');

						linkLastAdd.show();
						linkNext1.show();
						linkNext2.hide();
						linkViews.show();
						break;
					case '5':
						linkLastAdd.show();
						linkNext1.show();
						linkNext2.show();
						linkViews.show();
						//rand1
						linkNext1.attr({
							'href': '/showDylemat/' + rand1_id,
							'title': 'Losowy'
						})
							.html('<span>' + rand1_text + '</span>');
						//rand2
						linkNext2.attr({
							'href': '/showDylemat/' + rand2_id,
							'title': 'Losowy'
						})
							.html('<span>' + rand2_text + '</span>');
						//views
						linkViews.attr({
							'href': '/showDylemat/' + views_id,
							'title': arrayLanguage['best_view']
						})
							.html('<span>' + views_text + '</span>');
						//lastAdd
						linkLastAdd.attr({
							'href': '/showDylemat/' + lastAdd_id,
							'title': arrayLanguage['last_add']
						})
							.html('<span>' + lastAdd_text + '</span>');
						break;
					default:
						break;
				}
				refresh = true;
			}
		}
		else {
			switch (contentShow['error']) {
				case 'errorIsset':
					//console.log('errorIsset...');
					break;
				case 'errorEmpty':
					//console.log('errorEmpty...');
					break;
				case 'errorBD':
					//console.log('errorBD...');
					break;
				case 'errorAjax':
					//console.log('errorAjax...');
					break;
				case 'notExist':
					//window.location.replace(httpShowDylemat + '/' + contentShow['id']);
					break;
				case 'noDylemat':
					$('#ask').html('<h2 class="fs-13 p-tb-01 mbottom-10 w-100 brr-4 bshadow color-white bgc-orange lheight-15">' + arrayLanguage['information'] + '</h2>' +
						'<div id="contactAnswer" class="border brr-4 bgc-white fs-10 color-orange bshadow p-04 mbottom-08">' +
						arrayLanguage['no_dyl'] +
						'</div>' +
						'<a id="registerLink" href="' + httpAddDylemat + '" class="link-black-orange brr-4 p-05 bshadow"><span>' + arrayLanguage['btn_add_dyl'] + '</span></a>' +
						'<br/>');
					return false;
					break;
				default:
					//console.log('i dont now...');
					break;
			}
			$('#ask').html('<h2 class="fs-13 p-tb-01 mbottom-10 w-100 brr-4 bshadow color-white bgc-orange lheight-15">' + arrayLanguage['information'] + '</h2>' +
				'<div id="contactAnswer" class="border brr-4 bgc-white fs-10 color-orange bshadow p-04 mbottom-08">' +
				arrayLanguage['error'] +
				'</div>' +
				'<a id="registerLink" href="' + httpShowDylemat + '" class="link-black-orange brr-4 p-05 bshadow"><span>' + arrayLanguage['else_dyl'] + '</span></a>' +
				'<br/>');

			return false;
		}
		$(window).on('load', function () {
			img1_width = width_img1;
			img1_height = height_img1;
			img2_width = width_img2;
			img2_height = height_img2;
		});
		img1_width = width_img1;
		img1_height = height_img1;
		img2_width = width_img2;
		img2_height = height_img2;

		window_width = window.innerWidth;
		window_height = window.innerHeight;
		cheng_size(img1_width, img1_height, img2_width, img2_height);
	}

	function cheng_size(w1, h1, w2, h2) {

		var newH1, newH2, newW1, newW2;

		var askPage = $('#ask');

		//для мобільних рисунки вертикальні, а для компів - горизонтальні
		//для планшетів
		if (window_width >= Width_1) {

			//hx=(hr*wx)/wr (x - не відомий розмір, r - розмір рисунка)
			newH1 = (h1 * parseInt(askPage.css('width'))) / (2.2 * w1);
			newW1 = parseInt(askPage.css('width')) / 2.2;
			newH2 = (h2 * parseInt(askPage.css('width'))) / (2.2 * w2);
			newW2 = parseInt(askPage.css('width')) / 2.2;
		}
		//мобільні телефони
		else {
			//hx=(hr*wx)/wr (x - не відомий розмір, r - розмір рисунка)

			newH1 = (h1 * parseInt(askPage.css('width'))) / w1;
			newW1 = askPage.css('width');
			newH2 = (h2 * parseInt(askPage.css('width'))) / w2;
			newW2 = askPage.css('width');
		}
		img1_box.css({
			'width': newW1,
			'height': newH1
		});
		img2_box.css({
			'width': newW2,
			'height': newH2
		});
	}

	//поле для відправлення повідомлення через соціальні мережі
	var sendMessageSocial = $('#sendMessageSocial');
	var sendMessageSocialShow = false;
	var sendMessageSocialBox = $('#sendMessageSocialBox');
	sendMessageSocialBox.hide();
	sendMessageSocial.on('click', function () {
		if (sendMessageSocialShow) {
			sendMessageSocialBox.hide('blind', speed_animation);
			sendMessageSocialShow = false;
			$('#sendMessageSocial>i').toggleClass('fa-flip-vertical');
		}
		else {
			sendMessageSocialBox.show('blind', speed_animation);
			sendMessageSocialShow = true;
			$('#sendMessageSocial>i').toggleClass('fa-flip-vertical');
		}
	});
	//********************************************
	//змінюємо розміри reCapcha
	//********************************************
	//для планшетів
	if (truePage('enter') || truePage('index') || truePage('register'))
		sizeReCapcha();
	function sizeReCapcha() {
		if ($('div').is('.g-recaptcha')) {
			var g_recaptcha = $('.g-recaptcha');
			if (window.innerWidth >= Width_0) {
				g_recaptcha.attr({'data-size': 'normal'});
			}
			//мобільні телефони
			else {
				g_recaptcha.attr({'data-size': 'compact'});
			}
		}
	}

	//*******************************************************
	//дії при зміні розмірів вікна
	//*******************************************************
	$(window).resize(function (e) {
		$('#menu-box').css({'height': window.innerHeight - 25});
		if (truePage('showDylemat'))
			loadDylemat();

		callReklama();

		if (truePage('enter') || truePage('index') || truePage('register'))
			sizeReCapcha();
	});
	//*******************************************************
	//дії при скролі сторінки
	//*******************************************************
	$(window).scroll(function (e) {

	});
	//*******************************************************
	//основні скріпти
	//*******************************************************
	//*******************************************************
	//отримуємо реклмні блоки з БД та вставляємо на сайт
	//*******************************************************
	callReklama();

	var vertSmall_rekl = false;
	var vertMiddle_rekl = false;
	var vertBig_rekl = false;
	var gorSmall_rekl = false;
	var gorMiddle_rekl = false;
	var gorBig_rekl = false;

	function callReklama() {
		// 568 < roz < 768
		// gorSmall 200x200
		// verSmall 120x600
		if (window.innerWidth >= Width_0 && window.innerWidth < Width_1) {
			if (!vertSmall_rekl) {
				ajaxReklama('vertSmall');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = true;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
			if (!gorSmall_rekl) {
				ajaxReklama('gorSmall');

				gorSmall_rekl = true;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = false;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
		}
		// 768 < roz < 1130
		// gorMiddle 300x250
		// verMiddle 160x600
		else if (window.innerWidth >= Width_1 && window.innerWidth < Width_2) {
			if (!vertMiddle_rekl) {
				ajaxReklama('vertMiddle');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = false;
				vertMiddle_rekl = true;
				vertBig_rekl = false;
			}
			if (!gorMiddle_rekl) {
				ajaxReklama('gorMiddle');

				gorSmall_rekl = false;
				gorMiddle_rekl = true;
				gorBig_rekl = false;
				vertSmall_rekl = false;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
		}
		// 1130 < roz < 1200
		// gorBig 750x200
		// verSmall 120x600
		else if (window.innerWidth >= Width_2 && window.innerWidth < Width_3) {
			if (!vertSmall_rekl) {
				ajaxReklama('vertSmall');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = true;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
			if (!gorBig_rekl) {
				ajaxReklama('gorBig');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = true;
				vertSmall_rekl = false;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
		}
		// roz > 1200
		// gorBig 750x200
		// verMiddle 160x600
		else if (window.innerWidth >= Width_3) {
			if (!vertMiddle_rekl) {
				ajaxReklama('vertMiddle');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = false;
				vertMiddle_rekl = true;
				vertBig_rekl = false;
			}
			if (!gorBig_rekl) {
				ajaxReklama('gorBig');

				gorSmall_rekl = false;
				gorMiddle_rekl = false;
				gorBig_rekl = true;
				vertSmall_rekl = false;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
		}
		// roz < 568
		// gorSmall 200x200
		else {
			if (!gorSmall_rekl) {
				ajaxReklama('gorSmall');
				gorSmall_rekl = true;
				gorMiddle_rekl = false;
				gorBig_rekl = false;
				vertSmall_rekl = false;
				vertMiddle_rekl = false;
				vertBig_rekl = false;
			}
		}
	}

	function ajaxReklama(typeReklamaSend) {
		var returnReklama = '';
		var reklam_block_gorizontal = $('#reklam-block-gorizontal');
		var reklam_block_vartical_right = $('#reklam-block-vartical-right');
		var reklam_block_vartical_left = $('#reklam-block-vartical-left');

		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/returnReklama.php",
			data: {'typeReklamy': typeReklamaSend},
			cache: false,
			success: function (resp) {
				returnReklama = JSON.parse(resp);
				if (returnReklama['error'] == 'good') {
					switch (typeReklamaSend) {
						case 'vertSmall':
							if ($('div').is('#reklam-block-vartical-right'))
								reklam_block_vartical_right.html(returnReklama[typeReklamaSend]);
							break;
						case 'vertMiddle':
							if ($('div').is('#reklam-block-vartical-right'))
								reklam_block_vartical_right.html(returnReklama[typeReklamaSend]);
							break;
						case 'gorSmall':
							if ($('div').is('#reklam-block-gorizontal'))
								reklam_block_gorizontal.html(returnReklama[typeReklamaSend]);
							break;
						case 'gorMiddle':
							if ($('div').is('#reklam-block-gorizontal'))
								reklam_block_gorizontal.html(returnReklama[typeReklamaSend]);
							break;
						case 'gorBig':
							if ($('div').is('#reklam-block-gorizontal'))
								reklam_block_gorizontal.html(returnReklama[typeReklamaSend]);
							break;
						default:
							break;
					}
				}
				else if (returnReklama['error'] == 'errorBD') {
					console.log('помилка доступу до бази данних');
				}
				else if (returnReklama['error'] == 'errorIsset') {
					console.log('не відправленні дані для запроса');
				}
				else {
					console.log('не можливо розібрати дані...');
				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//*******************************************************
	//форма реєстрації
	//*******************************************************
	var btn_register = $('#btn-registration');
	var form_register = $('#box-register');

	var existUserBool = false;
	var existUserNameBool = false;

	//****************************************************
	//перевірка форми на заповнення полів перед відправкою
	//****************************************************
	btn_register.on('click', function () {
		if (corectRegistrationForm()) {
			form_register.submit();
		}
	});

	var pass_Input = $('#passReg');
	var pass2_Input = $('#pass2Reg');

	var errorPassReg = $('#errorPassReg');
	errorPassReg.hide();

	var passCorect = false;
	var email_bool_reg = false;

	pass_Input.keyup(function () {
		corectPass();
	});

	pass2_Input.keyup(function () {
		corectPass();
	});

	function corectPass() {
		if (pass2_Input.val() != '') {
			if (pass_Input.val().length != pass2_Input.val().length && pass_Input.val() != pass2_Input.val()) {

				errorPassReg.text(arrayLanguage['pass_no_pass']).show('blind', 600);
				passCorect = false;
			}
			else {
				errorPassReg.hide('blind', 600);
				passCorect = true;
			}
		}
	}

	function corectRegistrationForm() {

		var divErrorInput = '<div class="errorClearInput error brr-4 letter-sp fs-9 lheight-14 mbottom-05 bshadow"></div>';
		var textErrorInput = arrayLanguage['empty_input'] + ':<br>';

		var email_Input = $('#emailReg');

		var radio_Input = $('input[name=robotReg]:checked');

		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		email_bool_reg = (pattern.test(email_Input.val()));

		if (name_Input_reg.val().length < 2 || email_Input.val().length < 4 || pass_Input.val().length < 4 || passCorect == false || email_bool_reg == false || radio_Input.val() != 'no' || existUserBool || existUserNameBool) {
			if (name_Input_reg.val().length < 2) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['nickname'] + '</span><br>';
				$('#nameRegDiv>span').html('<i class="fa fa-minus-circle fs-14 color-red"></i>');
			}
			if (existUserNameBool) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['exist_name'] + '</span><br>';
			}
			if (email_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['email'] + '</span><br>';
			}
			else {
				if (!email_bool_reg) {
					textErrorInput += '<span class="color-red">' + arrayLanguage['wrong_email'] + '</span><br>';
					$('#emailRegDiv>span').html('<i class="fa fa-minus-circle fs-14 color-red"></i>');
				}
			}
			if (existUserBool) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['exist_email'] + '</span><br>';
			}
			if (radio_Input.val() != 'no') {
				textErrorInput += '<span class="color-red">you a robot?</span><br>';
			}
			if (pass_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['pass'] + '</span><br>';
			}
			if (!passCorect) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['pass_no_pass'] + '</span><br>';
			}

			textErrorInput += arrayLanguage['min4'];
			if ($("div").is(".errorClearInput")) {
				$("div.errorClearInput").html(textErrorInput);
			}
			else {
				$('h2#registrationText').after(divErrorInput);
				$("div.errorClearInput").html(textErrorInput);
			}
			return false;
		}
		else {
			//console.log(existUserBool);
			$("div.errorClearInput").remove();
			return true;
		}
	}

	//*******************************************************
	//перевірка існування такогоє emaila
	//*******************************************************
	var email_Input = $('#emailReg');
	email_Input.keyup(function () {
		if ($(this).val().length > 6) {
			existUserEmail($(this).val());
		}
	});
	email_Input.mousedown(function () {
		if ($(this).val().length > 6) {
			existUserEmail($(this).val());
		}
	});
	email_Input.on('blur', function () {
		if ($(this).val().length > 6) {
			existUserEmail($(this).val());
		}
	});
	function existUserEmail(email) {
		var dataAnswerUsers = '';
		$('#emailRegDiv>span').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw fs-14 color-blue"></i>');
		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/users.php",
			data: {'key': 'existUser', 'email': email},
			dataType: 'json',
			cache: false,
			success: function (resp) {
				dataAnswerUsers = resp;
				//console.log(dataAnswerUsers);
				if (dataAnswerUsers['error'] == 'corectAll') {
					//console.log(dataAnswerUsers['exist']);
					//заповняємо поля даними після збереження
					if (dataAnswerUsers['exist'] == 'yes') {
						$('#emailRegDiv>span').html('<i class="fa fa-minus-circle fs-14 color-red"></i>');
						existUserBool = true;
						corectRegistrationForm();
					}
					else {
						$('#emailRegDiv>span').html('<i class="fa fa-check-square-o fs-14 color-green"></i>');
						existUserBool = false;
						corectRegistrationForm();
					}
					//console.log(existUserBool);
				}
				else {
					switch (dataAnswerUsers['error']) {
						case 'errorIsset':
							//console.log('errorIsset...');
							break;
						case 'errorEmpty':
							//console.log('errorEmpty...');
							break;
						case 'errorBD':
							//console.log('errorDB...');
							break;
						default:
							//console.log('i dont now...');
							break;
					}

				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//*******************************************************
	//перевірка існування такогоє nickname/login
	//*******************************************************
	var name_Input_reg = $('#nameReg');
	name_Input_reg.keyup(function () {
		if ($(this).val().length > 1) {
			existUserName($(this).val());
		}
	});
	name_Input_reg.on('blur', function () {
		if ($(this).val().length > 2) {
			existUserName($(this).val());
		}
	});
	function existUserName(name) {
		var dataAnswerUsers = '';
		$('#nameRegDiv>span').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw fs-14 color-blue"></i>');
		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/users.php",
			data: {'key': 'existName', 'name': name},
			dataType: 'json',
			cache: false,
			success: function (resp) {
				dataAnswerUsers = resp;
				//console.log(dataAnswerUsers);
				if (dataAnswerUsers['error'] == 'corectAll') {
					//console.log(dataAnswerUsers['exist']);
					//заповняємо поля даними після збереження
					if (dataAnswerUsers['exist'] == 'yes') {
						$('#nameRegDiv>span').html('<i class="fa fa-minus-circle fs-14 color-red"></i>');
						existUserNameBool = true;
						corectRegistrationForm();
					}
					else {
						$('#nameRegDiv>span').html('<i class="fa fa-check-square-o fs-14 color-green"></i>');
						existUserNameBool = false;
						corectRegistrationForm();
					}
					//console.log(existUserBool);
				}
				else {
					switch (dataAnswerUsers['error']) {
						case 'errorIsset':
							//console.log('errorIsset...');
							break;
						case 'errorEmpty':
							//console.log('errorEmpty...');
							break;
						case 'errorBD':
							//console.log('errorDB...');
							break;
						default:
							//console.log('i dont now...');
							break;
					}

				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//*******************************************************
	//форма реєстрації end-----------------------------------
	//*******************************************************
	//*******************************************************
	//форма входу
	//*******************************************************
	var btn_insite = $('#btn-insite');
	var form_insite = $('#box-insite');

	var existUserBool_insite = false;

	//****************************************************
	//перевірка форми на заповнення полів перед відправкою
	//****************************************************
	btn_insite.on('click', function () {
		if (corectInsiteForm()) {
			form_insite.submit();
		}
	});

	function corectInsiteForm() {

		var divErrorInput_insite = '<div class="errorClearInputInsite error brr-4 letter-sp fs-9 lheight-14 mbottom-05 bshadow"></div>';
		var textErrorInput_insite = arrayLanguage['empty_input'] + ':<br>';

		var name_Input_insite = $('#nameInsite');
		var email_Input_insite = $('#emailInsite');
		var email_bool_insite = false;

		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		email_bool_insite = (pattern.test(email_Input_insite.val()));

		if (name_Input_insite.val().length < 4 || email_Input_insite.val().length < 4 || email_bool_insite == false) {
			if (name_Input_insite.val().length < 4) {
				textErrorInput_insite += '<span class="color-red">' + arrayLanguage['pass'] + '</span><br>';
			}
			if (email_Input_insite.val().length < 4) {
				textErrorInput_insite += '<span class="color-red">' + arrayLanguage['email'] + '</span><br>';
			}
			else {
				if (!email_bool_insite) {
					textErrorInput_insite += '<span class="color-red">' + arrayLanguage['wrong_email'] + '</span><br>';
				}
			}
			textErrorInput_insite += arrayLanguage['min4'];
			if ($("div").is(".errorClearInputInsite")) {
				$("div.errorClearInputInsite").html(textErrorInput_insite);
			}
			else {
				$('h2#insiteText').after(divErrorInput_insite);
				$("div.errorClearInputInsite").html(textErrorInput_insite);
			}
			return false;
		}
		else {
			$("div.errorClearInputInsite").remove();
			return true;
		}
	}

	//*******************************************************
	//форма входу end----------------------------------------
	//*******************************************************
	//*******************************************************
	//відновлення пароля
	//*******************************************************
	var btn_send_email_rp = $('#btn-send-email');
	var email_input_rp = $('#email-input-rp');
	var repairPassEmailForm = $('#repairPassEmailForm');

	var btn_update_pass = $('#btn-update-pass');
	var newPass_Input = $('#newPass-Input');
	var newPass2_Input = $('#newPass2-Input');
	var repairPassForm = $('#repairPassForm');
	//****************************************************
	//перевірка форми на заповнення полів перед відправкою
	//****************************************************
	btn_send_email_rp.on('click', function () {
		var divErrorInput_insite = '<div class="errorClearInputInsite error brr-4 letter-sp fs-9 lheight-14 mbottom-05 p-02 bshadow"></div>';
		var textErrorInput_insite = '';

		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		var corect_email_rp = pattern.test(email_input_rp.val());

		if(email_input_rp.val().length > 0) {
			if (!corect_email_rp) {
				textErrorInput_insite += '<span class="color-red">' + arrayLanguage['wrong_email'] + '</span><br>';
			}
			else{
				$("div.errorClearInputInsite").remove();
				$('h2#insiteText').after('<span><i class="fa fa-spinner fa-pulse fa-3x fa-fw fs-14 color-blue"></i><span class="color-darkblue"> LOAD...</span></span>');
				repairPassEmailForm.submit();
				return true;
			}
		}
		else {
			textErrorInput_insite = arrayLanguage['empty_input'] + ':<br>';
			textErrorInput_insite += '<span class="color-red">' + arrayLanguage['email'] + '</span><br>';
		}

		if ($("div").is(".errorClearInputInsite")) {
			$("div.errorClearInputInsite").html(textErrorInput_insite);
		}
		else {
			$('h2#insiteText').after(divErrorInput_insite);
			$("div.errorClearInputInsite").html(textErrorInput_insite);
		}
	});
	btn_update_pass.on('click', function () {
		var divErrorInput_insite = '<div class="errorClearInputInsite error brr-4 letter-sp fs-9 lheight-14 mbottom-05 p-02 bshadow"></div>';
		var textErrorInput_insite = '';

		if(newPass_Input.val() == newPass2_Input.val()){
			if(newPass_Input.val().length > 3 || newPass2_Input.val().length > 3) {
				$("div.errorClearInputInsite").remove();
				$('h2#insiteText').after('<span><i class="fa fa-spinner fa-pulse fa-3x fa-fw fs-14 color-blue"></i><span class="color-darkblue"> LOAD...</span></span>');
				btn_update_pass.hide();
				repairPassForm.submit();
				return true;
			}
			else{
				textErrorInput_insite = arrayLanguage['empty_input'] + "<br/>";
				textErrorInput_insite += arrayLanguage['pass'] + "<br/>";
				textErrorInput_insite += '<span class="fs-08 color-blue">' + arrayLanguage['min4'] + '</span>';
			}
		}
		else {
			textErrorInput_insite = arrayLanguage['pass_no_pass'] + "<br/>";
			textErrorInput_insite += '<span class="fs-08 color-blue">' + arrayLanguage['min4'] + '</span>';
		}

		if ($("div").is(".errorClearInputInsite")) {
			$("div.errorClearInputInsite").html(textErrorInput_insite);
		}
		else {
			$('h2#insiteText').after(divErrorInput_insite);
			$("div.errorClearInputInsite").html(textErrorInput_insite);
		}
	});
	//*******************************************************
	//activation page
	//*******************************************************
	var activationLink = $('#activationLink');
	var activation_Input = $('#activation-Input');

	activationLink.on('click', function () {
		$(this).attr('href', $(this).attr('href') + '/' + activation_Input.val());
	});
	//*******************************************************
	//показуємо та ховаємо меню
	//*******************************************************
	var menuKategoriaBox_btn = $('#menuKategoriaBox_btn');
	var menuKategoriaBox = $('#menuKategoriaBox');
	var menuKategoriaBox_bool = false;
	menuKategoriaBox.hide();
	menuKategoriaBox_btn.on('click', function () {
		if(menuKategoriaBox_bool) {
			menuKategoriaBox.hide('blind', speed_animation);
			menuKategoriaBox_bool = false;
		}
		else {
			menuKategoriaBox.show('blind', speed_animation);
			menuKategoriaBox_bool = true;
		}
	});

	var btn_menu = $('.btn-menu');
	var box_menu = $('#menu-box');
	var showMenuSpeed = 800;
	var openMenu = false;

	$('#wrapper').on('click', function () {
		hideMenu();
	});
	box_menu.hide();
	box_menu.css({'height': window.innerHeight - 25});
	btn_menu.text('menu');

	btn_menu.on('click', function () {
		if (openMenu) {
			hideMenu();
		}
		else {
			showMenu();
		}
	});

	function showMenu() {
		box_menu.show('slide', showMenuSpeed);
		btn_menu.animate({'left': box_menu.outerWidth()}, showMenuSpeed);
		btn_menu.text('close');
		openMenu = true;
	}

	function hideMenu() {
		box_menu.hide('slide', showMenuSpeed);
		btn_menu.animate({'left': 0}, showMenuSpeed);
		btn_menu.text('menu');
		openMenu = false;
	}

	//*********************************************************
	//ajax запрос, зберігаємо дилемат
	//*********************************************************
	var btn_send_ADylemat = $('#btn-sendFormAD');
	var btn_add_Dylemat = $('#btn-add-dulemat');

	var formAddDylemat = $('#formAddDylemat');

	var saveBoxDylemat = $('#saveAll');
	var addBoxDylemat = $('#addAsk');

	//поля форми для введення даних
	var text_Input = $('#text_Input');
	var ask1_Input = $('#ask1_Input');
	var ask2_Input = $('#ask2_Input');

	//поля після збереження дилемата
	var insertText = $('#insertText');
	var insertAsk1 = $('#insertAsk1');
	var insertAsk2 = $('#insertAsk2');
	var addImg1 = $('#addImg1');
	var addImg2 = $('#addImg2');
	var nameImg1 = $('#nameImg1');
	var nameImg2 = $('#nameImg2');

	var loadDylematImg = $('#loadDylematImg');
	loadDylematImg.hide();

	var divError = $('#errorMinTime');
	divError.hide();

	var errorAddDylemat = $('#errorAddDylemat');
	errorAddDylemat.hide();

	saveBoxDylemat.hide();

	function saveDylemat() {
		var dataSaveDylemat = '';
		errorAddDylemat.hide('blind', speed_animation);
		loadDylematImg.show('blind', speed_animation);
		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/saveDylemat.php",
			data: formAddDylemat.serialize(),
			dataType: 'json',
			cache: false,
			success: function (resp) {
				loadDylematImg.hide();
				dataSaveDylemat = resp;
				//console.log(dataSaveDylemat);
				if (dataSaveDylemat['error'] == 'corectAll') {
					//заповняємо поля даними після збереження
					insertText.text(dataSaveDylemat['text']);
					insertAsk1.text(dataSaveDylemat['ask1']);
					insertAsk2.text(dataSaveDylemat['ask2']);

					addImg1.html('<span>' + arrayLanguage['img1'] + ':</span><br><img class="img-100 brr-4" src="' + dataSaveDylemat['img1'] + '">');
					addImg2.html('<span>' + arrayLanguage['img2'] + ':</span><br><img class="img-100 brr-4" src="' + dataSaveDylemat['img2'] + '">');

					nameImg1.text();
					nameImg2.text();
					nameImg1.hide();
					nameImg2.hide();
					w1 = w2 = h1 = h2 = 0;
					rotationImg1 = 0;
					rotationImg2 = 0;
					$('input[name=rotationImg1]').val(rotationImg1);
					$('input[name=rotationImg2]').val(rotationImg2);

					addBoxDylemat.hide('blind', 1500, function () {
						saveBoxDylemat.show('blind', 1500);
					});
				}
				else {
					errorAddDylemat.html(arrayLanguage['error_contact']);
					errorAddDylemat.show('blind', speed_animation);

					switch (dataSaveDylemat['error']) {
						case 'errorIsset':
							//console.log('errorIsset...');
							break;
						case 'errorEmpty':
							//console.log('errorEmpty...');
							break;
						case 'errorMinTime':
							errorMinTime();
							//console.log('errorMinTime...');
							break;
						case 'errorDB':
							//console.log('errorDB...');
							break;
						default:
							//console.log('i dont now...');
							break;
					}

				}
			},
			error: function (req, status, err) {

				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//****************************************************
	//натискаємо на кнопку додати ще дилемат
	//****************************************************
	btn_add_Dylemat.on('click', function () {
		text_Input.val('');
		ask1_Input.val('');
		ask2_Input.val('');

		$('input[name=img1]').val('');
		$('input[name=img2]').val('');
		$('input[name=privat]').prop("checked", false);

		$('#files1').html('');
		$('#files2').html('');

		$('#upload1').show();
		$('#upload2').show();

		loadDylematImg.hide();

		saveBoxDylemat.hide('blind', 1500, function () {
			addBoxDylemat.show('blind', 1500);
		});
	});
	//****************************************************
	//перевірка форми на заповнення полів перед відправкою
	//****************************************************
	btn_send_ADylemat.on('click', function () {
		var divErrorInput = '<div class="errorClearInput mbottom-05 error brr-4 letter-sp fs-9 lheight-13 bshadow"></div>';
		var textErrorInput = arrayLanguage['empty_input'] + ':<br>';

		text_Input = $('#text_Input');
		ask1_Input = $('#ask1_Input');
		ask2_Input = $('#ask2_Input');

		if (text_Input.val().length < 2 || ask1_Input.val().length < 2 || ask2_Input.val().length < 2) {
			if (text_Input.val().length < 2) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['ask'] + '</span><br>';
			}
			if (ask1_Input.val().length < 2) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['answer1'] + '</span><br>';
			}
			if (ask2_Input.val().length < 2) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['answer2'] + '</span><br>';
			}
			textErrorInput += arrayLanguage['min2'];
			if ($("div").is(".errorClearInput")) {
				$("div.errorClearInput").html(textErrorInput);
			}
			else {
				$('#dodaj-dylemat').after(divErrorInput);
				$("div.errorClearInput").html(textErrorInput);
			}
		}
		else {
			//formAddDylemat.submit();
			$("div.errorClearInput").remove();
			saveDylemat();
		}
	});
	//*******************************************************************
	//якщо є поле з помилкою частого відсилання запитів,
	//то запускаємо таймен на 1 хв, а по закінченні - сигналізуємо про це
	//*******************************************************************
	var countError = 60;
	var sekundy = $('#sekundy');
	sekundy.text(countError);
	var timerSet = 0;
	var textErrorMinTime = arrayLanguage['min_time1'] + '<span id="sekundy"></span>' + arrayLanguage['min_time2'];

	function errorMinTime() {
		divError.html(textErrorMinTime);
		divError.show('fade');
		sekundy = $('#sekundy');

		btn_send_ADylemat.prop('disabled', true);
		timerSet = setInterval(function () {
			sekundy.text(countError);
			if (countError == 0) {
				clearInterval(timerSet);
				divError.removeClass('error');
				divError.addClass('ok');
				divError.text(arrayLanguage['min_time3']);
				btn_send_ADylemat.prop('disabled', false);
				countError = 60;
				setTimeout(function () {
					divError.hide("fade", 1500, function () {
						divError.removeClass('ok');
						divError.addClass('error');
					});

				}, 5000);
			}
			countError--;
		}, 1000);
	}

	//**********************************************************
	//**********************************************************
	//contact form
	//**********************************************************
	//**********************************************************
	var btn_saveContact = $('#btn-saveContact');

	var formAddContact = $('#formAddContact');

	var contactBoxFirst = $('#contactBoxFirst');
	var contactBoxEnd = $('#contactBoxEnd');

	//поля форми для введення даних
	var c_name_Input = $('#c_name_Input');
	var c_email_Input = $('#c_email_Input');
	var c_thema_Input = $('#c_thema_Input');
	var c_message_Input = $('#c_message_Input');

	//поля після збереження дилемата
	var contactAnswer = $('#contactAnswer');

	var divError_contact = $('#errorMinTime-contact');
	divError_contact.hide();
	contactBoxEnd.hide();

	$('#insertWH').text('w: ' + window_width + ' h:' + window_height);

	function saveContact() {
		var dataSaveContact = '';

		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/saveContact.php",
			data: formAddContact.serialize(),
			dataType: 'json',
			cache: false,
			success: function (resp) {
				dataSaveContact = resp;
				//console.log(dataSaveContact);
				if (dataSaveContact['error'] == 'corectAll') {
					//заповняємо поля даними після збереження
					contactBoxFirst.hide('blind', 1500, function () {
						contactAnswer.prepend('<span class="color-orange">' + dataSaveContact['name'] + '</span>, ');
						$('#emailInsert').text(dataSaveContact['email']);
						contactBoxEnd.show('blind', 1500);
					});

					if($('div').is('#history_messages')){
						insert_history_messages($('#history_messages').attr('data-id-user'));
					}
				}
				else {
					switch (dataSaveContact['error']) {
						case 'errorIsset':
							//console.log('errorIsset...');
							break;
						case 'errorEmpty':
							//console.log('errorEmpty...');
							break;
						case 'errorMinTime':
							errorMinTime_contact();
							//console.log('errorMinTime...');
							break;
						case 'errorDB':
							//console.log('errorDB...');
							break;
						default:
							//console.log('i dont now...');
							break;
					}

				}
			},
			error: function (req, status, err) {
				//dataIMG.children('p').css({'height': dataIMG.children('img').css('height')}).html('przepraszam, ale serwer jest tymczasowo niedostępny').show('fade', 1000);
				//('что-то пошло не так', status, err);
			}
		});
	}

	//****************************************************
	//перевірка форми на заповнення полів перед відправкою
	//****************************************************
	btn_saveContact.on('click', function () {
		var divErrorInput = '<div class="errorClearInput error brr-4 letter-sp fs-9 lheight-13 mbottom-05 bshadow"></div>';
		var textErrorInput = arrayLanguage['empty_input'] + ':<br>';

		c_name_Input = $('#c_name_Input');
		c_email_Input = $('#c_email_Input');
		c_message_Input = $('#c_message_Input');

		var email_bool_contact = '';
		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		email_bool_contact = pattern.test(c_email_Input.val());

		if (c_name_Input.val().length < 4 || c_email_Input.val().length < 4 || c_thema_Input.val().length < 4 || c_message_Input.val().length < 4 || !email_bool_contact) {
			if (c_name_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['name'] + '</span><br>';
			}
			if (c_email_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['email'] + '</span><br>';
			}
			else {
				if (!email_bool_contact) {
					textErrorInput += '<span class="color-red">' + arrayLanguage['wrong_email'] + '</span><br>';
				}
			}
			if (c_thema_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['your_thema'] + '</span><br>';
			}
			if (c_message_Input.val().length < 4) {
				textErrorInput += '<span class="color-red">' + arrayLanguage['your_ask'] + '</span><br>';
			}
			textErrorInput += arrayLanguage['min4'];
			if ($("div").is(".errorClearInput")) {
				$("div.errorClearInput").html(textErrorInput);
			}
			else {
				$('#contactName').after(divErrorInput);
				$("div.errorClearInput").html(textErrorInput);
			}
		}
		else {
			$("div.errorClearInput").remove();
			saveContact();
		}
	});
	//*******************************************************************
	//якщо є поле з помилкою частого відсилання запитів,
	//то запускаємо таймен на 1 хв, а по закінченні - сигналізуємо про це
	//*******************************************************************
	var countError_contact = 60;
	var sekundy_contact = $('#sekundy-contact-form');
	sekundy_contact.text(countError_contact);
	var timerSet_contact = 0;
	var textErrorMinTime_contact = arrayLanguage['min_time1'] + '<span id="sekundy-contact-form" class="color-darkblue"></span>' + arrayLanguage['min_time2'];

	function errorMinTime_contact() {
		divError_contact.html(textErrorMinTime_contact);
		divError_contact.show('fade');
		sekundy_contact = $('#sekundy-contact-form');

		btn_saveContact.css({'pointer-events': 'none'});
		timerSet_contact = setInterval(function () {
			sekundy_contact.text(countError_contact);
			if (countError_contact == 0) {
				clearInterval(timerSet_contact);
				divError_contact.removeClass('error');
				divError_contact.addClass('ok');
				divError_contact.text(arrayLanguage['min_time3']);
				btn_saveContact.css({'pointer-events': 'auto'});
				countError_contact = 60;
				setTimeout(function () {
					divError_contact.hide("fade", 1500, function () {
						divError_contact.removeClass('ok');
						divError_contact.addClass('error');
					});

				}, 5000);
			}
			countError_contact--;
		}, 1000);
	}

	//**********************************************************
	//виводимо історію переписування
	//**********************************************************
	var history_messages = $('#history_messages');
	var data_id_user = history_messages.attr('data-id-user');
	if($('div').is('#history_messages')){
		insert_history_messages(data_id_user);
	}
	function insert_history_messages(id_user) {
		history_messages.html('<span class="item-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw fs-14 color-blue"></i><span class="color-darkblue"> LOAD HISTORY...</span></span>');

		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/saveContact.php",
			data: {'history': id_user},
			cache: false,
			success: function (resp) {
				//console.log(JSON.parse(resp));
				//console.log(resp);
				var result = JSON.parse(resp);
				var str_to_insert = '';
				if(result['error'] == 'ok'){
					result['history'].forEach(function (box_message) {
						if(box_message['send_admin'] == '0'){
							str_to_insert+='<div class="item-start flex-column aitems-start border w-90 brr-4 bshadow m-02 p-02">' +
								'<span class="color-grey">name: <span class="color-blue fw-bold no-upper">' + box_message['name'] +'</span></span>' +
								'<span class="color-grey">date: <span class="color-blue">' + box_message['date'] +'</span></span>' +
								'<span class="color-grey">thema:</span>' +
								'<span class="color-blue no-upper">' + box_message['thema'] +'</span>' +
								'<hr class="hr-05"/> ' +
								'<span class="color-darkblue no-upper">' + box_message['text'] +'</span>' +
								'</div>';
						}
						else {
							str_to_insert+='<div class="item-end flex-column aitems-end brc-blue w-90 brr-4 bshadow m-02 p-02">' +
								'<span class="color-grey fw-bold no-upper">' + box_message['name'] +'</span>' +
								'<span class="color-grey">date: <span class="color-blue">' + box_message['date'] +'</span></span>' +
								'<span class="color-grey">thema:</span>' +
								'<span class="color-blue no-upper">' + box_message['thema'] +'</span>' +
								'<hr class="hr-05"/> ' +
								'<span class="color-darkblue no-upper">' + box_message['text'] +'</span>' +
								'</div>';
						}
					});

					history_messages.html(str_to_insert);
				}
				else{
					history_messages.html('');
				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
	}
	//**********************************************************
	//end contact form -----------------------------------------
	//**********************************************************

	//**********************************************************
	//розветаємо поле для реєстрації, входу та титульну сторінку
	//**********************************************************
	var indexPage = $('input[name=page]');

	var box_Login = $('#login');
	var box_Registration = $('#registration');
	var box_FirstPage = $('#first-page');

	var btn_OpenRegistration = $('#open-box-registration');
	var btn_CloseRegistration = $('#close-box-registration');

	var btn_OpenLogin = $('#open-box-login');
	var btn_CloseLogin = $('#close-box-login');

	//очищаємо дані при натисканні кнопки назад на формі зверху
	function clearInputForm() {
		pass_Input.val('');
		pass2_Input.val('');
		$('#emailReg').val('');
		errorPassReg.hide();
		if ($("div").is(".errorClearInput")) {
			$("div.errorClearInput").remove();
		}
		passCorect = false;
		existUserBool = false;

		$('#nameInsite').val('');
		$('#emailInsite').val('');
	}

	box_Login.hide();
	box_Registration.hide();

	if (indexPage.val() == 'enter') {
		box_FirstPage.hide('blind', speed_animation, function () {
			box_Login.show('blind', speed_animation);
		});
	}
	if (indexPage.val() == 'registr') {
		box_FirstPage.hide('blind', speed_animation, function () {
			box_Registration.show('blind', speed_animation);
		});
	}

	//натискаємо кнопку реєстрації
	btn_OpenRegistration.on('click', function () {
		box_FirstPage.hide('blind', speed_animation, function () {
			box_Registration.show('blind', speed_animation);
		});
	});
	btn_CloseRegistration.on('click', function () {
		box_Registration.hide('blind', speed_animation, function () {
			box_FirstPage.show('blind', speed_animation);
			clearInputForm();
		});
	});

	//натискаємо кнопку входу
	btn_OpenLogin.on('click', function () {
		box_FirstPage.hide('blind', speed_animation, function () {
			box_Login.show('blind', speed_animation);
		});
	});
	btn_CloseLogin.on('click', function () {
		box_Login.hide('blind', speed_animation, function () {
			box_FirstPage.show('blind', speed_animation);
			clearInputForm();
		});
	});
	//*****************************************************************
	//виводимо назви дилематів відповідно до категорії та характеристик
	//*****************************************************************
	var kategoria_Info = $('#kategoria');
	var myDylematId = $('input[name=myDylematId]').val();
	var myDylematName = $('#myDylematName>span:first-child');
	var privatShowDylemat = $('input[name=privat]').val();

	var infoAddLast = $('#addLast');
	var infoBestView = $('#bestView');
	var privatDylematBox = $('#privatDylematBox');

	//кнопка відкриття блоку приватних дилематів
	var privatDylematButton = $('#privatDylematButton');
	privatDylematButton.hide();
	var privatDylematButtonShow = false;
	privatDylematButton.on('click', function () {
		if (privatDylematButtonShow) {
			privatDylematBox.hide('blind', speed_animation);
			privatDylematButtonShow = false;
			$('#privatDylematButton>i').toggleClass('fa-flip-vertical');
		}
		else {
			privatDylematBox.show('blind', speed_animation);
			privatDylematButtonShow = true;
			$('#privatDylematButton>i').toggleClass('fa-flip-vertical');
		}

	});

	//кнопка відкриття під-блоку приватних дилематів останьо-доданих
	var privatDylematAddLastButton = $('#privatDylematAddLastButton');
	var privatDylemat_addLast = $('#privatDylemat_addLast');
	privatDylemat_addLast.hide();
	var privatDylemat_addLastShow = false;
	privatDylematAddLastButton.on('click', function () {
		if (privatDylemat_addLastShow) {
			privatDylemat_addLast.hide('blind', speed_animation);
			privatDylemat_addLastShow = false;
			$('#privatDylematAddLastButton>i').toggleClass('fa-flip-vertical');
		}
		else {
			privatDylemat_addLast.show('blind', speed_animation);
			privatDylemat_addLastShow = true;
			$('#privatDylematAddLastButton>i').toggleClass('fa-flip-vertical');
		}

	});

	//кнопка відкриття під-блоку приватних дилематів найпопулярніших
	var privatDylematBestViewButton = $('#privatDylematBestViewButton');
	var privatDylemat_bestView = $('#privatDylemat_bestView');
	privatDylemat_bestView.hide();
	var privatDylemat_bestViewShow = false;
	privatDylematBestViewButton.on('click', function () {
		if (privatDylemat_bestViewShow) {
			privatDylemat_bestView.hide('blind', speed_animation);
			privatDylemat_bestViewShow = false;
			$('#privatDylematBestViewButton>i').toggleClass('fa-flip-vertical');
		}
		else {
			privatDylemat_bestView.show('blind', speed_animation);
			privatDylemat_bestViewShow = true;
			$('#privatDylematBestViewButton>i').toggleClass('fa-flip-vertical');
		}
	});

	var resultSersh = $('#resultSersh');
	var navigationSersh = $('#navigationSersh');

	var sershString = $('#sershString');

	var sershLoad = $('.sershLoad');
	var sershOk = $('#sershOk');
	var sershNo = $('#sershNo');

	var firstPage = $('#firstPage');
	var stepLeftPage = $('#stepLeftPage');
	var stepRightPage = $('#stepRightPage');
	var lastPage = $('#lastPage');


	var nextPage = 0;
	var lastPageIndex = 0;

	var loadDylematIcon = $('.loadDylematIcon');
	loadDylematIcon.hide();

	navigationSersh.hide();
	sershLoad.hide();
	sershOk.hide();
	sershNo.hide();

	privatDylematBox.hide();

	stepRightPage.val(0);
	stepLeftPage.val(0);

	firstPage.on('click', function () {
		updateInfoKategor(kategoria_Info.val(), sershString.val(), 0, myDylematId, privatShowDylemat);
	});
	stepRightPage.on('click', function () {
		if (($(this).val() ) != lastPageIndex)
			updateInfoKategor(kategoria_Info.val(), sershString.val(), $(this).val(), myDylematId, privatShowDylemat);
	});
	stepLeftPage.on('click', function () {
		if (($(this).val() != 0))
			updateInfoKategor(kategoria_Info.val(), sershString.val(), $(this).val() - 1, myDylematId, privatShowDylemat);
	});
	lastPage.on('click', function () {
		updateInfoKategor(kategoria_Info.val(), sershString.val(), lastPageIndex - 1, myDylematId, privatShowDylemat);
	});

	if (truePage('showInfoDylemat')) {
		updateInfoKategor(kategoria_Info.val(), sershString.val(), nextPage, myDylematId, privatShowDylemat);

		kategoria_Info.change(function () {
			updateInfoKategor($(this).val(), sershString.val(), nextPage, myDylematId, privatShowDylemat);
		});

		sershString.keyup(function () {
			updateInfoKategor(kategoria_Info.val(), sershString.val(), nextPage, myDylematId, privatShowDylemat);
		});
	}
	function updateInfoKategor(kategor, sershString, nextPage, myDylematId, privatShowDylemat) {
		var updateData = '';
		infoAddLast.empty();
		infoBestView.empty();
		privatDylemat_addLast.empty();
		privatDylemat_bestView.empty();

		loadDylematIcon.show();
		sershLoad.show();
		sershOk.hide();
		sershNo.hide();

		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/returnArrayInfo.php",
			data: {
				'kategoria': kategor,
				'sershString': sershString,
				'nextPage': nextPage,
				'myDylematId': myDylematId,
				'privat': privatShowDylemat
			},
			cache: false,
			success: function (resp) {
				//console.log(resp);
				updateData = JSON.parse(resp);
				//console.log(updateData);
				myDylematName.text(updateData['name']);
				if (updateData['error'] == 'good') {
					loadDylematIcon.hide();
					sershLoad.hide();
					sershOk.show();
					sershNo.hide();

					resultSersh.html(arrayLanguage['find'] + ': <span class="color-darkblue">' + updateData['countRow'] + '</span>' + arrayLanguage['dylemat']);

					//визначаємо кількість сторіннок
					lastPageIndex = (parseInt(updateData['countRow'] / 10)) + ((updateData['countRow'] % 10 > 0) ? 1 : 0);
					//визначаємо на якій ми сторінці
					nextPage = parseInt(updateData['page']);

					if (updateData['countRow'] > 10) {
						//вставляємо номер текучої сторінки
						$('span#nextPage').text(nextPage + 1);

						//вставляємо номер останьої сторінки
						$('#lastPage>span').text(lastPageIndex);

						//вставляємо індекс попередньої сторінки в силку
						stepLeftPage.val(nextPage);
						//вставляємо індекс наступної сторінки в силку
						stepRightPage.val(nextPage + 1);

						navigationSersh.show('blind', speed_animation);
					}
					else {
						navigationSersh.hide('blind', speed_animation);
					}

					var existPrivat = false;
					updateData['last'].forEach(function (element) {
						if (element['privat'] == '1') {
							privatDylematButton.show();
							existPrivat = true;
							return true;
						}
					});

					//перебираємо дилемати, які останніми були додані та скриті дилемати
					updateData['last'].forEach(function (arrayDylemat) {
						if (existPrivat) {
							if (arrayDylemat['privat'] == '0') {
								infoAddLast.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + '" class="link-black-orange brr-4 p-02 bshadow word-wrap mbottom-05">' +
									'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
							}
							else {
								//скриті дилемати
								privatDylemat_addLast.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + arrayDylemat['code'] + '" class="flex-column mbottom-05 p-02 link-white-red brr-4 word-wrap bshadow">' +
									'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
							}
						}
						else {
							infoAddLast.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + '" class="link-black-orange brr-4 p-02 bshadow word-wrap mbottom-05">' +
								'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
						}
					});
					//перебираємо дилемати, які набільше проглядалися та скриті дилемати
					updateData['views'].forEach(function (arrayDylemat) {
						if (existPrivat) {
							if (arrayDylemat['privat'] == '0') {
								infoBestView.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + '" class="link-black-orange brr-4 p-02 bshadow word-wrap mbottom-05">' +
									'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
							}
							else {
								//скриті дилемати
								privatDylemat_bestView.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + arrayDylemat['code'] + '" class="flex-column mbottom-05 p-02 link-white-red brr-4 word-wrap bshadow">' +
									'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
							}
						}
						else {
							infoBestView.append('<a id="" href="' + '/showDylemat/' + arrayDylemat['id'] + '" class="link-black-orange brr-4 p-02 bshadow word-wrap mbottom-05">' +
								'<span class="color-darkblue">' + arrayDylemat['text'] + '</span></a>');
						}
					});
				}
				else {
					loadDylematIcon.hide();
					sershLoad.hide();
					sershOk.hide();
					sershNo.show();
					resultSersh.html('niestety, nic nie znaleziono');

					var textinsert = arrayLanguage['no_find'] + '</span>';

					infoAddLast.html('<span class="color-darkblue border brr-4 bshadow">' + textinsert + '</span>');
					infoBestView.html('<span class="color-darkblue border brr-4 bshadow">' + textinsert + '</span>');

					resultSersh.html(arrayLanguage['no_find_small']);
					navigationSersh.hide('blind', speed_animation);
				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//************************************************************
	//виводимо дані про додані дилемати за весь час та за сьогодні
	//************************************************************
	updateAllInfo();

	function updateAllInfo() {
		var updateData = '';
		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/returnArrayDylemat.php",
			data: {'count': '1'},
			cache: false,
			success: function (resp) {
				updateData = JSON.parse(resp);
				//console.log(updateData);
				if (updateData['error'] == 'good') {
					$('#allInfo>span:first-child').text(updateData['addAll']);
					$('#allInfo>span:last-child').text(updateData['addNow']);
				}
				else {
					//console.log(updateData.error);
				}
			},
			error: function (req, status, err) {
				//console.log('что-то пошло не так', status, err);
			}
		});
		setTimeout(updateAllInfo, 60000);
	}

	//*******************************************************
	//вибір зображення, відправлення запроса з вибором,
	//отримання результатів та нове питання
	//*******************************************************
	//вибираємо зображення та встановлюємо номер вибраного зображення в скрите поле
	var clickImgBool = false;

	var imgBox_1 = $('#img-1');
	var imgBox_2 = $('#img-2');

	var imgBox_1_img = $('#img-1>img');
	var imgBox_2_img = $('#img-2>img');

	var linkImg1 = $('#linkImg1');
	var linkImg2 = $('#linkImg2');

	var errorUsedBox = $('#errorUsed');
	errorUsedBox.hide();

	var speed_animation_info = 1500;

	//перевіряємо чи користувач увійшов на сайт,
	//якщо так, то дозволяємо оцінювати
	//інакше виводим відповідне повідомлення
	var canUsedImg = function () {
		return $('input').is('[name=den1]');
	};

	//натискажмо на кнопку (силка)
	linkImg1.on('click', function () {
		if (canUsedImg() && userClick) {
			if (!clickImgBool) {
				if (window.innerWidth >= Width_1) {
					linkImg2.remove();
					imgBox_2.animate({
						'width': 0
					}, speed_animation_info, function () {
						imgBox_2.remove();
						linkImg1.remove();
					});
				}
				else {
					imgBox_2.animate({
						'height': 0
					}, speed_animation_info, function () {
						imgBox_2.remove();
						linkImg1.remove();
					});
				}
				$('#img-1>img').animate({
					'opacity': 0.1,
					'filter': 'alpha(opacity=10)'
				}, speed_animation_info);
				saveAndBackInfo(imgBox_1, 1);
				clickImgBool = true;
				refresh = true;
			}
		}
		else if (canUsedImg() && !userClick) {
			//якщо користувач вже оцінив даний дилемат, то вставвляємо текст його оцінки в відповідне поле
			errorUsedBox.html(arrayLanguage['click1'] + '<span class="color-orange">' + arrayLanguage['answer'][askAnswer_id] + '</span> ' + arrayLanguage['click2']);
			if (askAnswer_id == '1')
				$('#img-1').addClass('bgc-orange');
			else
				$('#img-2').addClass('bgc-orange');
			errorUsedBox.show('blind', speed_animation);
		}
		else {
			errorUsedBox.show('blind', speed_animation);
		}
	});
	linkImg2.on('click', function () {
		if (canUsedImg() && userClick) {
			if (!clickImgBool) {
				if (window.innerWidth >= Width_1) {
					linkImg1.remove();
					imgBox_1.animate({
						'width': 0
					}, speed_animation_info, function () {
						imgBox_1.remove();
						linkImg2.remove();
					});
				}
				else {
					imgBox_1.animate({
						'height': 0
					}, speed_animation_info, function () {
						imgBox_1.remove();
						linkImg2.remove();
					});
				}
				$('#img-2>img').animate({
					'opacity': 0.1,
					'filter': 'alpha(opacity=10)'
				}, speed_animation_info);
				saveAndBackInfo(imgBox_2, 2);
				clickImgBool = true;
				refresh = true;
			}
		}
		else if (canUsedImg() && !userClick) {
			//якщо користувач вже оцінив даний дилемат, то вставвляємо текст його оцінки в відповідне поле
			errorUsedBox.html(arrayLanguage['click1'] + '<span class="color-orange">' + arrayLanguage['answer'][askAnswer_id] + '</span> ' + arrayLanguage['click2']);
			if (askAnswer_id == '1')
				$('#img-1').addClass('bgc-orange');
			else
				$('#img-2').addClass('bgc-orange');
			errorUsedBox.show('blind', speed_animation);
		}
		else {
			errorUsedBox.show('blind', speed_animation);
		}
	});

	//натискаэмо на зображення
	imgBox_1_img.on('click', function () {
		bigImg(img1Big, widthBigImg1, heightBigImg1);
	});
	imgBox_2_img.on('click', function () {
		bigImg(img2Big, widthBigImg2, heightBigImg2);
	});

	//збільшуємо зображення при кліку на ньому
	var bigImgBox = $('#bigImgContainer');
	var ImgBoxInsert = $('#bigImgImg');
	var bigImgItem = $('#bigImgItem');

	bigImgBox.hide();
	var bigImgBoxShow = false;

	bigImgBox.on('click', function () {
		bigImg();
	});
	function bigImg(imgRef, wImg, hImg) {
		if (bigImgBoxShow) {
			bigImgBox.hide('fade');
			bigImgBoxShow = false;
		}
		else {
			ImgBoxInsert.attr({'src': imgRef, 'alt': imgRef});
			var newWidthImg = 0;
			var newHeightImg = 0;

			//console.log(widthBigImg1 + ' ' + window.innerWidth);

			if (wImg > (window.innerWidth * 0.9) || hImg > (window.innerHeight * 0.88)) {
				if (wImg > hImg) {
					newWidthImg = window.innerWidth * 0.6;
					ImgBoxInsert.css({'width': newWidthImg, 'height': 'auto'});
				}
				else {
					newHeightImg = window.innerHeight * 0.65;
					ImgBoxInsert.css({'width': 'auto', 'height': newHeightImg});
				}
			}
			//console.log($(window).height());
			//console.log(document.body.clientHeight);
			bigImgBox.show('fade');
			bigImgBoxShow = true;
		}
	}

	//*********************************************************
	//ajax запрос, зберігаємо результати та виводимо інформацію
	//*********************************************************
	function saveAndBackInfo(dataIMG, numerImg) {
		var dataBackInfo = '';
		var iduser = $('input[name=iduser]');
		$.ajax({
			type: 'POST',
			url: "../ajaxPHP/backInfoAndSave.php",
			data: {'numerImg': numerImg, 'idDylemat': idDylemat, 'iduser': iduser.val()},
			cache: false,
			success: function (resp) {
				dataBackInfo = JSON.parse(resp);
				//console.log(resp);
				if (dataBackInfo['error'] == 'good') {
					loadDylemat();
					dataIMG.children('p').css({'height': dataIMG.children('img').css('height')})
						.html(arrayLanguage['click3'] + ':<br/><span class="color-darkblue">' + ((numerImg == 1) ? img1_yes : img2_yes) + '</span> ' + arrayLanguage['user'] + '<br><hr class="hr-05 mtb-10 w-80">' +
							arrayLanguage['click4'] + ':<br/> <span class="color-darkblue">' + ((numerImg == 1) ? img2_yes : img1_yes) + '</span> ' + arrayLanguage['user']).show('fade', 1500);
				}
				else {
					switch (dataBackInfo['error']) {
						case 'errorIsset':
							//console.log('errorIsset...');
							break;
						case 'errorEmpty':
							//console.log('errorEmpty...');
							break;
						case 'errorBD':
							//console.log('errorBD...');
							break;
						default:
							//console.log('i dont now...');
							break;
					}
					dataIMG.children('p').css({'height': dataIMG.children('img').css('height')}).html(arrayLanguage['error_server']).show('fade', 1000);
				}
			},
			error: function (req, status, err) {
				dataIMG.children('p').css({'height': dataIMG.children('img').css('height')}).html(arrayLanguage['error_server']).show('fade', 1000);
				//console.log('что-то пошло не так', status, err);
			}
		});
	}

	//коли вже все завантажилося, то показуємо сторінку
	$('html').show();
});

//ajax запрос, видаляємо зображення до загрузки на сервер
var w1 = 0;
var h1 = 0;
var w2 = 0;
var h2 = 0;

var rotationImg1Input = $('input[name=rotationImg1]');
var rotationImg2Input = $('input[name=rotationImg2]');

var img1rotate = $('#img1rotate');
var img1Cont = $('#img1Cont');

var img2rotate = $('#img2rotate');
var img2Cont = $('#img2Cont');

function rotateImg(e) {
	rotationImg1Input = $('input[name=rotationImg1]');
	rotationImg2Input = $('input[name=rotationImg2]');

	img1rotate = $('#img1rotate');
	img1Cont = $('#img1Cont');

	img2rotate = $('#img2rotate');
	img2Cont = $('#img2Cont');

	if (w1 == 0 || !w1 || w1 == undefined) {
		w1 = parseInt(img1rotate.css('width'));
		h1 = parseInt(img1rotate.css('height'));
	}
	if (w2 == 0 || !w2 || w2 == undefined) {
		w2 = parseInt(img2rotate.css('width'));
		h2 = parseInt(img2rotate.css('height'));
	}

	if (e == 'btn-rotate1') {
		rotationImg1+=90;
		if(rotationImg1==360){
			rotationImg1=0;
		}
		rotationImg1Input.val(rotationImg1);
		if(w1 > h1) {
			if (rotationImg1 == 0) {
				img1Cont.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': w1, 'height': 'auto'});
			}
			else if (rotationImg1 == 90) {
				img1Cont.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': 'auto', 'height': w1});
			}
			else if (rotationImg1 == 180) {
				img1Cont.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': w1, 'height': 'auto'});
			}
			else if (rotationImg1 == 270) {
				img1Cont.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': 'auto', 'height': w1});
			}
		}
		else{
			if (rotationImg1 == 0) {
				img1rotate.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': w1, 'height': 'auto'});
			}
			else if (rotationImg1 == 90) {
				img1rotate.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': 'auto', 'height': w1});
			}
			else if (rotationImg1 == 180) {
				img1rotate.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': w1, 'height': 'auto'});
			}
			else if (rotationImg1 == 270) {
				img1rotate.css({'transform': 'rotate(' + rotationImg1 + 'deg)', 'width': 'auto', 'height': w1});
			}
		}
	}
	else if (e == 'btn-rotate2') {
		rotationImg2+=90;
		if(rotationImg2==360){
			rotationImg2=0;
		}
		rotationImg2Input.val(rotationImg2);
		if(w2 > h2) {
			if (rotationImg2 == 0) {
				img2Cont.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': w2, 'height': 'auto'});
			}
			else if (rotationImg2 == 90) {
				img2Cont.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': 'auto', 'height': w2});
			}
			else if (rotationImg2 == 180) {
				img2Cont.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': w2, 'height': 'auto'});
			}
			else if (rotationImg2 == 270) {
				img2Cont.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': 'auto', 'height': w2});
			}
		}
		else{
			if (rotationImg2 == 0) {
				img2rotate.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': w2, 'height': 'auto'});
			}
			else if (rotationImg2 == 90) {
				img2rotate.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': 'auto', 'height': w2});
			}
			else if (rotationImg2 == 180) {
				img2rotate.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': w2, 'height': 'auto'});
			}
			else if (rotationImg2 == 270) {
				img2rotate.css({'transform': 'rotate(' + rotationImg2 + 'deg)', 'width': 'auto', 'height': w2});
			}
		}
	}
}
//ajax запрос, видаляємо зображення до загрузки на сервер
function detectImg(e) {
	var btnUpload1 = $('#upload1');
	var btnUpload2 = $('#upload2');
	var inputHiddenImg1 = $('input[name=img1]');
	var inputHiddenImg2 = $('input[name=img2]');

	if (e == 'btn-del1') {
		if(!deleteImg(inputHiddenImg1.attr('value'))) {
			inputHiddenImg1.attr('value', '');
			btnUpload1.show('blind');
			$('#files1').html('');
			var nameImg1 = $('#nameImg1');
			nameImg1.text();
			nameImg1.hide();
			w1=0;
			h1=0;
			rotationImg1 = 0;
			$('input[name=rotationImg1]').val(rotationImg1);
		}
		else{
			var divErrorInput_del = '<div class="errorClearInput error brr-4 letter-sp fs-9 lheight-13"></div>';
			var textErrorInput_del = arrayLanguage['no_delete_img'];
			if ($("div").is(".errorClearInputDelet")) {
				$("div.errorClearInputDelet").html(textErrorInput_del);
			}
			else {
				$('#dodaj-dylemat').after(divErrorInput_del);
				$("div.errorClearInput").html(textErrorInput_del);
			}
		}
	}
	else if (e == 'btn-del2') {
		if(!deleteImg(inputHiddenImg2.attr('value'))) {
			inputHiddenImg2.attr('value', '');
			btnUpload2.show('blind');
			$('#files2').html('');
			var nameImg2 = $('#nameImg2');
			nameImg2.text();
			nameImg2.hide();
			w2=0;
			h2=0;
			rotationImg2 = 0;
			$('input[name=rotationImg2]').val(rotationImg2);
		}else{
			var divErrorInput_del = '<div class="errorClearInput error brr-4 letter-sp fs-9 lheight-13"></div>';
			var textErrorInput_del = arrayLanguage['no_delete_img'];
			if ($("div").is(".errorClearInputDelet")) {
				$("div.errorClearInputDelet").html(textErrorInput_del);
			}
			else {
				$('#dodaj-dylemat').after(divErrorInput_del);
				$("div.errorClearInput").html(textErrorInput_del);
			}
		}
	}
}
function deleteImg(nameImg) {
	$.ajax({
		type:'POST',
		url: "../ajaxPHP/deleteImg.php",
		data:'nameImg=' + nameImg,
		cache: false,
		success: function(resp) {
			//console.log(resp);
			return resp;
		},
		error: function(req, status, err){
			//console.log('что-то пошло не так', status, err);
		}
	});
}