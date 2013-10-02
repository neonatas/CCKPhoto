<? 
    session_start(); 
    $isLogin = false;
    if( isset($_SESSION['USER_IDX']) && $_SESSION['USER_IDX'] != "" ) 
        $isLogin = true;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

	<title>Share & Photo</title>
	<link rel="stylesheet" media="all" type="text/css" href="../css/common.css" />
    <?=$strCSS?>
</head>
<body>
<div id="wrap">
	<div id="bg"></div>
	<div id="header">
		<h1><a href="/"><img src="../images/logo.png" width="307" height="307" alt="Share & Photo"/></a></h1>

		<ul id="nav">
			<li class="intro"><a href="">캠패인소개</a></li>
			<li class="exhibition"><a href="">전시회</a></li>
			<li class="workshop"><a href="">워크샵</a></li>
            <? if($isLogin) { ?>
                <li class="logout"><a href="/member/logout.php">로그아웃</a></li>
                <li class="my"><a href="">마이갤러리</a></li>
            <? } else { ?>
            <li class="login"><a href="/member/login.php">로그인</a></li>
			<li class="join"><a href="/member/join.php">회원가입</a></li>
            <? } ?>
			<li class="about"><a href="">About CCKorea</a></li>
		</ul>

		<hr />
	</div>