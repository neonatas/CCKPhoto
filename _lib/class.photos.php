<?
require_once("config.php");

class clsPhotos {
    var $conn;
    var $table = "photos";

    function __construct( $conn ) {
        $this->conn = $conn;
    }

    function save($array) {
        $result = array();

        if( $array['member_id'] != "" && $array['title'] != "" && $array['cate_id'] != "" ) {
            $query = "insert into ".$this->table." ( member_id, cate_id, title, description, tags, ccl, filename_o, filename_r, info, createdate, flickr_photoid )";
            $query .= " values ( '".$array['member_id']."', '".$array['cate_id']."', '".$array['title']."', '".$array['description']."','".$array['tags']."', '".$array['ccl']."', '".$array['filename_o']."', '".$array['filename_r']."', '".$array['info']."', now(), '".$array['photo_id']."' )";

            $res = mysql_query($query,$this->conn) or die ("insert query error!!");

            if( $res ) {
                $result['r'] = "success";
                $result['idx'] = mysql_insert_id();
                $result['msg'] = MSG_PHOTO_UPLOAD_SUCCESS;
            } else {
                $result['r'] = "error";
                $result['msg'] = MSG_PHOTO_UPLOAD_FAILE;
            }
        } else {
            $result['r'] = 'error';
            $result['msg'] = MSG_INPUT_DATA_FAILE;
        }

        return $result;
    }

/*
	function incrementFavorite( $idx ) {
		$query = "select f_count from contents  where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("incrementFavorite select query error!!");
		$row = mysql_fetch_array($res);

		$f_count = (int)$row['f_count'] + 1;

		$query = "update contents set f_count = ".$f_count." where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("incrementFavorite update query error!!");

		return $f_count;
	}
*/

    function checkExtension( $ext ) {
        $arr_ext = explode(',',VALID_PHOTO_EXT);
        
        if ( array_search($ext, $arr_ext) === false )
            return false;

        return true;
    }

    function checkSize( $size ) {
        if( $size > MAX_PHOTO_SIZE )
            return false;

        return true;
    }

}
?>