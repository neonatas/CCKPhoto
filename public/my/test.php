<?
// Start the session since phpFlickr uses it but does not start it itself
session_start();

unset($_SESSION['phpFlickr_auth_token']);
unset($_SESSION['phpFlickr_auth_redirect']);

// Require the phpFlickr API
require_once('../../_lib/phpFlickr.php');

// Create new phpFlickr object: new phpFlickr('[API Key]','[API Secret]')
$flickr = new phpFlickr('14e017da937660375b6cbc225f66d337','97ff9a001b89482f', true);

// Authenticate;  need the "IF" statement or an infinite redirect will occur
if(empty($_GET['frob'])) {
	$res = $flickr->auth('write'); // redirects if none; write access to upload a photo
    exit();
}
else {
	// Get the FROB token, refresh the page;  without a refresh, there will be "Invalid FROB" error
	$flickr->auth_getToken($_GET['frob']);
	header('Location: upload.php');
	exit();
}
?>
