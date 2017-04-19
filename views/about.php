<?php
/**
 * Created by PhpStorm.
 * User: Romio
 * Date: 06.12.2016
 * Time: 14:25
 */
$page = 'about';
//дістаємо тексти на потрібній мові
$textPage = json_decode(Settings::getTextPage($page), true);

$contentShow = array();

$contentShow = View::getContent();

$indexHTTP = HTTP_SITE;

//показуємо меню
include_once (ROOT.'/views/menuSmoll.php');

/*$string = array('text'=>@'');

echo '<div class="no-upper">'.json_encode($string, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE).'</div>';
//echo '<div class="no-upper"><code>'.json_encode($string).'</code></div>';*/
?>

<!-- Main -->
<input type="hidden" name="page" value="<?=$page;?>">
<section id="main">
	<div id="about" class="flex-column jc-center">
		<h2 id="insiteText" class="fs-13 p-tb-01 mbottom-10 w-100 brr-4 bshadow color-white bgc-orange lheight-15 text-center"><?=$textPage['title'];?></h2>
		<div class="border brr-4 fs-8 color-orange bshadow p-05 no-upper lheight-13"><?=$contentShow['text'];?></div>
	</div>
</section>

