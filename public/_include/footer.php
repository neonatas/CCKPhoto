		<div id="footer">
			<p class="host">
				<span>추최/추관</span>
				<a href="http://cckorea.org">creative commons korea</a>
			</p>
			<p class="sponsor">
				<span>후원</span>
				<a class="s1" href="http://www.seoul.go.kr/main/index.html">공유 서울</a>
				<a class="s2" href="http://www.koreasmartcard.co.kr">한국 스마트 카드</a>
				<a class="s3" href="http://www.arttech.or.kr">ART TECH</a>
			</p>
			<p class="links">
				<a class="agreement" href="/other/agreement.php">이용약관</a>
				<a class="privacy" href="/other/privacy.php">개인정보 취급방침</a>
			</p>
			<a class="license" rel="license" href="http://creativecommons.org/licenses/by/2.0/kr/">CC-By</a>
			<span class="license-desc">CCKOREA에 의해 작성된 SharePhoto 웹사이트는 크리에이티브 커먼즈 저작자표시 2.0 대한민국 라이선스에 따라 이용할 수 있습니다.</span>
		</div>
        <? if($pageCode=="gallery" ) {?>
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
            <div id="popupPasswordChange" class="popup">
                <form name="my_passwd_form" id="my_passwd_form" method="post" >
                    <input type="hidden" name="type" />
                    <fieldset class="new-passwd">
                        <legend>새 비밀번호 입력</legend>
                        <input class="text-passwd" type="text" name="passwd" id="newPasswd" placeholder="6자 이상의 숫자를 입력해주세요" />
                        <label for="passwdConfirm">비밀번호 확인</label>
                        <input class="text-passwd-confirm" type="text" id="passwdConfirm" name="passwdConfirm" placeholder="6자 이상의 숫자를 입력해주세요" />
                    </fieldset>
                    <fieldset class="photo">
                        <legend>탈퇴하기</legend>
                        <span id="leaveAgreement"></span>
                        <input type="hidden" name="leave" readonly />
                    </fieldset>
                    <input class="btn-ok" type="button" value="확인" />
                    <input class="btn-cancel" type="button" value="취소"  onclick="$.dialog.close(); return false;" />
                </form>
                <a class="btn-close" href="" onclick="$.dialog.close(); return false;">close</a>
            </div>
        </div>
        <? } else if ($pageCode=="login") { ?>
        <div id="popupContainer">
            <div id="popupBg" onclick="$.dialog.close();"></div>
            <div id="popupPasswordSend" class="popup">
                <form name="find_passwd_form" id="find_passwd_form" >
                    <fieldset class="nick">
                        <legend>메일로 임시 비밀번호 보내기</legend>
                        <span>메일로 보내드린 임시 비밀번호로 다시 로그인해주세요!</span>
                        <input class="text-mail" type="text" name="passwdEmail" id="passwdEmail" placeholder="메일주소를 적어주세요" />
                        <input class="btn-send" type="button" value="확인" />
                    </fieldset>
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