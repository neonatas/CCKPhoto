<?
    require_once('../../_lib/config.php');
    require_once("../../_lib/phpFlickr.php");
    $flickr = new phpFlickr(FLICKR_API_KEY);

    //$recent = $f->photos_getRecent(null,null,15,1);

    $result = $flickr->photos_search(array('user_id'=>FLICKR_USER_ID));
    $photos = $result['photo'];
    echo "<pre>";
    print_r($photos);
    foreach ($photos as $photo) {
        $owner = $f->people_getInfo($photo['owner']);
        echo "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>";
        echo $photo['title'];
        echo "</a> Owner: ";
        echo "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>";
        echo $owner['username'];
        echo "</a><br>";
    }


?>
<img src="http://www.flickr.com/photos/100477638@N03/10134226396" />