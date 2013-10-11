<?
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='css/main.css' />";

    $strJS = "<script type='text/javascript' src='js/jquery.validate.js'></script>";
    $strJS .= "<script type='text/javascript' src='js/main.js'></script>";

    $pageCode = "main";
	$cate = $_GET['cate'];
	$keyword = $_GET['keyword'];
    require_once "_include/header.php";
?>
		<div id="content" class="main">
			<div class="top">
				<img src="../images/text_main.png" width="505" height="189" alt="함께 나누는 사진 베스트 포토를 추천해주세요! 투표 기간 : 2013. 10. 25 ~ 2013. 11. 10" />
			</div>
			<ul class="category">
				<li class="c1 <?if (!$cate) echo 'on';?>"><a href="/">All</a></li>
				<li class="c2 <?if ($cate == '1') echo 'on';?>"><a href="?cate=1">자연&amp;풍경</a></li>
				<li class="c3 <?if ($cate == '2') echo 'on';?>"><a href="?cate=2">인물</a></li>
				<li class="c4 <?if ($cate == '3') echo 'on';?>"><a href="?cate=3">건축&amp;예술</a></li>
				<li class="c5 <?if ($cate == '4') echo 'on';?>"><a href="?cate=4">동물&amp;식물</a></li>
				<li class="c6 <?if ($cate == '5') echo 'on';?>"><a href="?cate=5">여행&amp;문화</a></li>
				<li class="c7 <?if ($cate == '6') echo 'on';?>"><a href="?cate=6">사물</a></li>
				<li class="c8 <?if ($cate == '7') echo 'on';?>"><a href="?cate=7">도시</a></li>
				<li class="c9 <?if ($cate == '8') echo 'on';?>"><a href="?cate=8">음식</a></li>
				<li class="c10 <?if ($cate == '9') echo 'on';?>"><a href="?cate=9">예술사진</a></li>
			</ul>
			<a class="btn-upload" href="/my/upload.php">사진 올리기</a>
			<form name="filter">
				<input type="hidden" name="cate" value="<?=$cate?>" />
				<fieldset class="order">
					<legend>정렬</legend>
					<input type="radio" id="orderRecently" name="sort" value="d" checked />
					<label class="recently" for="orderRecently">최신순</label>
					<input type="radio" id="orderRecommend" name="sort" value="r" />
					<label class="recommend" for="orderRecommend">추천순</label>
					<input type="radio" id="orderHit" name="sort" value="h" />
					<label class="hit" for="orderHit">조회순</label>
				</fieldset>
				<fieldset class="search">
					<legend>검색</legend>
					<input class="keyword" type="text" placeholder="Search..." name="keyword" value="<?=$keyword?>"/>
					<input class="btn-search" type="submit" value="검색" />
				</fieldset>
			</form>
			<div class="banner">
				<a href="">내가 찍은 문화 유산 신청하기</a>
			</div>
			<div class="no-result">
				결과가 없습니다.
			</div>
			<div class="photo-list">
				<div class="item-wrapper">
				</div>
				<a class="more" href="">더 불러오기</a>
				<hr />
			</div>
		</div>
<?
    require_once "_include/footer.php";
?>