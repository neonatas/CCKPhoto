<?
require_once("config.php");

class clsMembers {
	var $conn;
    var $table = "members";

	function __construct( $conn ) {
		$this->conn = $conn;
	}

	function getOauthMemberIdx($type,$id,$nickname="",$my_img="") {
		$result = array();
		$field = "";
		switch( $type )
		{
			case 'twitter':
				$field .= "twitter_id";
				break;
			case 'facebook':
				$field .= "facebook_id";
				break;
		}

		$query = "select idx, policy_agree, my_img_r, level from ".$this->table." where ".$field." = '".$id."' and is_leave = 'n' ";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) { 
			$row = mysql_fetch_array( $res );
			$query = "update ".$this->table." set logindate = now() ";
            if( empty($row['my_img_r']) ) {
                $query .= ", my_img_o = '".$my_img."', my_img_r='".$my_img."'";
                $profile_img = $my_img;
            } else {
                $profile_img = $row['my_img_r'];
            }
            $query .= " where idx = ".$row['idx'];

			mysql_query($query,$this->conn) or die ("update query error!!");

			$result['r'] = 'success';
			$result['msg'] = "이미 가입된 회원 입니다.";
			$result['idx'] = $row['idx'];
			$result['policy_agree'] = $row['policy_agree'];
            $result['my_img'] = $profile_img;
            $result['level'] = $row['level'];
		} else {
			$query = "insert into ".$this->table." ( ".$field.", nickname, logindate, policy_agree, my_img_r ) values ( '".$id."','".$nickname."', now(), 'y', '".$my_img."' )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");

