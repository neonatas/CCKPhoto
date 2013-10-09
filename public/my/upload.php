<?
    $pageCode = "upload";
    
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='/js/".$pageCode.".js'></script>";

    require_once('../../_lib/class.dbConnect.php');
    require_once('../../_lib/class.category.php');

    $DB = new dbConn();
    $Category = new clsCategory( $DB->getConnection() );
    require_once "../_include/header.php";

    //로그인 체크
	if( !isset($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] == '' ) {  
		header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
	}
?>

	
	<div id="content" class="<?=$pageCode?>">
		<div id="uploadArea">
			<h2><img src="../images/title_upload.png" alt="사진올리기" /></h2>
			<form name="upload_form" id="upload_form"  enctype="multipart/form-data" method="post">
			<fieldset>
				<dl class="input-area1 b-line">
					<dt><img src="../images/title_upload_register.png" alt="사진 등록"/></dt>
					<dd>
						<span id="btnFileUpload"><input type="file" name="photo" onchange="javascript: document.getElementById('fileName').value = this.value.split(/[/\\]/).reverse()[0]" /></span>
						<input type="text" id="fileName" value="" readonly />
					</dd>
				</dl>
				<dl class="input-area2 b-line">
					<dt><img src="../images/title_upload_title.png" alt="작품 제목"/></dt>
					<dd>
						<input type="text" name="title" maxlength="20" class="input-535 text" />
						<img src="../images/text_upload_title_desc.png" class="msg" />
					</dd>
				</dl>
				<dl class="input-area3 b-line">
					<dt><img src="../images/title_upload_desc.png" alt="설명"/></dt>
					<dd>
						<textarea name="description" class="text" ></textarea>
						<img src="../images/text_upload_desc_desc.png" class="msg" />
					</dd>
				</dl>
				<dl class="input-area4 b-line">
					<dt><img src="../images/title_upload_cate.png" alt="카테고리"/></dt>
					<dd>
						<div class="select-cate">
							<span class="select-text">선택하세요.</span>
							<ul class="select-option">
                            <?
                                foreach( $Category->getList() as $arr ) {
                            ?>
								<li class="cate-<?=$arr['id']?>"><?=$arr['name']?></li>
                            <?}?>
							</ul>
						</div>
						<input type="hidden" name="cate" />
					</dd>
				</dl>
				<dl class="input-area5 b-line">
					<dt><img src="../images/title_upload_tags.png" alt="태그"/></dt>
					<dd>
						<input type="text" name="tags" class="input-535 text tag" />
						<img src="../images/text_upload_tags_desc.png" class="msg" />
					</dd>
				</dl>
				<dl class="input-area6">
					<dt>
						<div>
							<img src="../images/title_upload_cc.png" alt="CC 라이센스"/>
							<img src="../images/btn_upload_ccl_view.png" alt="CC 라이센스 설명보기"/>
						</div>
					</dt>
					<dd>
						<img src="../images/text_upload_ccl_essential.png" alt="제작자 표시는 필수입니다."/>
						<div class="sub-input-area">
							<dl>
								<dt><img src="../images/sub_title_upload_business.png" alt="상업적 이용"/></dt>
								<dd>
									<ul>
										<li class="ccl-b-1">
											<span class="btn-radio on"></span>
											<img src="../images/text_upload_ccl_permission.png" alt="상업적 이용 허락" />
										</li>
										<li class="ccl-b-2">
											<span class="btn-radio"></span>
											<img src="../images/text_upload_ccl_permission_no.png" alt="상업적 이용 허락하지 않음"/>
										</li>
									</ul>
									<input type="hidden" name="ccl_business" value="1"/>
								</dd>
							</dl>
							<dl>
								<dt><img src="../images/sub_title_upload_change.png" alt="저작물의 변경"/></dt>
								<dd>
									<ul>
										<li class="ccl-c-1">
											<span class="btn-radio on"></span>
											<img src="../images/text_upload_ccl_permission.png" alt="저작물의 변경 허락" />
										</li>
										<li class="ccl-c-2">
											<span class="btn-radio"></span>
											<img src="../images/text_upload_ccl_permission_no.png" alt="저작물의 변경 허락하지 않음"/>
										</li>
										<li class="ccl-c-3">
											<span class="btn-radio"></span>
											<img src="../images/text_upload_ccl_same.png" alt="동일한 이용조건 적용"/>
										</li>
									</ul>
									<input type="hidden" name="ccl_change" value="1"/>
								</dd>
							</dl>
						</div>
					</dd>
				</dl>
				<div class="button-area">
					<img src="../images/btn_join_ok.png" alt="확인" class="btn-upload-ok" /><img src="../images/btn_join_cancel.png" alt="취소" class="btn-upload-cancel" />
				</div>
			</fieldset>
			</form>
		</div>
	</div>

<?
    require_once "../_include/footer.php";
?>

<script type="text/javascript">
<!--
    $(function(){
        var f = document.upload_form;
        $('.btn-upload-ok').click(function(){
            f.action = 'upload_proc.php';
            f.submit();
        });
        $('.btn-upload-cancel').click(function(){
            history.go(-1);
            return false;
        });
    });
//-->
</script>