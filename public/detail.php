<?
    $pageCode = "detail";
    
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='/js/main.js'></script>";


    require_once('../_lib/config.php');
    require_once('../_lib/function.php');
    require_once('../_lib/class.dbConnect.php');
    require_once("../_lib/class.photos.php");

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    $start = ( trim($_GET['start']) ) ? trim($_GET['start']) : 0;
    $count = ( trim($_GET['count']) ) ? trim($_GET['count']) : 0;
    $keyword = ( trim($_GET['keyword']) ) ? trim($_GET['keyword']) : "";
    $sort = ( trim($_GET['sort']) ) ? trim($_GET['sort']) : "d";
    $member_idx = ( trim($_GET['member_idx']) ) ? trim($_GET['member_idx']) : "";

    $arr_photos = $Photo->getList($member_idx, $sort, $start, $count, $keyword);

    $arr_tmp = $arr_photos[0];
    $photo_data = $Photo->get($arr_tmp['id']);

    $profile_image = "";

    if( empty($photo_data['my_img_r']) ) 
        $profile_image = "../images/profile_noimage.png";
    else
        $profile_image = PATH_PROFILE_IMAGE.$photo_data['my_img_r'];

    require_once "_include/header.php";
?>

<div id="content" class="detail">
	<ul class="category">
		<li class="c1 on"><a href="">All</a></li>
		<li class="c2"><a href="">자연&amp;풍경</a></li>
		<li class="c3"><a href="">인물</a></li>
		<li class="c4"><a href="">건축&amp;예술</a></li>
		<li class="c5"><a href="">동물&amp;식물</a></li>
		<li class="c6"><a href="">여행&amp;문화</a></li>
		<li class="c7"><a href="">사물</a></li>
		<li class="c8"><a href="">도시</a></li>
		<li class="c9"><a href="">음식</a></li>
		<li class="c10"><a href="">예술사진</a></li>
	</ul>

	<div class="content">
		<h2>
			<strong><?=$photo_data['title']?></strong>
			<span class="license">(CC <?=getStringCCL($photo_data['ccl'])?>)</span>
			<span class="author">by <?=$photo_data['nickname']?></span>
		</h2>

		<div class="photo">
			<img src="<?=PATH_PHOTOS_FOLDER.$photo_data['filename_r']?>" width="800" height="471" />
			<span class="prev">prev</span>
			<span class="next">next</span>
		</div>
		<ul class="actions">
			<li><a class="btn-download" href="">다운로드</a></li>
			<li>
				<a class="btn-info" href="#">사진정보</a>
				<div class="photo-info" >
					<table>
						<caption>사진정보</caption>
						<tbody>
						<tr><th>카메라 모델</th><td>NIKON D700</td></tr>
						<tr><th>노출시간</th><td>1/320 sec.</td></tr>
						<tr><th>노출보정</th><td>0.00 EV</td></tr>
						<tr><th>프로그램 모드</th><td>Aperture priority</td></tr>
						<tr><th>사용렌즈</th><td>400</td></tr>
						<tr><th>초점길이</th><td>50.0 mm</td></tr>
						<tr><th>측광모드</th><td>Pattern</td></tr>
						<tr><th>촬영일시</th><td>2013:09:08 11:15:59</td></tr>
						</tbody>
					</table>
					<button class="btn-close">close</button>
				</div>
			</li>
			<li>
				<a class="btn-recommend" href="">추천하기</a>
				<p class="msg-recommended">추천되었습니다!</p>
			</li>
			<li><a class="btn-share" href="">공유하기</a></li>
		</ul>
		<ul class="counts">
			<li class="hit"><?=number_format($photo_data['hits'])?></li>
			<li class="recommended"><?=number_format($photo_data['recommend'])?></li>
		</ul>
		<div class="info">
			<div class="desc">
				<div class="owner">
					<img src="<?=$profile_image?>" width="63" height="63" />
					<span class="photographer">Photographer.</span><span class="name"><?=$photo_data['nickname']?></span><a class="go-gallery" href="/my/gallery.php?midx=<?=$photo_data['member_idx']?>">작품 더보기 ►</a>
				</div>
				<dl>
					<dt>작품설명</dt>
					<dd><?=$photo_data['description']?><span class="date"><?=date('Y.m.d H:i',strtotime($photo_data['createdate']))?></span>
					<dt>카테고리</dt>
					<dd class="cate"><?=$photo_data['cate_name']?></dd>
					<dt>Tag</dt>
					<dd><?=$photo_data['tags']?></dd>
				</dl>
			</div>
			<div class="comment">
				comment
			</div>
		</div>
		<a class="btn-top" href="">TOP</a>
		<a class="btn-list" href="">목록</a>
	</div>

</div>

<?
    require_once "_include/footer.php";
?>

<script type="text/javascript">
<!--
    $(function(){
        $('.btn-info').click(function(){
            $(this).siblings('.photo-info').toggle();
            return false;
        });

        $('.photo-info .btn-close').click(function(){
            $('.photo-info').hide();
            return false;
        });
    });
//-->
</script>