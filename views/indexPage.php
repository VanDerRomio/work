<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.12.2016
 * Time: 17:16
 */
//**********************************************
//FaceBook
//**********************************************
require_once ROOT.'/components/facebook-sdk-v5/autoload.php';
$fb = new Facebook\Facebook([
	'app_id' => CLIENT_ID_FB,
	'app_secret' => CLIENT_SECRET_FB,
	'default_graph_version' => 'v2.5',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'public_profile', 'user_friends']; // optional
$loginUrl = $helper->getLoginUrl(HTTP_ENTER_FACEBOOK_BACK, $permissions);
define('HTTP_ENTER_FACEBOOK', $loginUrl);
//**********************************************
//GPlus
//**********************************************
include_once (ROOT.'/components/google-sdk/src/Google_Client.php');
include_once (ROOT.'/components/google-sdk/src/contrib/Google_Oauth2Service.php');
$clientId_GP = CLIENT_ID_GPus;
$clientSecret_GP = CLIENT_SECRET_GPlus;
$redirectURL_GP = HTTP_ENTER_GPLUS;
$gClient = new Google_Client();
$gClient->setApplicationName(HTTP_SITE_NAME);
$gClient->setClientId($clientId_GP);
$gClient->setClientSecret($clientSecret_GP);
$gClient->setRedirectUri($redirectURL_GP);
$google_oauthV2 = new Google_Oauth2Service($gClient);
$authUrl_GP = $gClient->createAuthUrl();
define('HTTP_ENTER_GPLUS_URL', $authUrl_GP);
//**********************************************
//Twitter
//**********************************************
//**********************************************
//VK
//**********************************************
$urlInside_VK = 'https://oauth.vk.com/authorize?client_id='.CLIENT_ID_VK.'&display=page&redirect_uri='.urldecode(HTTP_ENTER_VK).'&scope=friends,email&response_type=code&v=5.62';
define('HTTP_ENTER_VK_URL', $urlInside_VK);
//**********************************************
$page = 'index';
//дістаємо тексти на потрібній мові
$textPage = json_decode(Settings::getTextPage($page), true);

$contentItem = View::getContent();
$ip = $_SERVER['REMOTE_ADDR'];
$insertInfoDylemat = include_once(ROOT.'/views/insertInfoDylemat.php');
?>

<!-- Main -->
<input type="hidden" name="page" value="<?=$contentItem['index'];?>">
<section id="main">
	<input type="hidden" name="page" value="<?=(isset($contentItem['index'])?($contentItem['index']):'');?>">
	<!-- форма входу для вже зареєстрованих осіб -->
	<div id="login" class="contentOtherPage">
		<a id="close-box-login" class="fs-10 color-blue link bshadow" href="#"><i class="fa fa-arrow-left p-l-03" aria-hidden="true"></i><?=$textPage['btn_back'];?></a>
		<h2 id="insiteText" class="fs-13 p-tb-01 mtb-10 item-stretch h-auto brr-4 bshadow color-white bgc-orange lheight-15"><?=$textPage['title_enter'];?></h2>
		<form id="box-insite" method="post" action="<?=HTTP_INSITE_USER; ?>">
			<div class="flex-column jc-center">
				<input type="hidden" name="ip" value="<?=$ip; ?>">
				<input class="no-upper fs-12 no-upper bshadow mbottom-08" type="password" name="pass" id="nameInsite" placeholder="<?=$textPage['pass'];?>" value="<?=(isset($contentItem['cookie']['pass'])?($contentItem['cookie']['pass']):'');?>" required />
				<input class="no-upper fs-12 no-upper bshadow mbottom-08" type="email" name="email" id="emailInsite" placeholder="<?=$textPage['email'];?>" value="<?=(isset($contentItem['cookie']['email'])?($contentItem['cookie']['email']):'');?>" required />

				<div class="g-recaptcha" data-size="normal" data-sitekey="6Lfm4BcUAAAAACJqUNrYVn2m3D7lJpdx7oyjO1s_"></div>

				<div class="mbottom-05 flex flex-row jc-center aitems-center">
					<input type="checkbox" id="human" name="rememberInsite" <?=(isset($contentItem['cookie']['checked'])?('checked'):'');?>/><label for="human" class="fs-10"><?=$textPage['remember'];?></label>
				</div>

				<a id="btn-insite" href="#" class="link-black-orange fs-12 brr-4 bshadow p-tb-02"><?=$textPage['btn_enter'];?></a>
				<br/>
				<a id="btn-repair-pass" class="color-blue link bshadow fs-09 lheight-12" href="<?=HTTP_REPAIR_PASS_PAGE;?>"><?=$textPage['btn_repair_pass'];?></a>

			</div>
		</form>
		<?=$insertInfoDylemat; ?>
	</div>
	<!-- форма реєстрації -->
	<div id="registration" class="contentOtherPage pos-rel">
		<a id="close-box-registration" class="fs-10 color-blue link bshadow" href="#"><i class="fa fa-arrow-left" aria-hidden="true"></i><?=$textPage['btn_back'];?></a>
		<h2 id="registrationText" class="fs-13 p-tb-01 mtb-10 item-stretch h-auto brr-4 bshadow color-white bgc-orange lheight-15"><?=$textPage['title_reg'];?></h2>
		<form id="box-register" method="post" action="<?=HTTP_SAVE_USER; ?>">
			<input type="hidden" name="key" value="registerEasy">
			<input type="hidden" name="ip" value="<?=$ip; ?>">
			<div class="flex-column jc-center">
				<div id="nameRegDiv">
					<input class="fs-12 no-upper bshadow mbottom-08" type="text" name="name" id="nameReg" placeholder="<?=$textPage['nickname'];?>" required />
					<span></span>
				</div>
				<div id="emailRegDiv">
					<input class="fs-12 no-upper bshadow mbottom-08" type="email" name="email" id="emailReg" placeholder="<?=$textPage['email'];?>" required />
					<span></span>
				</div>
				<input class="fs-12 no-upper bshadow mbottom-08" type="password" name="pass" id="passReg" placeholder="<?=$textPage['pass'];?>" required />
				<div id="errorPassReg" class="error brr-4 letter-sp fs-9 lheight-14 mbottom-05 bshadow"></div>
				<input class="fs-12 no-upper bshadow mbottom-08" type="password" name="pass2" id="pass2Reg" placeholder="<?=$textPage['pass_agen'];?>" required />

				<div class="mbottom-05">
					<label>you a robot?</label>
					<br/>
					<div class="flex flex-row jc-center aitems-center">
						<input type="radio" id="robot_yes" name="robotReg" value="yes"/><label for="robot_yes">Yes</label>
						<input type="radio" id="robot_no" name="robotReg" value="no"/><label for="robot_no">No</label>
					</div>
				</div>

				<a id="btn-registration" href="#" class="link-black-orange fs-12 brr-4 bshadow mbottom-05 p-tb-02"><?=$textPage['btn_reg'];?></a>

				<hr class="hr hr--rel mbottom-10">

				<a id="btn-activation" href="<?=HTTP_ACTIVATION_USER; ?>" class="link-black-orange fs-12 brr-4 bshadow p-tb-02 p-lr-05"><?=$textPage['btn_act_conto'];?></a>

			</div>
		</form>
		<br/>
		<?=$insertInfoDylemat; ?>
	</div>
	<!-- титульна сторінка -->
	<div id="first-page" class="contentOtherPage">
		<header>
			<hr class="avatar-hr"><div class="avatar"><img class="bshadow" src="../images/avatar.png" alt="avatar.png" /></div>
			<h1 class="mbottom-10"><?=HTTP_SITE_NAME; ?></h1>
			<p class="fs-12 mbottom-20"><?=$textPage['title_index'];?></p>
		</header>
		<?php
		if(isset($_SESSION['active_user'])):
			if ($_SESSION['active_user']['active'] == '0'): ?>
				<div class="linkMenu mtb-04"><a class="link-black-white brr-4 p-03 bshadow fs-10 block" href="<?=HTTP_ACTIVATION_USER;?>"><?=$textPage['btn_act_conto'];?></a></div>
			<?php endif;?>
			<span class="no-upper fs-14 item-start"><?=$textPage['hello'];?>, <span class="color-darkblue"><?=(isset($_SESSION['active_user']['name']))?$_SESSION['active_user']['name']:$textPage['user'];?>!</span></span>
			<div id="indexPageInfoUser" class="border bshadow brr-4 mtb-04 p-02 w-100 flex-row aitems-center jc-around">
					<div class="flex-column aitems-start">
						<span><?=$textPage['dodav'];?> <span class="color-darkblue"><?=($contentItem['add']['countAdd']);?></span> <?=($contentItem['add']['endAdd'][$language]);?></span>
						<span><?=$textPage['click_dyl'];?> <span class="color-darkblue"><?=($contentItem['ask']['countAsk']);?></span> <?=($contentItem['ask']['endAsk'][$language]);?></span>
						<span><?=$textPage['active'];?>: <span class="color-<?=($_SESSION['active_user']['active']=='1')?('green">'.$textPage['active1']):('red">'.$textPage['active0']);?></span></span>
						<span><?=$textPage['block'];?>: <span class="color-<?=($_SESSION['active_user']['block']=='1')?('red">'.$textPage['block1']):('green">'.$textPage['block0']);?></span></span>
					</div>
					<div class="flex-column">
						<a class="link-black-white brr-4 p-03 bshadow fs-10 block-inline mbottom-05" href="<?=HTTP_SHOW_MY_DYLEMAT.'/'.$_SESSION['active_user']['id'];?>"><?=$textPage['btn_my_dyl'];?></a>
						<a class="link-black-white brr-4 p-03 bshadow fs-10 block-inline mbottom-05" href="<?=HTTP_ADD_DYLEMAT;?>"><?=$textPage['btn_add_dyl'];?></a>

						<a id="" class="link-black-white brr-4 p-03 bshadow fs-10 block-inline mbottom-05" href="<?=HTTP_SHOW_DYLEMAT;?>"><?=$textPage['show_dyl'];?></a>
						<a id="" class="link-black-white brr-4 p-03 bshadow fs-10 block-inline" href="<?=HTTP_CONTACT;?>"><?=$textPage['btn_show_message'];?></a>
					</div>
			</div>
			<?php if (isset($_SESSION['active_user']['admin']) && $_SESSION['active_user']['admin'] == '1' && $_SESSION['active_user']['block'] == '0'): ?>
			<div class="linkMenu mtb-04"><a class="link-black-white brr-4 p-03 bshadow fs-10 block" href="<?=HTTP_ADMIN;?>">ADMIN PAGE</a></div>
		<?php endif;?>
			<div class="linkMenu mtb-04"><a class="link-black-white brr-4 p-03 bshadow fs-10 block" href="<?=HTTP_OUT_USER;?>"><?=$textPage['btn_exit'];?></a></div>

		<?php	else:	?>
			<div class="fs-09 lheight-23 item-stretch">
				<span class="fs-8"><?=$textPage['enter_social'];?></span>
				<div class="flex flex-row jc-center aitems-center lheight-10 mbottom-10">
					<a href="<?=HTTP_ENTER_GPLUS_URL;?>" class="socialIco">
						<i class="fa fa-google-plus-square fs-20" aria-hidden="true"></i><br/>
						<span class="fs-09">google+</span>
					</a>
					<a href="<?=HTTP_ENTER_FACEBOOK;?>" class="socialIco">
						<i class="fa fa-facebook-official fs-20" aria-hidden="true"></i><br/>
						<span class="fs-09">facebook</span>
					</a>
					<a href="<?=HTTP_ENTER_VK_URL;?>" class="socialIco">
						<i class="fa fa-vk fs-20" aria-hidden="true"></i><br/>
						<span class="fs-09">vk</span>
					</a>
				</div>

				<?=$textPage['or'];?><a id="open-box-registration" class="color-blue link bshadow mlr-05" href="#"><?=$textPage['btn_reg'];?></a><?=$textPage['on_page'];?>
				<br/>
				<a id="open-box-login" class="fs-8 color-blue link bshadow mlr-05" href="#"><?=$textPage['btn_enter'];?></a><span class="fs-8"><?=$textPage['for_reg_user'];?></span>
			</div>
			<br/>
			<a id="open-box-registration" class="color-blue link bshadow mlr-05" href="<?=HTTP_SHOW_INFO_DYLEMAT;?>"><?=$textPage['btn_show_dyl'];?></a>

		<?php	endif; ?>
		<br/>
		<?=$insertInfoDylemat; ?>
	</div>
</section>