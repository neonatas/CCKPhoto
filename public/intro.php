<?
    $pageCode = "intro";

    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";

    require_once "_include/header.php";

?>

	<div id="content" class="<?=$pageCode?>">
		<dl id="introArea">
			<dt><h2><img src="../images/title_intro.png" alt="캠패인소개" /></h2></dt>
			<dd>
				<div class="text-1"><img src="../images/text_intro1.png" alt="캠패인소개" /></div>
				<div class="text-2">
					<img src="../images/text_intro2.png" usemap="#go_galleryis" alt="캠패인소개" />
					<map name="go_galleryis">
						<area shape="rect" coords="160,95,271,114" href="http://www.galleryis.com" target="_blink">
					</map>
				</div>
				<div class="text-3"><img src="../images/text_intro3.png" alt="캠패인소개" /></div>
				<div class="text-4">
					<img src="../images/text_intro4.png" alt="캠패인소개" usemap="#go_license" />
					<map name="go_license">
						<area shape="rect" coords="610,70,699,92" href="http://cckorea.org/xe/?mid=ccl"  target="_blink">
					</map>
				</div>
				<div class="text-5"><img src="../images/text_intro5.png" alt="캠패인소개" /></div>
			</dd>
		</dl>
	</div>


<? require_once "_include/footer.php"; ?>