<?
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='../css/join.css' />";

    $strJS = "<script type='text/javascript' src='../js/jquery.validate.js'></script>";
    $strJS .= "<script type='text/javascript' src='../js/join.js'></script>";

    $pageCode = "join";

    require_once "../_include/header.php";

	$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
	if ( $re_url == "" ) $re_url = "/";
?>

	<div id="content" class="">
		<div id="joinArea">
			<h2><img src="../images/title_join.png" alt="회원가입" /></h2>
			<p class="desc"><img src="../images/text_join_desc.png" alt="페이스북, 트위터 계정을 연동하여 회원가입을 하거나 사용중인 E-mail을 이용하여 회원가입 해주세요!" /></p>
			<ul>
				<li class="link-JoinF" onclick="joinFacebook('<?=$re_url?>')">페이스북으로 가입하기</li>
				<li class="link-JoinT" onclick="joinTwitter('<?=$re_url?>')">트위터로 가입하기</li>
			</ul>
			<div class="float-clear"></div>
			<form name="join_form" id="join_form" method="post" action="join_proc.php" >
			<fieldset>
				<div class="input-area">
					<label for="joinEmail"><img src="../images/text_email.png" alt="E-mail" /></label>
					<input type="text" id="joinEmail" name="joinEmail" class="input-455 text"/>
					<img src="../images/text_email_desc.png" class="msg" />
					<span class="mark"></span>
				</div>
				<div class="input-area">
					<label for="joinPasswd"><img src="../images/text_passwd.png" alt="비밀번호" /></label>
					<input type="password" id="joinPasswd" name="joinPasswd" class="input-455 text"/>
					<img src="../images/text_passwd_desc.png" class="msg" />
					<span class="mark"></span>
				</div>
				<div class="input-area">
					<label for="joinPasswdConfirm"><img src="../images/text_passwd_confirm.png" alt="비밀번호확인" /></label>
					<input type="password" id="joinPasswdConfirm" name="joinPasswdConfirm" class="input-455 text" />
					<img src="../images/text_passwd_desc.png" class="msg" />
					<span class="mark"></span>
				</div>
				<div class="input-area">
					<label for="joinNickName"><img src="../images/text_name.png" alt="이름 & 닉네임" /></label>
					<input type="text" id="joinNickName" name="joinNickName" class="input-341 text"/>
					<img src="../images/text_name_desc.png" class="msg" />
					<img src="" class="d-msg" style="display:none;"/>
					<span class="mark"></span>
					<button id="btnCheckDuplication">중복확인</button>
                    <input type="hidden" name="checkDuplication" />
				</div>
				<div class="agreement-area">
					<label for="agreement"><a href="#" class="link-provision">이용약관</a><span> 및 </span><a href="#" class="link-personal">개인정보 취급방침</a><span>에 동의합니다.</span></label>
					<span id="joinAgreement"></span>
					<input type="hidden" name="policyAgree"  id="policyAgree" />
				</div>
				<div class="button-area">
					<img src="../images/btn_join_ok.png" alt="확인" class="btn-ok" /><img src="../images/btn_join_cancel.png" alt="취소" class="btn-cancel" />
				</div>
			</fieldset>
			</form>
		</div>
	</div>

<? require_once "../_include/footer.php"; ?>