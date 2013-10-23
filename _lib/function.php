<?
    require_once("config.php");

    function checkAgreementLocation($agree, $return_url) {
        $r_url = "/";

        if( $agree == "y" ) {
            $r_url = $return_url;
        } else {
            $r_url = "/member/join_confirm.php?re_url=".$return_url;
        }

        header('Location: '.$r_url);
    }

    function getStringCCL($num) {
        switch( $num ) {
            case FLICKR_BY_NC_SA:
                $str = "BY-NC-SA";
                break;
            case FLICKR_BY_NC:
                $str = "BY-NC";
                break;
            case FLICKR_BY_NC_ND:
                $str = "BY-NC-ND";
                break;
            case FLICKR_BY:
                $str = "BY";
                break;
            case FLICKR_BY_SA:
                $str = "BY-SA";
                break;
            case FLICKR_BY_ND:
                $str = "BY-ND";
                break;
        }

        return $str;
    }

    function goDetailLink($pid, $keyword="", $cate="", $sort="d", $member_idx = "" ) {
        $link = "/detail.php?pid=".$pid;
        if( $keyword != "" )
            $link .= "&keyword=".$keyword;
        if( $cate != "" ) 
            $link .= "&cate=".$cate;
        if( $sort != "" )
            $link .= "&sort=".$sort;
        if( $member_idx != "" )
            $link .= "&m_idx=".$member_idx;
        
        return $link;
    }

    function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) 
    {
      // open the directory
      $dir = opendir( $pathToImages );

      // loop through it, looking for any/all JPG files:
      while (false !== ($fname = readdir( $dir ))) {
        // parse path for the extension
        $info = pathinfo($pathToImages . $fname);
        // continue only if this is a JPEG image
        if ( strtolower($info['extension']) == 'jpg' ) 
        {
          echo "Creating thumbnail for {$fname} <br />";

          // load image and get image size
          $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
          $width = imagesx( $img );
          $height = imagesy( $img );

          // calculate thumbnail size
          $new_width = $thumbWidth;
          $new_height = floor( $height * ( $thumbWidth / $width ) );

          // create a new temporary image
          $tmp_img = imagecreatetruecolor( $new_width, $new_height );

          // copy and resize old image into new image 
          imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

          // save thumbnail into a file
          imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
        }
      }
      // close the directory
      closedir( $dir );
    }


	function removeQuot($str) {
		$str = str_replace("\"","",$str);
		$str = str_replace("'","",$str);
		return trim($str);
	}
	function addSlash($str) {
		$str = trim($str);
		$str = addslashes($str);
		return trim($str) ;
	}

	function stripSlash($str) {
		$str = stripslashes($str);
		return trim($str);
	}

	function alertMsg($ment,$url,$parent="",$opt="") {
		echo "<script>alert(\"$ment\");" .$parent . "location.href='$url';" . $opt."</script>";
		exit;
	}

	function alertNotMsg($url,$parent="",$opt="") {
		echo "<script>".$parent . "location.href='$url';" . $opt."</script>";
		exit;
	}

	function metaMsg($url) {
		echo "<meta http-equiv=Refresh content='0;url=$url'>";
		exit;
	}

	function historyBack($ment) {
		echo "<script>alert(\"$ment\");history.back();</script>";
		exit;
	}

	function historyBackNoMsg() {
		echo "<script>history.back();</script>";
		exit;
	}
?>