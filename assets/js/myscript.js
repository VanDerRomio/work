$(function() {
	//******************************************************
	//дії по замочуванні
	//******************************************************
	//глобальні змінні
	//var httpSite = location.hostname;
	var speed_animation = 700;

	//отримуємо масив даних для показу питання
	/*function loadDylemat() {
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

	//*******************************************************
	//дії при зміні розмірів вікна
	//*******************************************************
	$(window).resize(function (e) {

	});
	//*******************************************************
	//дії при скролі сторінки
	//*******************************************************
	$(window).scroll(function (e) {

	});
	//*******************************************************
	//основні скріпти
	//*******************************************************
	//**********************************************************
	//contact form
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
	*/
});