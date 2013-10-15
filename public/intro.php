<?
    $pageCode = "intro";

    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";

    require_once "_include/header.php";

?>

	<div id="content" class="<?=$pageCode?>">
		<dl id="introArea">
			<dt><h2><img src="../images/title_intro.png" alt="캠패인소개" /></h2></dt>
			<dd>
				<div class="text-1"><img src="../images/text_intro1.png" alt="'함께 나누는 사진' 캠페인은 사진에 CCL을 붙여 많은 사람들과 사진을 공유하고자 하는 작은 운동입니다." /></div>
				<div class="text-2">
					<img src="../images/text_intro2.png" usemap="#go_galleryis" 
                    alt="응모기간: 2013. 10. 15(화) ~ 11. 24(일)
                    온라인 네티즌 투표 : 2013. 11. 25(월) ~ 12. 01(일)
                    전문가 심사 : 2013. 12. 02(월) ~ 12. 04(수)
                    전시회 : 2013. 12. 05(목)
                    출품작 발표 : 2013. 12. 18(수) ~ 12. 24(화)
                    전시일정 : 갤러리 이즈 www.galleryis.com" />
					<map name="go_galleryis">
						<area shape="rect" coords="160,95,271,114" href="http://www.galleryis.com" target="_blink">
					</map>
				</div>
				<div class="text-3"><img src="../images/text_intro3.png" alt="좋은 사진 필요할 땐?
‘1인 1디카’ 를 거쳐서 ‘1인 1스마트 폰’ 시대라는 표현, 들어보셨지요? 전 국민이 사진가인 시대가 되었습니다. 사람들은 언제, 어디서나 사진을 찍습니다. 멀리 떠나지 않더라도 우리의 일상에서도 소소하지만 아름답고, 재미있고, 멋진, 기록할 만한 것들을 발견할 수 있기 때문입니다. 시간이 흘러 기억조차 희미해진 우리를 추억 속의 선명한 장소와 시간 속으로 데려가 주는 사진은 고마운 도구입니다. 그 아름다운 경험의 순간을 여러 사람들과 나누어보는 것은 어떨까요? 행복 바이러스처럼 기쁨은 전염될 것입니다. 아날로그 방식에서 디지털 방식으로 전환되었더라도 변치 않는 것은 사진이 주는 감동입니다. 디지털화는 사진의 사용과 전파를 쉽고 편하게 해줍니다. 그렇지만 지켜야 할 것이 있답니다. 꼭 필요한 사진이 있을 때 바로 이 저작권 때문에 난감했던 기억이 있으셨지요?  PT나 영상 자료 등을 만들 때 적합한 몇 장의 사진이 간절할 때가 있었을 겁니다. 도처에 떠돌아 다니는 수많은 사진, 어떻게 사용하면 좋을까요?" />
                </div>
				<div class="text-4">
					<img src="../images/text_intro4.png" alt="공유에서 공감으로!
카메라, 스마트폰으로 담은 여러분의 사진에 CCL(Creative Commons License)를 붙여서 웹사이트에 올려주세요. CCL은 ‘출처를 밝혀주고 편하게 사용하세요’, ‘비상업적인 용도 내에서 자유롭게 사용하세요’ 와 같은 조건을 달아서, 이용 허락을 알려주는 방법이에요! 여러분이 원하는 이용 허락을 간단한 그림 마크로 보여주는 것을 CCL (Creative Commons License)라고 한답니다. " usemap="#go_license" />
					<map name="go_license">
						<area shape="rect" coords="610,70,699,92" href="http://cckorea.org/xe/?mid=ccl"  target="_blink">
					</map>
				</div>
				<div class="text-5">
                    <img src="../images/text_intro5.png" alt="당신의 멋진 사진을 갤러리에서 만나세요!
                    좋은 사진을 공유하고자 하는 멋진 당신을 위해,  ‘함께 나누는 사진’ 이 전시회를 열어드립니다.
                    웹사이트를 통해 응모한 사진 중 온라인 투표와 전문가 심사를 통해 선정된 200여 점의 사진을 섹션별로 구성하여 온/오프라인 갤러리에서 전시합니다." 
                    />
                </div>
			</dd>
		</dl>
	</div>


<? require_once "_include/footer.php"; ?>