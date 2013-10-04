<?
    $pageCode = "gallery";
    
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='/js/".$pageCode.".js'></script>";

    require_once "../_include/header.php";

    //로그인 체크
	if( !isset($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] == '' ) {  
		header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
	}

    $profile_image = "../images/profile_noimage.png";

	if( isset($_SESSION['USER_IMAGE']) && $_SESSION['USER_IMAGE'] != '' ) {  
		$profile_image = $_SESSION['USER_IMAGE'];
	}
?>

	<div id="content" class="<?=$pageCode?>">
		<div class="top">
			<div class="profile">
				<img src="<?=$profile_image?>" width="63" height="63" />
				<span class="title"><em class="name"><?=$_SESSION['USER_NAME']?></em> <span>님의 갤러리</span></span>
				<a class="btn-profile-update" href="" onclick="$.dialog.open('popupProfileUpdate'); return false;">내 프로필 수정</a>
			</div>
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
					<a class="delete">
						삭제하기
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
    require_once "../_include/footer.php";
?>