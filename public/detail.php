<?
    session_start();

    $pageCode = "detail";
    
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='/js/main.js'></script>";
    $strJS .= "<script type='text/javascript' src='/js/".$pageCode.".js'></script>";


    require_once('../_lib/config.php');
    require_once('../_lib/class.dbConnect.php');
    require_once('../_lib/function.php');
    require_once("../_lib/class.photos.php");

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    $pid = ( trim($_GET['pid']) ) ? trim($_GET['pid']) : "";
    $start = ( trim($_GET['start']) ) ? trim($_GET['start']) : 0;
    $count = ( trim($_GET['count']) ) ? trim($_GET['count']) : 0;
    $keyword = ( trim($_GET['keyword']) ) ? trim($_GET['keyword']) : "";
    $cate = ( trim($_GET['cate']) ) ? trim($_GET['cate']) : "";
    $sort = ( trim($_GET['sort']) ) ? trim($_GET['sort']) : "d";
    $member_idx = ( trim($_GET['m_idx']) ) ? trim($_GET['m_idx']) : "";


    if( $pid == "" ) {
        header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
        exit;
    }

    //컨텐츠 정보
    $photo_data = $Photo->get( $pid );

    if( !$photo_data ) {
        header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
        exit;
    }

    //조회수 증가
    $Photo->incrementHits($pid); 

    //이전, 다음 이미지 링크
    $arr_id = $Photo->getPrevNextId($pid, $member_idx, $sort, $cate, $keyword );
    $prev_id = $arr_id['prev'];
    $next_id = $arr_id['next'];
    if( $prev_id != "" ) {
        $prev_link = "onclick=\"location.href='".goDetailLink($prev_id, $keyword, $cate, $sort, $member_idx)."'\"";
    }
    if( $next_id != "" ) {
        $next_link = "onclick=\"location.href='".goDetailLink($next_id, $keyword, $cate, $sort, $member_idx)."'\"";
    }

    //사용자 프로필 이미지
    $profile_image = "";
    if( empty($photo_data['my_img_r']) ) 
        $profile_image = "../images/profile_noimage.png";
    else
        $profile_image = $photo_data['my_img_r'];

    //이미지 정보
	$file_info = $Photo->getPhotoInfo(PATH_PHOTOS.$photo_data['filename_r']);
	
	switch($file_info['EXIF']['ExposureProgram'])
	{
			case "0": $program_mode = "Not Defined"; break;
			case "1": $program_mode = "Manual"; break;
			case "2": $program_mode = "Program AE"; break;
			case "3": $program_mode = "Aperture-priority AE"; break;
			case "4": $program_mode = "Shutter speed priority AE"; break;
			case "5": $program_mode = "Creative (Slow speed)"; break;
			case "6": $program_mode = "Action (High speed)"; break;
			case "7": $program_mode = "Portrait"; break;
			case "8": $program_mode = "Landscape"; break;
			case "9": $program_mode = "Bulb"; break;
			default: $program_mode = "Not Defined"; break;
	}

	switch($file_info['EXIF']['MeteringMode'])
	{
			case "0": $Metering_mode = "Unknown"; break;
			case "1": $Metering_mode = "Average"; break;
			case "2": $Metering_mode = "Center-weighted average"; break;
			case "3": $Metering_mode = "Spot"; break;
			case "4": $Metering_mode = "Multi-spot"; break;
			case "5": $Metering_mode = "Multi-segment"; break;
			case "6": $Metering_mode = "Partial"; break;
			case "255": $Metering_mode = "Other"; break;
			default: $Metering_mode = "Unknown"; break;
	}
      
	$strMeta = '<meta property="og:title" content="Share & Photo : '.$photo_data['title'].'" />';
	$strMeta .= '<meta property="og:type" content="article" />';
	$strMeta .= '<meta property="og:image" content="'.PATH_PHOTOS_FOLDER.$photo_data['filename_r'].'" />';
	$strMeta .= '<meta property="og:description" content="함께나누는 사진. 베스트 포토를 추천해주세요!" />';

          
	$strMeta .= '<meta name="twitter:card" content="summary" />';
	$strMeta .= '<meta name="twitter:title" content="Share & Photo : '.$photo_data['title'].'" />';
	$strMeta .= '<meta name="twitter:description" content="함께나누는 사진. 베스트 포토를 추천해주세요!" />';
	$strMeta .= '<meta name="twitter:image" content="'.PATH_PHOTOS_FOLDER.$photo_data['filename_r'].'" />';

	require_once "_include/header.php";

	$width = $file_info['COMPUTED']['Width'];
	$height = $file_info['COMPUTED']['Height'];

	if ($width > 800) {
		$height = floor($height * 800 / $width);
		$width = 800;
	}
?>

