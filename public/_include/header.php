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
	<?=$strMeta?>
	<title>Share & Photo</title>
	<link rel="stylesheet" media="all" type="text/css" href="/css/common.css" />
    <?=$strCSS?>
</head>
<body>
<div id="wrap">
	<div id="bg"></div>
	<div id="header">
		<h1><a href="/">Share & Photo</a></h1>

		<ul id="nav">
			<li class="intro <?if($pageCode=="intro") echo "on";?>"><a href="/intro.php">캠패인소개</a></li>
			<li class="exhibition <?if($pageCode=="exhibition") echo "on";?>"><a href="/exhibition.php">전시회</a></li>
			<li class="workshop <?if($pageCode=="workshop") echo "on";?>"><a href="/workshop.php">워크샵</a></li>
			<li class="about"><a href="http://cckorea.org" target="_blink">About CCKorea</a></li>
			<li class="sharehub"><a href="http://sharehub.kr" target="_blink">공유허브</a></li>
            <? if($isLogin) { ?>
                <li class="logout"><a href="/member/logout.php">로그아웃</a></li>
                <li class="my <?if($pageCode=="galley") echo "on";?>"><a href="/my/gallery.php?m_idx=<?=$_SESSION['USER_IDX']?>">마이갤러리</a></li>
            <? } else { ?>
            <li class="login <?if($pageCode=="login") echo "on";?>"><a href="/member/login.php">로그인</a></li>
			<li class="join <?if($pageCode=="join") echo "on";?>"><a href="/member/join.php">회원가입</a></li>
            <? } ?>
		</ul>

		<hr />
	</div>