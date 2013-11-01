<? 
	$TopMenu = "member";

	require_once("../inc/header.php"); 
	require_once('../../../_lib/class.dbConnect.php');
	require_once("../../../_lib/class.paging.php");

	$DB = new dbConn();
	
	$table = "members";
	$keyfield = $_POST['keyfield'] ? $_POST['keyfield'] : $_GET['keyfield'];
	$keyword = $_POST['keyword'] ? $_POST['keyword'] : $_GET['keyword'];
	$nowPage = $_POST['nowPage'] ? $_POST['nowPage'] : $_GET['nowPage'];
	$BlockSize = $_POST['BlockSize'] ? $_POST['BlockSize'] : $_GET['BlockSize'];
	$PageSize = $_POST['PageSize'] ? $_POST['PageSize'] : $_GET['PageSize'];
    $sort = $_POST['sort'] ? $_POST['sort'] : $_GET['sort'];

	if($nowPage == "") $nowPage = 1;
	if($BlockSize == "") $BlockSize = 10;
	if($PageSize == "") $PageSize = 30;

	$where_temp = " where 1 ";

	if( $keyfield != "" ) {
		if( $keyfield == "email" )
			$where_temp .= " and email LIKE '%$keyword%'";
	}

	$re = $DB->dbQuery("select idx from ".$table." $where_temp");
	$totalRecord = $re[cnt];

	$arr = array("keyfield"=>$keyfield,"keyword"=>$keyword); 
	$PAGE = new pageSet($nowPage, $BlockSize,$PageSize, $totalRecord,$arr);

    $query = "select m.* ";
    $query .= ", (select count(*) from photos p where m.idx = p.member_idx) as count";
    $query .= " from ".$table." m ";

    switch( $sort ) {
        case 'c':
            $where_temp .= " order by count desc";
        break;
        case 'j':
            $where_temp .= " order by joindate desc";
            break;
        case 'l':
            $where_temp .= " order by logindate desc";
            break;
        default:
            $where_temp .= " order by idx desc";
        break;
    }

    $where_temp .= $PAGE->getLimitQuery();

    $query .= $where_temp;
	
	$re = $DB->dbQuery($query);


    $sort_link = "./list.php?keyfield=".$keyfield;
    $sort_link .= "&keyword=".$keyword;
    $sort_link .= "&nowPage=".$nowPage;
    $sort_link .= "&BlockSize=".$BlockSize;
    $sort_link .= "&PageSize=".$PageSize;
    $sort_link .= "&sort=";
?>

<style type="text/css">
	.info-idx { display:none; }
</style>

<div id="contentList">
<table>
<caption>Member List</caption>
	<thead>
	<tr>
		<th>No.</th>
        <th>Name</th>
		<th>Email</th>
		<th>twitter</th>
		<th>facebook</th>
        <th><a href="<?=$sort_link?>c">upload count</a></th>
		<th><a href="<?=$sort_link?>k">Sign Up</a></th>
		<th><a href="<?=$sort_link?>l">Last Login</a></th>
	</tr>
	</thead>
	<tbody>
	<? 
		for( $i=0; $i <$re['cnt']; $i++ ) {
			$row = mysql_fetch_array($re['result']);
			$number = $totalRecord - $i - ( ($nowPage-1) * $PageSize );
	?>
	<tr>
		<td><?=$number?></td>
		<td><?=$row['nickname']?></td>
        <td><?=$row['email']?></td>
		<td><a href="https://twitter.com/intent/user?user_id=<?=$row['twitter_id']?>" target="_blink"><?=$row['twitter_id']?></a></td>
		<td><a href="https://www.facebook.com/profile.php?id=<?=$row['facebook_id']?>" target="_blink"><?=$row['facebook_id']?></a></td>
        <td><?=$row["count"]?></td>
		<td><?=substr(trim($row["joindate"]), 0, 10)?></td>
		<td><?=substr(trim($row["logindate"]), 0, 10)?></td>
	</tr>
	<? } ?>
	</tbody>
	<tfoot>
	<tr>
		<td colspan="8" align="center"><?=$PAGE->getPage();?>	</td>
	</tr>
	<tr>
		<td colspan="8" >
			<form method="get" action="<?=$_SERVER['REQUEST_URI']?>" name="search_form" class="BoardSearch">
			<fieldset>
				<select id="searchSelect" name="keyfield">
					<option value="" <? if($keyfield=="") { echo "selected"; } ?>>Select</option>
					<option value="email" <? if($keyfield=="email") { echo "selected"; } ?>>Email</option>
				</select>
				<input type="text" name="keyword" value="<?=$keyword?>"/>
				<input type="submit" value="Search"/>
			</fieldset>
			</form>
		</td>
	</tr>
	</tfoot>
</table>
</div>
<? require_once("../inc/bottom.php"); ?>
