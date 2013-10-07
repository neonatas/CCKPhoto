<?

exit;
// Require the phpFlickr API
    require_once('../../_lib/config.php');
    require_once('../../_lib/phpFlickr.php');

// Create new phpFlickr object: new phpFlickr('[API Key]','[API Secret]')
$flickr = new phpFlickr(FLICKR_API_KEY,FLICKR_API_SECRET, true);

// Authenticate;  need the "IF" statement or an infinite redirect will occur
if(empty($_GET['frob'])) {
    $flickr->auth('delete'); // redirects if none; write access to upload a photo
}
else {
	// Get the FROB token, refresh the page;  without a refresh, there will be "Invalid FROB" error
	$flickr->auth_getToken($_GET['frob']);
}


$flickr->photos_delete('10134232113');
?>