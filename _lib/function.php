<?
    require_once("config.php");

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