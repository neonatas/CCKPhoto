<?php
/**
 * 섬네일 생성 클래스
 * PHPSchool 괴부기님의 코드를 원본으로 상당부분 수정하였습니다.
 *
 * @class		Thumbnail
 * @author		괴부기, KAi
 * @version		0.2 (2011-06-21)
 * @see			http://phpschool.com/gnuboard4/bbs/board.php?bo_table=tipntech&wr_id=46878
 * @modified	KAi (2011-06-21)
 *
 *
 * - 주요기능
 *   - 섬네일 width, height 지정 가능 (둘 중 하나만 지정할 경우 해당 이미지 비율에 맞춰 섬네일 크기 설정)
 *   - 축소 방법 설정 (섬네일 안에 이미지 모두 보이게, 섬네일 크기에 꽉차게 설정 가능)
 *   - 출력 섬네일 파일형식 설정 가능 (GIF, JPG, PNG)
 *   - 섬네일 처리 전/후 콜백 함수 등록 가능 (콜백함수로 테두리 및 워터마크 등 사용자가 쉽게 추가 가능)
 *   - 섬네일 저장 경로를 쉽게 설정 가능 (키워드 사용으로 섬네일 경로에 이미지 크기나 경로를 쉽게 사용)
 *
 *
 * - examples
 *
 *  // 섬네일 크기를 폭만 80 픽셀로 설정하여, 폭을 기준으로 원본 이미지 비율에 맞게 섬네일 크기를 설정한다.
 *  // 섬네일 크기를 width, height 중 하나만 설정할 경우 scale 방식은 상관없이 SCALE_SHOW_ALL로 설정된다.
 *  // setOption() 함수로 기본적인 설정값을 변경할 수 있으며, create() 함수에서 옵션을 설정하지 않으면 기본적인
 *  // 설정값 대로 섬네일을 생성한다.
 *  Thumbnail::setOption('export', EXPORT_PNG);// 섬네일 출력을 PNG 로 변경 (옵션을 지정하지 않으면 jpg로 출력)
 *  Thumbnail::create('image.jpg',
 *					  80, null// 섬네일 width, height
 *					  );
 *
 *  // 섬네일 크기 80x80 픽셀로 이미지를 SCALE_SHOW_ALL 형식으로 축소한다.
 *  // 섬네일은 콜백함수를 등록하여 배경 및 테두리를 그리고, 저장 경로에 _thumb-widthxheight 문자열을
 *  // 추가한다.
 *  $watermark = new ThumbnailWatermark;
 *  Thumbnail::create('image.jpg',
 *					  80, 80,// 섬네일 width, height
 *					  SCALE_SHOW_ALL,// 섬네일 축소 형식
 *					  Array(
 *						  'export' => EXPORT_JPG,
 *						  'preprocess' => Array(&$watermark, 'preprocess'),
 *						  'postprocess' => Array(&$watermark, 'postprocess'),
 *						  'savepath' => '%PATH%%FILENAME%_thumb-%THUMB_WIDTH%x%THUMB_HEIGHT%.%EXT%'
 *					  ));
 */

define('SCALE_EXACT_FIT', 'exactfit');
define('SCALE_SHOW_ALL', 'showall');

define('EXPORT_JPG', 'jpg');
define('EXPORT_GIF', 'gif');
define('EXPORT_PNG', 'png');

class Thumbnail
{
	// {{{ Variables

	// 기본 옵션 정보
	private static $_TdefaultOptions = Array(
		'debug' => false,
		'export' => 'jpg',
		'preprocess' => null,
		'postprocess' => null,
		'savepath' => '%PATH%%FILENAME%_thumb.%EXT%'
	);

	// }}}
	// {{{ Functions

