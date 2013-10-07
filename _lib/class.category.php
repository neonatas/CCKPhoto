<?
class clsCategory {
	var $conn;
    var $table = "category";

	function __construct( $conn ) {
		$this->conn = $conn;
	}

	function getName($id) {
		$result = array();

		$query = "select name from ".$this->table." where id = ".$id;
		$res = mysql_query($query,$this->conn) or die ("getData select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			$row = mysql_fetch_array($res);
			return $row['name'];
		} else {
			return "";
		}
	}

	function getList()
	{
		$result = array();

		$query = "select * ";
		$query .= " from ".$this->table." order by sort asc";
		$res = mysql_query($query,$this->conn) or die ("getList select query error!!");

		if( @mysql_affected_rows() > 0 ) {
			while( $row = mysql_fetch_array($res) ) {
				$result[] = $row;
			}
		}
		return $result;
	}
}
?>