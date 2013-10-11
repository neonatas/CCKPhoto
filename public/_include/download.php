<?
    @header("Content-type: text/html; charset=utf-8");

    require_once('../../_lib/config.php');

    $filename_r = ( trim($_GET['filename_r']) ) ? trim($_GET['filename_r']) : "";
    $filename_o = ( trim($_GET['filename_o']) ) ? trim($_GET['filename_o']) : "";

    $file = PATH_PHOTOS_UPLOAD.$filename_r; //실제 파일명 또는 경로 
    $dnfile = urlencode($filename_o); //다운받을 파일명

    if(!file_exists($file)) {
        echo "해당 파일이나 경로가 존재하지 않습니다."; 
        exit;
    } else {

        if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
        { 
            if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) 
            { 
                header("Content-Type: doesn/matter"); 
                header("Content-disposition: filename=$dnfile"); 
                header("Content-Transfer-Encoding: binary"); 
                header("Pragma: no-cache"); 
                header("Expires: 0"); 
            } 

            if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) 
            { 
                Header("Content-type: file/unknown"); 
                header("Content-Disposition: attachment; filename=$dnfile"); 
                Header("Content-Description: PHP3 Generated Data"); 
                header("Pragma: no-cache"); 
                header("Expires: 0"); 
            } 

            if(strstr($HTTP_USER_AGENT, "MSIE 5.1")) 
            { 
                Header("Content-type: file/unknown"); 
                header("Content-Disposition: attachment; filename=$dnfile"); 
                Header("Content-Description: PHP3 Generated Data"); 
                header("Pragma: no-cache"); 
                header("Expires: 0"); 
            } 

            if(strstr($HTTP_USER_AGENT, "MSIE 6.0"))
            {
                Header("Content-type: application/x-msdownload"); 
                Header("Content-Length: ".(string)(filesize("$file")));
                Header("Content-Disposition: attachment; filename=$dnfile");   
                Header("Content-Transfer-Encoding: binary");   
                Header("Pragma: no-cache");   
                Header("Expires: 0");   
            }
        } else { 
            Header("Content-type: file/unknown");     
            Header("Content-Length: ".(string)(filesize("$file"))); 
            Header("Content-Disposition: attachment; filename=$dnfile"); 
            Header("Content-Description: PHP3 Generated Data"); 
            Header("Pragma: no-cache"); 
            Header("Expires: 0"); 
        } 

        if (is_file("$file")) { 
            $fp = fopen("$file", "rb"); 
            if (!fpassthru($fp))  
                fclose($fp); 
        } else { 
          echo "해당 파일이나 경로가 존재하지 않습니다."; 
        }
    }
?>