	/**
	 * 섬네일 이미지 생성
	 *
	 * @param	String	$filepath	원본 파일이 있는 경로를 지정한다.
	 * @param	Number	$width		(optional) 섬네일 넓이. width와 height 둘 중 하나는 반드시 지정되어야 하며,
	 *  하나가 null 인 경우 다른 값(width 또는 height)을 기준으로 이미지의 비율에 맞게 크기가 설정된다.
	 * @param	Number	$height		(optional) 섬네일 높이.
	 * @param	String	$scale		(optional) 축소 방식. 만약, width 또는 height 값 중 하나라도 지정이 안된경우
	 *  scale 은 자동적으로 SCALE_SHOW_ALL이 되며 이미지 전체가 표시 된다.
	 *  SCALE_EXACT_FIT, SCALE_SHOW_ALL 둘 중 하나를 지정가능 하고, width 및 height 값이 지정된 경우 해당 방식에
	 *  맞게 축소가 되는데, SCALE_EXACT_FIT 의 경우 지정된 섬네일 크기에 이미지가 꽉차게 축소된다.
	 *  SCALE_SHOW_ALL 의 경우 섬네일 크기 안에 원본 이미지가 모두 보이도록 축소된다. 이 경우 섬네일에 여백이
	 *  생길 수 있다. 기본적으로 여백의 색은 검은색이지만, preprocess 함수를 지정하여 다른색으로 변경 가능하다.
	 * @param	Array	$options	(optional) 기타 옵션. 기타 옵션에서는 출력될 섬네일 파일 형식과, 섬네일 전/후
	 *  처리 콜백 함수, 섬네일 저장 경로를 설정 가능하다.
	 *
	 *	- 옵션 항목
	 *		$options = Array(
	 *			'export' => 'jpg',
	 *			'preprocess' => Array(&$class, 'preprocess'),
	 *			'postprocess' => 'postprocess',
	 *			'savepath' => '%PATH%%FILENAME%_thumb.%EXT%'
	 *		);
	 *
	 *  export 에서는 gif, jpg, png 를 선택할 수 있다. (기본값은 jpg)
	 *  preprocess, postprocess 에서는 섬네일 생성시 이미지 축소 전/후에 콜백함수를 호출하여 배경 및 워터마크를
	 *  넣도록 할 수 있다. 설정방법은 여타 PHP 함수 호출과 마찬가지로, 클래스 메소드를 호출할 경우 preprocess
	 *  내용 처럼 배열로 클래스 객체와 메소드를 넘겨주면되고, 일반 함수를 호출할 경우 postprocess 처럼 함수명을
	 *  적으면 된다.
	 *  savepath 는 섬네일이 저장된 경로를 설정하는 것으로 미리 설정된 키워드를 통해 원본이미지 경로 정보를 이용
	 *  할 수 있다. 기본값은 원본이미지 경로 뒤에 _thumb 이 붙는것으로 원본이미지와 같은 폴더에 저장이 된다.
	 *  다른 폴더에 저장을 하려면 %PATH% 키워드 앞이나 뒤에 다른 경로를 적거나 %PATH% 대신 다른 경로를 적으면 되며
	 *  만약 해당 경로에 폴더가 없다면 자동으로 생성 된다.
	 *  ※ 중요: savepath 설정할때 %EXT% 와 같은 확장자가 빠지면 확장자 없이 이미지 경로가 생성되기 때문에 문제가
	 *           될 수 있습니다.
	 *
	 *	- 설정된 키워드
	 *		%PATH%			원본 이미지 경로
	 *		%FILENAME%		원본 이미지 파일명 (확장자 제외)
	 *		%EXT%			섬네일 출력 형식 확장자 (옵션에서 export 로 설정된 형식의 확장자 사용)
	 *		%THUMB_WIDTH	섬네일 넓이
	 *		%THUMB_HEIGHT	섬네일 높이
	 *		%IMAGE_WIDTH	원본 이미지 넓이
	 *		%IMAGE_HEIGHT	원본 이미지 높이
	 *
	 * @return	String				섬네일 경로
	 */
	public static function create($filepath, $width = null, $height = null, $scale = 'exactfit', $options = null)
	{
		// 원본 이미지가 없는 경우
		if ( ! file_exists($filepath))
			Thumbnail::raiseError('#Error: Thumbnail::create() : File not found or permission error.'.' at '. __LINE__);

		// 섬네일 크기가 잘못 지정된 경우
		if ($width <= 1 && $height <= 1)
			Thumbnail::raiseError('#Error: Thumbnail::create() : Invalid thumbnail size.'.' at '. __LINE__);

		// 스케일 지정이 안되어 있거나 틀릴 경우 기본 SCALE_SHOW_ALL 으로 지정
		if ( ! $scale || ($scale != SCALE_EXACT_FIT && $scale != SCALE_SHOW_ALL))
			$scale = SCALE_SHOW_ALL;

		// 기타 옵션
		if ($options)
			$options = array_merge(Thumbnail::$_TdefaultOptions, $options);

		// 옵션 중 출력 이미지 형식이 잘못 지정된 경우
		if ( ! in_array($options['export'], Array('jpg', 'gif', 'png')))
			Thumbnail::raiseError('#Error: Thumbnail::create() : Invalid export format.'.' at '. __LINE__);

		// 이미지 타입이 지원되지 않는 경우
		// 1 = GIF, 2 = JPEG
		$type = getimagesize($filepath);
		if (($type[2] < 1 || $type[2] > 2) ||
			($type[2] == 1 && ! function_exists('imagegif')) ||
			($type[2] == 2 && ! function_exists('imagejpeg')))
		{
			Thumbnail::raiseError('#Error: Thumbnail::create() : Filetype not supported. Thumbnail not created.'.' at '. __LINE__);
		}


		// 원본 이미지로부터 Image 객체 생성
		switch ($type[2])
		{
			case 1: $image = imagecreatefromgif($filepath); break;
			case 2: $image = imagecreatefromjpeg($filepath); break;
		}

		// AntiAlias
		if (function_exists('imageantialias'))
			imageantialias($image, TRUE);


		// 이미지 크기 설정
		$image_attr = getimagesize($filepath);
		$image_width = $image_attr[0];
		$image_height = $image_attr[1];

		if ($width > 0 && $height > 0)
		{
			// 섬네일 크기 안에 모두 표시
			// 이미지의 가장 큰 면을 기준으로 지정
			switch ($scale)
			{
				case SCALE_SHOW_ALL: $side = ($image_width >= $image_height) ? 'width' : 'height'; break;
				case SCALE_EXACT_FIT:
				default: $side = ($image_width / $width <= $image_height / $height) ? 'width' : 'height'; break;
			}

			$thumb_x = $thumb_y = 0;
			if ($side == 'width')
			{
				$ratio = $image_width / $width;
				$thumb_width = $width;
				$thumb_height = floor($image_height / $ratio);
				$thumb_y = round(($height - $thumb_height) / 2);
			}
			else
			{
				$ratio = $image_height / $height;
				$thumb_width = floor($image_width / $ratio);
				$thumb_height = $height;
				$thumb_x = round(($width - $thumb_width) / 2);
			}
		}
		else
		{
			// width 또는 height 크기가 지정되지 않았을 경우,
			// 지정된 섬네일 크기 비율에 맞게 다른 면의 크기를 맞춤
			$thumb_x = $thumb_y = 0;
			if ( ! $width)
			{
				$thumb_width = $width = intval($image_width / ($image_height / $height));
				$thumb_height = $height;
			}
			elseif ( ! $height)
			{
				$thumb_width = $width;
				$thumb_height = $height = intval($image_height / ($image_width / $width));
			}
		}


		// 섬네일 객체 생성
		$thumbnail = imagecreatetruecolor($width, $height);

		if ($options['preprocess'])
			call_user_func($options['preprocess'], &$thumbnail, $width, $height, $thumb_width, $thumb_height);

		@imagecopyresampled($thumbnail, $image, $thumb_x, $thumb_y, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);

		if ($options['postprocess'])
			call_user_func($options['postprocess'], &$thumbnail, $width, $height, $thumb_width, $thumb_height);


		// 저장할 경로 생성 및 디렉토리 검사
		preg_match('@^(.+/)?([^/]+)\.([^.]+)?$@', $filepath, $m);
		$savepath = str_replace(Array('%PATH%', '%FILENAME%', '%EXT%', '%THUMB_WIDTH%', '%THUMB_HEIGHT%', '%IMAGE_WIDTH%', '%IMAGE_HEIGHT%'), Array($m[1], $m[2], $options['export'], $width, $height, $image_width, $image_height), $options['savepath']);
		Thumbnail::validatePath($savepath);


		// 지정된 포멧으로 섬네일이미지 저장
		$iserror = false;
		switch ($options['export'])
		{
			case EXPORT_GIF: if ( ! imagegif($thumbnail, $savepath)) $iserror = true; break;
			case EXPORT_PNG: if ( ! imagepng($thumbnail, $savepath)) $iserror = true; break;
			case EXPORT_JPG:
			default: if ( ! imagejpeg($thumbnail, $savepath)) $iserror = true; break;
		}

		if ($iserror)
			Thumbnail::raiseError('#Error: Thumbnail::create() : invalid path or permission error.'.' at '. __LINE__);
		elseif (Thumbnail::getOption('debug'))
		{
			echo '@Debug: Thumbnail::create() - source='. $filepath .', image[width='. $image_width .',height='. $image_height .'], '
				.'thumb[width='. $width .',height='. $height .'], scale='. $scale .', scaled[x='. $thumb_x .',y='. $thumb_y
				.',width='. $thumb_width .',height='. $thumb_height .']<br />'."\n";
		}

		return $savepath;
	}// END: function create();

