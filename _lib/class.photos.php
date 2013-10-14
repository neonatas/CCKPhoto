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
            echo $query .= " values ( '".$array['member_idx']."', '".$array['cate_id']."', '".$array['title']."', '".$array['description']."','".$array['tags']."', '".$array['ccl']."', '".$array['filename_o']."', '".$array['filename_r']."', '".$array['info']."', '".$array['photo_id']."' )";

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

    function getPhotoInfo($path) {
        return exif_read_data($path, 0, true);
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
        
        if ( array_search(strtolower($ext), $arr_ext) === false )
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
        $query .= " where p.id = ".$id." and m.is_leave = 'n'";
		$res = mysql_query($query,$this->conn) or die ("get select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);

			return $row;
		} else {
			return NULL;
		}
    }

    function delete($id) {
        $data = $this->get($id);
        $flickr_id = $data['flickr_photoid'];

        unlink( PATH_PHOTOS_UPLOAD.$data['filename_r'] );
        $query = "delete from ".$this->table." where id = ".$id;
        $res = mysql_query($query,$this->conn) or die ("delete query error!!");

		if( $res ) {
			return $flickr_id;
		} else {
			return false;
		}
    }


    function getRecommendCount($id) {
        $result = array();

        $query = "select recommend ";
        $query .= " from ".$this->table;
        $query .= " where id = ".$id;
		$res = mysql_query($query,$this->conn) or die ("get select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);

			return $row['recommend'];
		} else {
			return 0;
		}
    }

    function getPrevNextId($curr_id, $member_idx = "", $sort = "d", $cate, $keyword = "") {
        $result = $this->getList($member_idx, $sort, $cate, 0, 0, $keyword);
        
        $result_id = array("prev" => "", "next" => "" );

        for($i=0; $i < count($result); $i++ ) {
            if( $result[$i]['id'] == $curr_id ) {
                if( $i > 0 )
                    $result_id['prev'] = $result[$i-1]['id'];
                if( $i + 1 < count($result) )
                    $result_id['next'] = $result[$i+1]['id'];
                break;
            }
        }

        return $result_id;
    }

    function incrementHits($id, $count=1) {
        $query = "update ".$this->table." set hits = hits + ".$count." where id = ".$id;
        $res = mysql_query($query,$this->conn) or die ("update hits error!!");

        return $res;
    }

    function isRecommend($photo_id, $member_idx) {
		$query = "select photo_id from recommend where photo_id = ".$photo_id." and member_idx = '".$member_idx."'";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

        if( @mysql_affected_rows() > 0 ) 
            return true;
        else
            return false;
    }

    function incrementRecommend( $photo_id, $member_idx ) {
        $result = array();

		if( $this->isRecommend($photo_id, $member_idx) ) { 
			$result['r'] = 'duplication';
			$result['msg'] = "이미 추천 하셨습니다.";
		} else {
			$query = "insert into recommend ( photo_id, member_idx ) values ( '".$photo_id."','".$member_idx."' )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");

            $query = "update ".$this->table." set recommend = recommend + 1 where id = ".$photo_id;
            $res = mysql_query($query,$this->conn) or die ("incrementRecommend update query error!!");

            if( @mysql_affected_rows() > 0 ) {
				$result['r'] = 'success';
				$result['msg'] = "추천 하였습니다.";
				$result['count'] = $this->getRecommendCount($photo_id);
			}
		}

		return $result;
    }

    function decrementRecommend( $photo_id, $member_idx ) {
        $result = array();
        $recomm_cnt = $this->getRecommendCount($photo_id);

		if( !$this->isRecommend($photo_id, $member_idx) ) { 
			$result['r'] = 'duplication';
			$result['msg'] = "";
		} else {
			$query = "delete from recommend where photo_id = '".$photo_id."' and member_idx = '".$member_idx."'";
			$res = mysql_query($query,$this->conn) or die ("delete query error!!");

            $recomm_cnt--;
            if( $recomm_cnt < 0 ) $recomm_cnt = 0;
            $query = "update ".$this->table." set recommend = ".$recomm_cnt." where id = ".$photo_id;
            $res = mysql_query($query,$this->conn) or die ("decrementRecommend update query error!!");

            if( $res ) {
				$result['r'] = 'success';
				$result['msg'] = "취소 하였습니다.";
				$result['count'] = $this->getRecommendCount($photo_id);
			}
		}

		return $result;
    }

    function getList($member_idx="", $sort="d", $cate=0, $start=0, $count = 0, $keyword="") {
        $result = null;

        $str_where = " where 1 ";
        $str_limit = "";
        if( $member_idx != "" )
            $str_where .= " and p.member_idx = ".$member_idx;
        if( $cate > 0 )
            $str_where .= " and p.cate_id = ".$cate;
        if( $count > 0 )
            $str_limit = " limit ".$start.",".$count;
        if( $keyword != "" )
            $str_where .= " and ( p.title like '%".$keyword."%' or p.description like '%".$keyword."%' or  p.tags like '%".$keyword."%' ) ";
        
        $str_sort = " order by ";
        switch( $sort ) {
            case 'd':
                $str_sort .= "p.createdate";
                break;
            case 'h':
                $str_sort .= "p.hits";
                break;
            case 'r':
                $str_sort .= "p.recommend";
                break;
            default:
                $str_sort .= "p.createdate";
                break;
        }
        $str_sort .= " desc ";

        $query = "select * from ".$this->table." p LEFT JOIN members m ON p.member_idx = m.idx ";
        $query .= $str_where." and m.is_leave = 'n'";
        $query .= $str_sort;
        $query .= $str_limit;

		$res = mysql_query($query,$this->conn) or die ("getList select query error!!");
        $result = array();
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