<?
require_once("config.php");

class clsMembers {
	var $conn;

	function __construct( $conn ) {
		$this->conn = $conn;
	}

	function getOauthMemberIdx($type,$id,$nickname="") {
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

		$query = "select idx, policy_agree from members where ".$field." = '".$id."'";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) { 
			$row = mysql_fetch_array( $res );
			$query = "update members set logindate = now() where idx = ".$row['idx'];
			mysql_query($query,$this->conn) or die ("update query error!!");

			$result['r'] = 'success';
			$result['msg'] = "이미 가입된 회원 입니다.";
			$result['idx'] = $row['idx'];
			$result['policy_agree'] = $row['policy_agree'];
		} else {
			$query = "insert into members ( ".$field.", nickname, joindate, logindate, policy_agree ) values ( '".$id."','".$nickname."', now(), now(), 'y' )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");

			if( $res ) {
				$result['r'] = 'success';
				$result['msg'] = "회원 가입이 완료되었습니다.";
				$result['idx'] = mysql_insert_id();
				$result['policy_agree'] = 'y';
			}
		}

		return $result;
	}

	function existEmail($email) {
		$query = "select idx from members where email = '".$email."'";
		$res = mysql_query($query,$this->conn) or die ("select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			return $res['idx'];
		} else {
			return false;
		}
	}

	function existNickName($nickname) {
		$query = "select idx from members where nickname = '".$nickname."'";
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
			$query = "insert into members ( email, nickname, passwd, policy_agree, joindate, logindate ) values ( '".$array['email']."','".$array['nickname']."', '".md5($array['passwd'])."', '".$array['policy_agree']."', now(), now() )";
			$res = mysql_query($query,$this->conn) or die ("insert query error!!");;

			$result['r'] = 'success';
			$result['msg'] = "회원 가입이 완료되었습니다.";
			$result['idx'] = mysql_insert_id();
			$result['policy_agree'] = $array['policy_agree'];
		}

		return $result;
	}

	function saveAutoKey( $m_idx, $key ) {
		$result = array();

		$query = "update members set auto_key = '".$key."' where idx = ".$m_idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( $res ) {
			return true;
		} else {
			return false;
		}
	}

	function getDataFromAutoKey($key) {
		$query = "select * from members where auto_key = ".$key;
		$res = mysql_query($query,$this->conn) or die ("getMember select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);
			return $row;
		} else {
			return NULL;
		}
	}


	function updatePolicyAgree($idx, $agree) {
		$query = "update members set policy_agree = '".$agree."' where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("update query error!!");
		
		if( $res ) {
			return $agree;
		} else {
			return false;
		}
	}

	function loginMember($array) {

		$result = array();

		if( $this->existEmail($array['email']) !== false ) {
			$query = "select idx, level, policy_agree from members where email = '".$array['email']."' and passwd = '".md5($array['passwd'])."'";
			$res = mysql_query($query,$this->conn) or die ("select query error!!");

			if( @mysql_affected_rows() > 0 ) {
				$row = mysql_fetch_array($res);
				$query = "update members set logindate = now() where idx = ".$row['idx'];
				mysql_query($query,$this->conn) or die ("update query error!!");
				$result['r'] = "success";
				$result['idx'] = $row['idx'];
				$result['level'] = $row['level'];
				$result['policy_agree'] = $row['policy_agree'];
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
		$query = "select idx, policy_agree from members where email = '".$id."' and passwd = '".md5($passwd)."'";
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

			$query = "update members set passwd = '".md5($tempPasswd)."' where email = '".$array['email']."'";
			$res = mysql_query($query,$this->conn) or die ("update query error!!");

			if( $res ) {
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
			$query = "select * from members ".$where." limit ".$start.",".$len." order by idx desc";
			$res = mysql_query($query,$this->conn) or die ("member list query error!!");
		} else {
			echo $query = "select * from members ".$where." order by idx desc";
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
			
		$query = "select * from members ".$where." order by idx desc";
		$res = mysql_query($query,$this->conn) or die ("confirmPasswd query error!!");

		return @mysql_affected_rows();
	}

	function delMember($idx) {
		$query = "delete from members where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("member Delete query error!!");
		return $res;
	}

	function getData( $idx ) {
		$query = "select * from members where idx = ".$idx;
		$res = mysql_query($query,$this->conn) or die ("getMember select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);
			return $row;
		} else {
			return NULL;
		}
	}
}