	/**
	 * 기본 옵션 항목을 변경한다.
	 *
	 * @param	String	$name	옵션명
	 * @param	mixed	$value	값
	 * @return	void
	 */
	public static function setOption($name, $value)
	{
		Thumbnail::$_TdefaultOptions[ $name ] = $value;
	}

	/**
	 * 기본 옵션 항목의 값을 반환한다.
	 *
	 * @param	String	$name	옵션명
	 * @return	mixed			값
	 */
	public static function getOption($name)
	{
		return Thumbnail::$_TdefaultOptions[ $name ];
	}

	/**
	 * 경로가 존재하는지 체크하고 없다면 폴더를 생성
	 * @param	String	$path					체크할 경로
	 * @return	Boolean							true
	 */
	public static function validatePath($path)
	{
		$a = explode('/', dirname($path));
		$p = '';
		foreach ($a as $v)
		{
			$p.= $v .'/';
			if ( ! is_dir($p))
				mkdir($p, 0757);
		}

		return true;
	}// END: function validatePath();

	/**
	 * 오류 처리 핸들러
	 * @param	String	$msg	메시지
	 * @param	int		$code	오류 코드
	 * @param	int		$type	오류 형식
	 */
	public static function raiseError($msg, $code = 0, $type = 0)
	{
		die($msg);
	}// END: function raiseError();

