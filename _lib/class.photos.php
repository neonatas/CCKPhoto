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

        if( $array['member_idx'] != "" && $array['title'] != "" && $array['cate_id'] != "" ) {
            $query = "insert into ".$this->table." ( member_idx, cate_id, title, description, tags, ccl, filename_o, filename_r, info, flickr_photoid )";
            $query .= " values ( '".$array['member_idx']."', '".$array['cate_id']."', '".$array['title']."', '".$array['description']."','".$array['tags']."', '".$array['ccl']."', '".$array['filename_o']."', '".$array['filename_r']."', '".$array['info']."', '".$array['photo_id']."' )";

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

    function get($id) {
        $result = array();

        $query = "select p.*, m.* ";
        $query .= ", (select name from category where id = p.cate_id ) as cate_name";
        $query .= " from ".$this->table." p LEFT JOIN members m ON p.member_idx = m.idx ";
        $query .= " where p.id = ".$id;
		$res = mysql_query($query,$this->conn) or die ("get select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);

			return $row;
		} else {
			return NULL;
		}
    }

    function addHits($id, $count=1) {
        $query = "update ".$this->table." set hits = hits + ".$count." where id = ".$id;
        $res = mysql_query($query,$this->conn) or die ("update hits error!!");
    }

    function addRecommend( $photo_id, $member_idx ) {
        $result = array();

		$query = "select photo_id from recommend where photo_id = ".$photo_id." and member_idx = '".$member_idx."'";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) { 
            $row = mysql_fetch_array( $res );
			$result['r'] = 'duplication';
			$result['msg'] = "이미 추천한 사진 입니다.";
			$result['photo_id'] = $photo_id;
		} else {
			$query = "insert into recommend ( photo_id, member_idx ) values ( '".$photo_id."','".$member_idx."' )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");

			if( $res ) {
				$result['r'] = 'success';
				$result['msg'] = "추천 하였습니다.";
				$result['photo_id'] = $photo_id;
			}
		}

		return $result;
    }

    function getList($member_idx="", $sort="d", $cate=0, $start=0, $limit = 0, $keyword="") {
        $result = array();

        $str_where = " where 1 ";
        $str_limit = "";
        if( $member_idx != "" )
            $str_where = " and member_idx = ".$member_idx;
        if( $cate > 0 )
            $str_limit = " and cate_id = ".$cate;
        if( $start > 0 )
            $str_limit = " and id > ".$start;
        if( $limit > 0 )
            $str_limit = " limit ".$limit;
        if( $keyword != "" )
            $str_where = " and ( title like = '%".$keyword."%' or description like = '%".$keyword."%' or  tags like = '%".$keyword."%' ";
        
        $str_sort = " order by ";
        switch( $sort ) {
            case 'd':
                $str_sort .= "createdate";
                break;
            case 'h':
                $str_sort .= "hits";
                break;
            case 'r':
                $str_sort .= "recommend";
                break;
            default:
                $str_sort .= "createdate";
                break;
        }
        $str_sort .= " desc ";

        $query = "select * from ".$this->table." ";
        $query .= $str_where;
        $query .= $str_sort;
        $query .= $str_limit;

		$res = mysql_query($query,$this->conn) or die ("getList select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			while( $row = mysql_fetch_array($res) ) {
				$result[] = $row;
			}
			return $result;
		}

		return $result;
    }
}
?>