			if( $res ) {
				$result['r'] = 'success';
				$result['msg'] = "회원 가입이 완료되었습니다.";
				$result['idx'] = mysql_insert_id();
				$result['policy_agree'] = 'n';
                $result['my_img'] = $my_img;
                $result['level'] = $row['level'];
			}
		}

		return $result;
	}

	function existEmail($email) {
		$query = "select idx from ".$this->table." where email = '".$email."' and is_leave = 'n'";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			return $res['idx'];
		} else {
			return false;
		}
	}

	function existNickName($nickname) {
		$query = "select idx from ".$this->table." where nickname = '".$nickname."' and is_leave = 'n' ";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			return $res['idx'];
		} else {
			return false;
		}
	}

	function joinMember($array) {
		$result = array();

		if( $this->existEmail($array['email']) ) {
			$result['r'] = 'error';
			$result['msg'] = "이미 가입된 이메일 입니다.";
		} else {
			$query = "insert into ".$this->table." ( email, nickname, passwd, policy_agree, joindate, logindate ) values ( '".$array['email']."','".$array['nickname']."', '".md5($array['passwd'])."', '".$array['policy_agree']."', now(), now() )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");;

			$result['r'] = 'success';
			$result['msg'] = "회원 가입이 완료되었습니다.";
			$result['idx'] = mysql_insert_id();
			$result['policy_agree'] = $array['policy_agree'];
            $result['level'] = 9;
		}

		return $result;
	}

	function saveAutoKey( $m_idx, $key ) {
		$result = array();

		$query = "update ".$this->table." set auto_key = '".$key."' where idx = ".$m_idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function getDataFromAutoKey($key) {
		$query = "select * from ".$this->table." where auto_key = ".$key;
		$res = mysql_query($query,$this->conn) or die ("getMember select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);
			return $row;
		} else {
			return NULL;
		}
	}


	function updatePolicyAgree($idx, $agree) {
		$query = "update ".$this->table." set policy_agree = '".$agree."' where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return $agree;
		} else {
			return false;
		}
	}

	function updateNickName($idx, $nickname) {
        if( empty($idx) || empty($nickname) ) {
            return false;
        }

		$query = "update ".$this->table." set nickname = '".$nickname."' where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return $nickname;
		} else {
			return false;
		}
	}

	function updatePasswd($idx, $passwd) {
        if( empty($idx) || empty($passwd) ) {
            return false;
        }

		$query = "update ".$this->table." set passwd = '".md5($passwd)."' where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function updateProfileImage($idx, $img_r, $img_o) {
        if( empty($idx) || empty($img_r) || empty($img_o) ) {
            return false;
        }

		$query = "update ".$this->table." set my_img_r = '".$img_r."', my_img_o = '".$img_o."' where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function loginMember($array) {

		$result = array();

		if( $this->existEmail($array['email']) !== false ) {
			$query = "select idx, level, policy_agree, nickname, level from ".$this->table." where email = '".$array['email']."' and passwd = '".md5($array['passwd'])."' and is_leave = 'n' ";
			$res = mysql_query($query,$this->conn) or die ("select query error!!");

			if( @mysql_affected_rows() > 0 ) {
				$row = mysql_fetch_array($res);
				$query = "update ".$this->table." set logindate = now() where idx = ".$row['idx'];
				mysql_query($query,$this->conn) or die ("update query error!!");
				$result['r'] = "success";
				$result['idx'] = $row['idx'];
				$result['level'] = $row['level'];
                $result['nickname'] = $row['nickname'];
                $result['my_img'] = $row['my_img_r'];
				$result['policy_agree'] = $row['policy_agree'];
                $result['level'] = $row['level'];
			} else {
				$result['r'] = 'error';
				$result['type'] = 'passwd';
				$result['msg'] = "패스워드가 일치하지 않습니다.";
			}
		} else {
			$result['r'] = 'error';
			$result['type'] = 'email';
			$result['msg'] = "등록되지 않은 이메일 입니다.";
		}

		return $result;
	}

	function confirmPasswd($id, $passwd) {
		$query = "select idx, policy_agree from ".$this->table." where email = '".$id."' and passwd = '".md5($passwd)."'";
		$res = mysql_query($query,$this->conn) or die ("confirmPasswd query error!!");

		if( @mysql_affected_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function changePasswd($array) {
		$result = array();

		if( $this->existEmail($array['email']) !== false ) {
			if( $array['passwd'] == "" )
				$tempPasswd = time() + rand(0, 10000);
			else 
				$tempPasswd = $array['passwd'];

			$query = "update ".$this->table." set passwd = '".md5($tempPasswd)."' where email = '".$array['email']."'";
			$res = mysql_query($query,$this->conn) or die ("update query error!!");

			if( @mysql_affected_rows() > 0 ) {
				$result['r'] = "success";
				$result['passwd'] = $tempPasswd;
				$result['msg'] = "패스워드를 변경 하였습니다.";
			} else {
				$result['r'] = 'error';
				$result['type'] = 'passwd';
				$result['msg'] = "패스워드 변경에 실패 하였습니다.";
			}
		} else {
			$result['r'] = 'error';
			$result['type'] = 'email';
			$result['msg'] = "등록되지 않은 이메일 입니다.";
		}

		return $result;
	}

	function sendMail( $email, $subject, $content) {
		$l_from = EMAIL_FROM_ADDR;
		$l_sitename = EMAIL_FROM_NAME;
		$l_to = $email;
		$l_subject = "=?UTF-8?B?".base64_encode($subject)."?=\r\n";

		$l_headers = "MIME-Version: 1.0\r\n";
		$l_headers .= "From: ".$l_sitename." <".$l_from.">\n";
		$l_headers .= "X-Sender: <".$l_from.">\n";
		$l_headers .= "X-Mailer: PHP\n";
		$l_headers .= "X-Priority: 1\n";
		$l_headers .= "Return-Path: <".$l_from.">\n";
		$l_headers .= "Content-Type: text/html; charset=utf-8\r\n";

		return mail( $l_to, $l_subject, $content, $l_headers );
	}

	function getMemberList($start=0, $len=0, $arrSeach=array()) {
		$where = "where 1 ";
		$arrVal = "";
		for( $arrVal = "",$i=0; $i < count($arrSeach); $i++ ) {
			$arrVal .= " and ".$arrSeach[$i];
		}
		$where .= " ".$arrVal;
			
		if( $start > 0 && $len > 0 ) {
			$query = "select * from ".$this->table." ".$where." limit ".$start.",".$len." order by idx desc";
			$res = mysql_query($query,$this->conn) or die ("member list query error!!");
		} else {
			echo $query = "select * from ".$this->table." ".$where." order by idx desc";
			$res = mysql_query($query,$this->conn) or die ("member list query error!!");
		}

		if( $res ) {
			$result=array();

			if( $row = mysql_fetch_array($res) ) {
				$result[] = $row;
			};
		} else {
			return null;
		}

		return $result;
	}

	function getTotalCount($arrSeach=array()) {
		$where = "where 1 ";
		
		for( $arrVal = "",$i=0; $i < count($arrSeach); $i++ ) {
			$arrVal .= " and ".$arrSeach[$i];
		}
		$where .= " ".$arrVal;
			
		$query = "select * from ".$this->table." ".$where." order by idx desc";
		$res = mysql_query($query,$this->conn) or die ("confirmPasswd query error!!");

		return @mysql_affected_rows();
	}

	function delMember($idx) {
		$query = "delete from ".$this->table." where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("member Delete query error!!");
		return $res;
	}

	function leaveMember($idx) {
        if( empty($idx) ) {
            return false;
        }

		$query = "update ".$this->table." set is_leave = 'y', leave_date = now() where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("leave query error!!");
		
		if( @mysql_affected_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function getData( $idx ) {
        if( $idx == "" ) 
            return NULL;

		$query = "select * from ".$this->table." where idx = ".$idx." and is_leave = 'n' ";
		$res = mysql_query($query,$this->conn) or die ("getMember select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);
			return $row;
		} else {
			return NULL;
		}
	}
}