	// }}}
}// END: class Thumbnail

/**
 * 샘플 워터마크 클래스
 * 이 클래스에서는 이미지 배경색과 테두리 선을 추가하는 예를 보여줍니다.
 * preprocess 및 postprocess 함수에서는 Thumbnail 클래스에서 지정한 파라메터를 넘겨 받습니다.
 */
class ThumbnailWatermark
{
	/**
	 * Thumbnail 클래스에서 preprocess 및 postprocess 함수 호출시 넘겨주는 파라메터들
	 *
	 * @param	Resource	$resource		GD Image 함수용 섬네일 리소스
	 * @param	Number		$thumb_width	섬네일 넓이
	 * @param	Number		$thumb_height	섬네일 높이
	 * @param	Number		$image_width	섬네일 안에서 축소된 이미지의 넓이
	 * @param	Number		$image_height	섬네일 안에서 축소된 이미지의 높이
	 * ※만약, 섬네일 scale 이 SCALE_SHOW_ALL 일 경우, 섬네일 크기보다 이미지가 작아질 수 있습니다.
	 * @return	void
	 */
	public function preprocess($resource, $thumb_width, $thumb_height, $image_width, $image_height)
	{
		// 입력한 색상으로 전체 이미지를 칠한다.
		$color = ImageColorAllocate($resource, 240, 240, 240);
		ImageFilledRectangle($resource, 0, 0, $thumb_width, $thumb_height, $color);
	}

	public function postprocess($resource, $thumb_width, $thumb_height, $image_width, $image_height)
	{
		$color = ImageColorAllocate($resource, 0, 0, 0);
		ImageLine($resource, 0, 0, $thumb_width - 1, 0, $color);
		ImageLine($resource, $thumb_width - 1, 0, $thumb_width - 1, $thumb_height - 1, $color);
		ImageLine($resource, $thumb_width - 1, $thumb_height - 1, 0, $thumb_height - 1, $color);
		ImageLine($resource, 0, $thumb_height - 1, 0, 0, $color);
	}
}// END: class ThumbnailWatermark