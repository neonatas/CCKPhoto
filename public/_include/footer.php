		<div id="footer">
			<p class="host">
				<span>추최/추관</span>
				<a href="http://cckorea.org">creative commons korea</a>
			</p>
			<p class="sponsor">
				<span>후원</span>
				<a class="s1" href="">공유 서울</a>
				<a class="s2" href="">한국 스마트 카드</a>
				<a class="s3" href="">ART TECH</a>
			</p>
			<p class="links">
				<a class="agreement" href="/other/agreement.php">이용약관</a>
				<a class="privacy" href="/other/privacy.php">개인정보 취급방침</a>
			</p>
		</div>
        <? if($pageCode=="gallery") {?>
        <div id="popupContainer">
            <div id="popupBg" onclick="$.dialog.close();"></div>
            <div id="popupDelete" class="popup">
                <span>정말 삭제하시겠습니까?</span>
                <button class="btn-delete">삭제</button>
                <button class="btn-cancel" onclick="$.dialog.close();">취소</button>
            </div>
            <div id="popupProfileUpdate" class="popup">
                <form name="my_form" id="my_form"  enctype="multipart/form-data" method="post" >
                    <input type="hidden" name="re_url" value="<?=$_SERVER['REQUEST_URI']?>" />
                    <fieldset class="nick">
                        <legend>닉네임 또는 이름</legend>
                        <input class="text-nick" type="text" name="nickName" placeholder="닉네임을 적어주세요" />
                        <input class="btn-check-nick" type="button" value="중복확인" />
                        <input type="hidden" name="checkDuplication" />
                    </fieldset>
                    <fieldset class="photo">
                        <legend>프로필 사진 등록</legend>
                        <span class="file"><input type="file" name="myImg" onchange="document.getElementById('fileName').value = this.value.split(/[/\\]/).reverse()[0]" /></span>
                        <input id="fileName" class="text-fn" type="text" readonly />
                    </fieldset>
                    <input class="btn-ok" type="submit" value="확인" />
                    <input class="btn-cancel" type="button" value="취소"  onclick="$.dialog.close(); return false;" />
                </form>
                <a class="btn-close" href="" onclick="$.dialog.close(); return false;">close</a>
            </div>
        </div>
        <? } ?>
	</div>
    <script type="text/javascript" src="/js/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <?=$strJS?>
</body>
</html>