<?
	session_start();
	
    $pageCode = "join_c";

    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='/js/".$pageCode.".js'></script>";

    require_once "../_include/header.php";

	$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
	if ( $re_url == "" ) $re_url = "/";
	
	if( $_SESSION['USER_AGREE'] != 'n' ) {  
		header('Location: '.$re_url);
	}

    $_SESSION['USER_IDX_TEMP'] = $_SESSION['USER_IDX'];
    $_SESSION['USER_IDX'] = "";
?>
</head>
<body>
	<div id="content" class="join">
		<div id="joinArea">
			<h2><img src="../images/title_join.png" alt="회원가입" /></h2>
			<p class="desc"><img src="../images/text_join_confirm_desc.png" alt="추가 정보를 입력해주시면 회원 가입이 완료됩니다." /></p>
			<dl>
				<dt><span>facebook 계정</span>으로 등록되었습니다.</dt>
				<dd>
					<img src="<?=$_SESSION['USER_IMAGE']?>" alt="프로필 사진"/>
					<span><?=$_SESSION['USER_NAME']?></span>
				</dd>
			</dl>
			<form name="join_confirm_form" id="join_confirm_form" method="post">
			<fieldset>
                <input type="hidden" name="re_url" value="<?=$re_url?>" />
				<div class="agreement-area">
					<label for="agreement"><a href="#" class="link-provision">이용약관</a><span> 및 </span><a href="#" class="link-personal">개인정보 취급방침</a><span>에 동의합니다.</span></label>
					<span id="joinAgreement"></span>
					<input type="hidden" name="policyAgree"  id="policyAgree" />
				</div>
				<div class="button-area">
					<img src="../images/btn_join_ok.png" alt="확인" class="btn-ok" />
                    <img src="../images/btn_join_cancel.png" alt="취소" class="btn-cancel" />
				</div>
			</fieldset>
			</form>
		</div>
	</div>

    <? require_once '../_include/footer.php'; ?>