<? 
	$TopMenu = "photo";
	require_once("../inc/header.php"); 
	require_once('../../../_lib/class.dbConnect.php');
	require_once("../../../_lib/class.paging.php");

	$DB = new dbConn();
	$table = "photos";
	$keyfield = $_POST['keyfield'] ? $_POST['keyfield'] : $_GET['keyfield'];
	$keyword = $_POST['keyword'] ? $_POST['keyword'] : $_GET['keyword'];
	$nowPage = $_POST['nowPage'] ? $_POST['nowPage'] : $_GET['nowPage'];
	$BlockSize = $_POST['BlockSize'] ? $_POST['BlockSize'] : $_GET['BlockSize'];
	$PageSize = $_POST['PageSize'] ? $_POST['PageSize'] : $_GET['PageSize'];
	$sort = $_POST['sort'] ? $_POST['sort'] : $_GET['sort'];

	if($nowPage == "") $nowPage = 1;
	if($BlockSize == "") $BlockSize = 10;
	if($PageSize == "") $PageSize = 10;

	$where_temp = " where 1 ";

	if( $keyfield != "" ) {
		$where_temp .= " and $keyfield LIKE '%$keyword%'";
	}

	$re = $DB->dbQuery("select id from ".$table." $where_temp");
	$totalRecord = $re[cnt];

	$PAGE = new pageSet($nowPage, $BlockSize,$PageSize, $totalRecord);
	
	switch( $sort ) {
		case 'c':
			$where_temp .= " order by createdate desc";
		break;
		case 'r':
			$where_temp .= " order by recommend desc";
			break;
		default:
			$where_temp .= " order by id desc";
		break;
	}

	$where_temp .= $PAGE->getLimitQuery();


	$query = "select *, (select nickname from members where idx = member_idx) as member_name";
	$query .= " from ".$table;
	$query .= " ".$where_temp;

	$re = $DB->dbQuery($query);

    $sort_link = "./list.php?keyfield=".$keyfield;
    $sort_link .= "&nowPage=".$nowPage;
    $sort_link .= "&BlockSize=".$BlockSize;
    $sort_link .= "&PageSize=".$PageSize;
    $sort_link .= "&sort=";
?>

<div id="contentList">
<table>
<caption>Photo List</caption>
	<thead>
	<tr>
		<th>No.</th>
		<th width="110">사진</th>
		<th>제목</th>
		<th><a href="<?=$sort_link?>r">추천수</a></th>
		<th><a href="<?=$sort_link?>c">등록일</a></th>
		<th width="70">작성자</th>
	</tr>
	</thead>
	<tbody>
	<? 
		for( $i=0; $i <$re['cnt']; $i++ ) {
			$row = mysql_fetch_array($re['result']);
			$number = $totalRecord - $i - ( ($nowPage-1) * $PageSize );
	
			$info = json_decode( stripslashes($row['c_info']) );

			if( $row['f_enable'] == 'n' ) {
				$btn_enable = "<a class='btn-enable btn-red'>disable</a>";
			} else {
				$btn_enable = "<a class='btn-enable btn-black'>enable</a>";
			}
	?>
	<tr>
		<td><?=$number?></td>
		<td><img src="<?=PATH_PHOTOS_FOLDER."thumb/".$row['filename_r']?>" alt="<?=$row['title']?>" width=100/></td>
		<td><?=$row['title']?></td>
		<td><?=$row['recommend']?></td>
		<td><?=substr(trim($row["createdate"]), 0, 10)?></td>
		<td><?=$row['member_name']?></td>
	</tr>
	<? } ?>
	</tbody>
	<tfoot>
	<tr>
		<td colspan="6" align="center"><?=$PAGE->getPage();?></td>
	</tr>
	</tfoot>
</table>
</div>
<? require_once("../inc/bottom.php"); ?>
