<?
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='../css/login.css' />";

    $strJS = "<script type='text/javascript' src='../js/jquery.validate.js'></script>";
    $strJS .= "<script type='text/javascript' src='../js/login.js'></script>";

    $pageCode = "login";

    require_once "../_include/header.php";

	$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
	if ( $re_url == "" ) $re_url = "/";
?>

	<div id="content" class="login">
		<div id="loginArea">
			<h2><img src="../images/title_login.png" alt="로그인" /></h2>
			<ul class="oauth">
				<li class="link-JoinF" onclick="joinFacebook('<?=$re_url?>')">페이스북으로 로그인하기</li>
				<li class="link-JoinT" onclick="joinTwitter('<?=$re_url?>')">트위터로 로그인하기</li>
			</ul>
			<div class="float-clear"></div>
			<form name="login_form" id="login_form" method="post">
            <input type="hidden" name="re_url" value="<?=$re_url?>" />
			<fieldset>
				<div class="input-area">
					<label for="loginEmail"><img src="../images/text_email.png" alt="E-mail" /></label>
					<input type="text" id="loginEmail" name="loginEmail" class="input-455 text"/>
					<img src="../images/text_email_desc.png" class="msg" />
					<span class="mark"></span>
				</div>
				<div class="input-area">
					<label for="loginPasswd"><img src="../images/text_passwd.png" alt="비밀번호" /></label>
					<input type="password" id="loginPasswd" name="loginPasswd" class="input-455 text"/>
					<img src="../images/text_passwd_desc.png" class="msg" />
					<span class="mark"></span>
				</div>
				<div class="button-area">
					<img src="../images/btn_join_ok.png" alt="확인" class="btn-login-ok" /><img src="../images/btn_join_cancel.png" alt="취소" class="btn-login-cancel" />
				</div>
			</fieldset>
			</form>
			<ul class="login-about">
				<li><a href=""><img src="../images/text_find_passwd.png" alt="비밀번호 찾기" /></a></li>
				<li><a href="join.php"><img src="../images/text_go_join.png" alt="회원 가입하기" /></a></li>
			</ul>
		</div>
	</div>

<? require_once "../_include/footer.php"; ?>