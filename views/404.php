<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.12.2016
 * Time: 14:25
 */
$page = '404';
//дістаємо тексти на потрібній мові
$textPage = json_decode(Settings::getTextPage($page), true);

$indexHTTP = HTTP_SITE;

$insertInfoDylemat = include_once(ROOT.'/views/insertInfoDylemat.php');

//показуємо меню
include_once (ROOT.'/views/menuSmoll.php');
?>

<!-- Main -->
<section id="main">
	<div id="about" class="flex-column jc-center">
		<h2 id="insiteText" class="fs-13 p-tb-01 mbottom-10 w-100 brr-4 bshadow color-white bgc-orange lheight-15 text-center"><?=$textPage['title'];?></h2>
		<div class="border brr-4 fs-12 color-orange bshadow p-05 mbottom-10 flex flex-column jc-center aitems-center text-center lheight-15">
			<span class="color-darkblue fs-16 mbottom-05 block"><?=$textPage['text1'];?></span>
			<?=$textPage['text2'];?>
			<span class="color-darkblue mtop-05"><?=$textPage['text3'];?></span>
		</div>
		<a href="<?=HTTP_SITE; ?>" class="link-black-orange brr-4 p-05 bshadow item-center mbottom-05"><span><?=$textPage['btn_index'];?></span></a>
		<a href="<?=HTTP_CONTACT; ?>" class="link-black-orange brr-4 p-05 bshadow item-center"><span><?=$textPage['btn_contact'];?></span></a>
		<br/>
		<?=$insertInfoDylemat; ?>
	</div>
</section>

