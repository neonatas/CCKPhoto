<?
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='css/main.css' />";

    $strJS = "<script type='text/javascript' src='js/jquery.validate.js'></script>";
    $strJS .= "<script type='text/javascript' src='js/main.js'></script>";

    $pageCode = "main";

    require_once "_include/header.php";

	$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
	if ( $re_url == "" ) $re_url = "/";
?>
		<div id="content" class="main">
			<div class="top">
				<img src="../images/text_main.png" width="505" height="189" alt="함께 나누는 사진 베스트 포토를 추천해주세요! 투표 기간 : 2013. 10. 25 ~ 2013. 11. 10" />
			</div>
			<ul class="category">
				<li class="c1 on"><a href="">All</a></li>
				<li class="c2"><a href="">자연&amp;풍경</a></li>
				<li class="c3"><a href="">인물</a></li>
				<li class="c4"><a href="">건축&amp;예술</a></li>
				<li class="c5"><a href="">동물&amp;식물</a></li>
				<li class="c6"><a href="">여행&amp;문화</a></li>
				<li class="c7"><a href="">사물</a></li>
				<li class="c8"><a href="">도시</a></li>
				<li class="c9"><a href="">음식</a></li>
				<li class="c10"><a href="">예술사진</a></li>
			</ul>
			<a class="btn-upload" href="">사진 올리기</a>
			<form>
				<fieldset class="order">
					<legend>정렬</legend>
					<input type="radio" id="orderRecently" name="order" value="recently" checked />
					<label class="recently on" for="orderRecently">최신순</label>
					<input type="radio" id="orderRecommend" name="order" value="recommend" />
					<label class="recommend" for="orderRecommend">추천순</label>
					<input type="radio" id="orderHit" name="order" value="hit" />
					<label class="hit" for="orderHit">조회순</label>
				</fieldset>
				<fieldset class="search">
					<legend>검색</legend>
					<input class="keyword" type="text" placeholder="Search..." name="keyword" />
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
				<ul>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample01.png" width="232" height="140"/>
						</a>
						<a class="recommend on" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample02.png" width="232" height="277"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample03.png" width="232" height="150"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample04.png" width="232" height="231"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample01.png" width="232" height="140"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample02.png" width="232" height="277"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample03.png" width="232" height="150"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample04.png" width="232" height="231"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample01.png" width="232" height="140"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample02.png" width="232" height="277"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample03.png" width="232" height="150"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample04.png" width="232" height="231"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample01.png" width="232" height="140"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample02.png" width="232" height="277"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample03.png" width="232" height="150"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
					<li>
						<a href="">
							<span class="title"><em>달로 가는 자동차는 하늘로</em></span>
							<img src="../images/sample/sample04.png" width="232" height="231"/>
						</a>
						<a class="recommend" href="">
							추천하기
						</a>
					</li>
				</ul>
				<a class="more" href="">더 불러오기</a>
				<hr />
			</div>
		</div>
<?
    require_once "_include/footer.php";
?>