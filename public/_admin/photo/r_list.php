<? 
	$TopMenu = "photo";
	require_once("../inc/header.php"); 
	require_once('../../../_lib/class.dbConnect.php');
	require_once("../../../_lib/class.paging.php");

	$DB = new dbConn();
	$table = "photos";
	$nowPage = $_POST['nowPage'] ? $_POST['nowPage'] : $_GET['nowPage'];
	$BlockSize = $_POST['BlockSize'] ? $_POST['BlockSize'] : $_GET['BlockSize'];
	$PageSize = $_POST['PageSize'] ? $_POST['PageSize'] : $_GET['PageSize'];
	$sort = $_POST['sort'] ? $_POST['sort'] : $_GET['sort'];

	if($nowPage == "") $nowPage = 1;
	if($BlockSize == "") $BlockSize = 10;
	if($PageSize == "") $PageSize = 10;

	$query = "select p.*, (select nickname from members where idx = p.member_idx ) as member_name";
	$query .= " ,(select nickname from members where idx = m.idx ) as admin_name";
	$query .= " from members m LEFT JOIN recommend r ON m.idx = r.member_idx ";
	$query .= " LEFT JOIN photos p ON p.id = r.photo_id ";
	$where_temp = " where m.level = 1 and p.id not null ";

	$re = $DB->dbQuery($query.$where_temp);
	$totalRecord = $re[cnt];

	$PAGE = new pageSet($nowPage, $BlockSize,$PageSize, $totalRecord);
	
	switch( $sort ) {
		case 'c':
			$where_temp .= " order by p.createdate desc";
		break;
		case 'r':
			$where_temp .= " order by p.recommend desc";
			break;
		default:
			$where_temp .= " order by p.id desc";
		break;
	}

	$where_temp .= $PAGE->getLimitQuery();

//echo $query.$where_temp;

	$re = $DB->dbQuery($query.$where_temp);

    $sort_link = "./r_list.php?nowPage=".$nowPage;
    $sort_link .= "&BlockSize=".$BlockSize;
    $sort_link .= "&PageSize=".$PageSize;
    $sort_link .= "&sort=";
?>

<div id="contentList">
<table>
<caption>관리자 추천작</caption>
	<thead>
	<tr>
		<th>No.</th>
		<th width="110">사진</th>
		<th>제목</th>
		<th><a href="<?=$sort_link?>r">추천수</a></th>
		<th><a href="<?=$sort_link?>c">등록일</a></th>
		<th width="70">작성자</th>
		<th width="70">추천 관리자</th>
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
		<td><?=$row['admin_name']?></td>
	</tr>
	<? } ?>
	</tbody>
	<tfoot>
	<tr>
		<td colspan="7" align="center"><?=$PAGE->getPage();?></td>
	</tr>
	</tfoot>
</table>
</div>
<? require_once("../inc/bottom.php"); ?>
