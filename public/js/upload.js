	$(function() {
		//카테고리 select 처리
		$('.select-cate').click(function(){
			$('.select-option').toggle();
		});

		$('.select-option li').click(function(){
			var str_temp = $(this).attr('class');
			var cate_code = str_temp.split('-')[1];
			$('.select-text').text( $(this).text() );
			$('input[name=cate]').val(cate_code);
		});

		//입력창 설명 관련
		$('#uploadArea .msg').click( function() {
			$(this).hide();
			$(this).siblings('.text').focus();
		});
		$('#uploadArea .text').focus( function() {
			$(this).siblings('.msg').hide();
		});
		$('#uploadArea .text').blur( function() {
			if( $(this).val() == '' )
				$(this).siblings('.msg').show();
		});

		//CCL 라이센스 관련
		$('#uploadArea .sub-input-area li').click( function() {
			var objRadio = $(this).find('.btn-radio');
			if( !objRadio.hasClass('on') ) {
				objRadio.addClass('on');
				$(this).siblings('li').find('.btn-radio').removeClass('on');

				var str_temp = $(this).attr('class');
				var arr_temp = str_temp.split('-');
				var ccl_type = arr_temp[1];
				var ccl_code = arr_temp[2];

				if( ccl_type == 'b' )
					$('input[name=ccl_business]').val(ccl_code);
				else if( ccl_type == 'c' )
					$('input[name=ccl_change]').val(ccl_code);
			}
		});

        var f = document.upload_form;
        $('.btn-upload-ok').click(function(){
            if( f.photo.value == "" ) {
                alert("등록할 사진을 선택해 주세요.");
                return false;
            }
            if( f.title.value == "" ) {
                alert("제목을 입력해 주세요.");
                f.title.focus();
                return false;
            }
            if( f.description.value == "" ) {
                alert("설명을 입력해 주세요.");
                f.description.focus();
                return false;
            }
            if( f.cate.value == "" ) {
                alert("카테고리를 선택해 주세요.");
                return false;
            }

            f.action = 'upload_proc.php';
            f.submit();
        });
        $('.btn-upload-cancel').click(function(){
            history.go(-1);
            return false;
        });
	});