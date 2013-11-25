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
			<img src="../images/text_main2.png" width="888" height="170" alt="함께 나누는 사진. " />
				<!-- <img src="../images/text_main.png"  alt="함께 나누는 사진. " /> -->
			</div>
			<ul class="category">
			 	<li class="c0 <?if (!$cate) echo 'on';?>"><a href="/">All</a></li>
				<li class="c1 <?if ($cate == '1') echo 'on';?>"><a href="?cate=1">계절&amp;자연</a></li>
				<li class="c2 <?if ($cate == '2') echo 'on';?>"><a href="?cate=2">동,식물&amp;생태</a></li>
				<li class="c3 <?if ($cate == '3') echo 'on';?>"><a href="?cate=3">도시&amp;삶</a></li>
				<li class="c4 <?if ($cate == '4') echo 'on';?>"><a href="?cate=4">유적지&amp;문화</a></li>
				<li class="c5 <?if ($cate == '5') echo 'on';?>"><a href="?cate=5">건축&amp;공간</a></li>
				<li class="c6 <?if ($cate == '6') echo 'on';?>"><a href="?cate=6">사람&amp;사랑</a></li>
				<li class="c7 <?if ($cate == '7') echo 'on';?>"><a href="?cate=7">여행</a></li>
				<li class="c8 <?if ($cate == '8') echo 'on';?>"><a href="?cate=8">예술</a></li>
			</ul>
			<!-- <a class="btn-upload" href="/my/upload.php">사진 올리기</a> -->
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
			<!-- <div class="banner">
				<a href="workshop.php">내가 찍은 문화 유산 신청하기</a>
			</div> -->
			<div class="no-result">
				결과가 없습니다.
			</div>
			<div class="photo-list">
				<div class="item-wrapper">
				</div>
				<a class="more" href="" style="display:none;">더 불러오기</a>
				<hr />
			</div>
		</div>
<?
    require_once "_include/footer.php";
?>
