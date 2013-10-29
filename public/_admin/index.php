<?
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Share & Photo Administration</title>

<style type="text/css">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,form,fieldset,p,button{margin:0;padding:0;}
body,h1,h2,h3,h4,th,td,input{color:#333;font-family:"돋움",dotum,sans-serif;font-size:13px;font-weight:normal;}
hr{display:none;}
img,fieldset{border:0;}
ul,ol,li{list-style:none;}
img,input,select,textarea{vertical-align:middle;}
a{color:#30323f;text-decoration:none;}
a:hover{color:#4559E9;text-decoration:underline;}
legend {display:none;}

body {text-align:center; }

#wrap {width:500px; text-align:left; margin:100px auto; border:1px solid green;}
#header { height:60px; background-color:#000; text-align:center; line-height:60px; }
#header h1 { font-size:20px; font-weight:bold; color:#dfdfdf; }
#body { width:500px; position:relative; overflow:hidden; }
</style>

</head>
<body>
<div id="wrap" >
	<div id="header">
		<h1>Share & Photo Administration</h1>
	</div>
	<div id="body">
<?
	if( !isset($_SESSION['ADMIN_ID']) || $_SESSION['ADMIN_ID'] == "" )
		require_once("login.php");
	else 
		echo "<script>location.href='member/list.php'</script>";
?>
	</div>

<? require_once("inc/bottom.php"); ?>