<div id="content" class="<?=$pageCode?>">
	<ul class="category">
		<li class="c0 <?if (!$cate) echo 'on';?>"><a href="/">All</a></li>
		<li class="c1 <?if ($cate == '1') echo 'on';?>"><a href="/?cate=1">계절&amp;자연</a></li>
		<li class="c2 <?if ($cate == '2') echo 'on';?>"><a href="/?cate=2">동,식물&amp;생태</a></li>
		<li class="c3 <?if ($cate == '3') echo 'on';?>"><a href="/?cate=3">도시&amp;삶</a></li>
		<li class="c4 <?if ($cate == '4') echo 'on';?>"><a href="/?cate=4">유적지&amp;문화</a></li>
		<li class="c5 <?if ($cate == '5') echo 'on';?>"><a href="/?cate=5">건축&amp;공간</a></li>
		<li class="c6 <?if ($cate == '6') echo 'on';?>"><a href="/?cate=6">사람&amp;사랑</a></li>
		<li class="c7 <?if ($cate == '7') echo 'on';?>"><a href="/?cate=7">여행</a></li>
		<li class="c8 <?if ($cate == '8') echo 'on';?>"><a href="/?cate=8">예술</a></li>
	</ul>

	<div class="content">
		<h2>
			<strong><?=$photo_data['title']?></strong>
			<span class="license">(CC <?=getStringCCL($photo_data['ccl'])?>)</span>
			<span class="author">by <?=$photo_data['nickname']?></span>
		</h2>
		<div class="photo">
			<img src="<?=PATH_PHOTOS_FOLDER.$photo_data['filename_r']?>" width="<?=$width?>"  height="<?=$height?>"  />
			<span class="prev <? if($prev_id==""){echo "dimmed";}?>" <?=$prev_link?>>prev</span>
			<span class="next <? if($next_id==""){echo "dimmed";}?>" <?=$next_link?>>next</span>
		</div>
		<ul class="actions">
			<li><a class="btn-download" href="/_include/download.php?t=photo&r=<?=$photo_data['filename_r']?>&o=<?=urlencode($photo_data['filename_o'])?>">다운로드</a></li>
			<li>
				<a class="btn-info" href="#">사진정보</a>
				<div class="photo-info pop" >
					<table>
						<caption>사진정보</caption>
						<tbody>
						<tr><th>카메라 모델</th><td><?=$file_info['IFD0']['Model']?></td></tr>
						<tr><th>노출시간</th><td><?=$file_info['EXIF']['ExposureTime']?> sec.</td></tr>
						<tr><th>노출보정</th><td><?=$file_info['EXIF']['ExposureBiasValue']?> EV</td></tr>
						<tr><th>프로그램 모드</th><td><?=$program_mode?></td></tr>
						<tr><th>사용렌즈</th><td><?=$file_info['COMPUTED']['ApertureFNumber']?></td></tr>
						<tr><th>초점길이</th><td><?=$file_info['EXIF']['FocalLength']?></td></tr>
						<tr><th>측광모드</th><td><?=$Metering_mode?></td></tr>
						<tr><th>촬영일시</th><td><?=$file_info['EXIF']['DateTimeOriginal']?></td></tr>
						</tbody>
					</table>
					<button class="btn-close">close</button>
				</div>
			</li>
            <? if( empty($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] != $photo_data['member_idx'] ) { ?>
			<li>
				<a class="btn-recommend <?if($Photo->isRecommend($pid,$_SESSION['USER_IDX']) ){ echo "on"; }?>" data-pid="<?=$pid?>" >추천하기</a>
				<p class="msg-recommended pop">추천되었습니다!</p>
			</li>
            <? } ?>
			<li>
				<a class="btn-share" href="">공유하기</a>
				<ul class="share pop">
					<li><a class="facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']?>?pid=<?=$pid?>" target="_blank" >Facebook</a></li>
					<li><a class="twitter" href="http://www.twitter.com/share?url=<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']?>?pid=<?=$pid?>">Twitter</a></li>
				</ul>
			</li>
		</ul>
		<ul class="counts">
			<li class="hit"><?=number_format($photo_data['hits'])?></li>
			<li class="recommended"><?=number_format($photo_data['recommend'])?></li>
		</ul>
		<div class="info">
			<div class="desc">
				<div class="owner">
					<img src="<?=$profile_image?>" width="63" height="63" />
					<span class="photographer">Photographer.</span><span class="name"><?=$photo_data['nickname']?></span><a class="go-gallery" href="/my/gallery.php?m_idx=<?=$photo_data['member_idx']?>">작품 더보기 ►</a>
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
				<div class="fb-comments" data-href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']?>?pid=<?=$pid?>" data-colorscheme="light" data-numposts="5" data-width="780"></div>
			</div>
		</div>
		<a class="btn-top" href="#content">TOP</a>
		<a class="btn-list" href="">목록</a>
	</div>

</div>
<div id="fb-root"></div>
<?
    require_once "_include/footer.php";
?>
