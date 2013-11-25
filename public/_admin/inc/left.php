<style type="text/css">
#leftMenu ul li a{ color:#fff; font-weight:bold; display:block; width:88px; height:30px; background-color:#000; text-align:center; line-height:30px; margin:5px;}

</style>

<?	if( $TopMenu == "member" ) { ?>
<ul>
	<li><a href="list.php?pgkey=list">List</a></li>
</ul>
<? } else if( $TopMenu == "photo" ) { ?>
<ul>
	<li><a href="list.php">List</a></li>
	<li><a href="r_list.php">Recommend List</a></li>
</ul>
<?
	}
?>
