<?php
require_once 'init.php';
JotihuntUtils::requireLogin();

define('opoiLoaded',true);
require_once BASE_DIR . 'includes/make_map_js.include.php';
require_once CLASS_DIR . 'jotihunt/MapOptions.class.php';

if (isset($_GET ['team']) && ! empty($_GET ['team'])) {
    $team = $_GET ['team'];
}
$headerOptions = array();
$headerOptions['title'] = 'Fullscreen Kaart';
$headerOptions['includeBody'] = false;
require_once BASE_DIR . 'header.php';
?>

<script type="text/javascript">
var markersArray = [];
var infowindow;	
var vossen = 0;
function clearOverlays() {
  for (var i = 0; i < markersArray.length; i++ ) {
	markersArray[i].setMap(null);
  }
}

function fetchVossen(){
	//Set a timeout for 15 seconds
	setTimeout("fetchVossen()",15000);
		
	updateVossen('<?= $team ?>');
	updateHunters();	
}
$(document).ready(function(){
	setTimeout("fetchVossen()",5000);
});
</script>
    <div id="map" style="float: left; width: 100%; height: 100%;"></div>
<?php
$mapOptions = new MapOptions();
$mapOptions->special = false;
$mapOptions->zoom = 11;
$mapOptions->team = $team;
if (!empty($_GET['marker_x']) && !empty($_GET['marker_y'])) {
	$mapOptions->marker_x = $_GET['marker_x'] ?: null;
	$mapOptions->marker_y = $_GET['marker_y'] ?: null;
	if(strlen($mapOptions->marker_x) == 5) $mapOptions->marker_x .= "0";
	if(strlen($mapOptions->marker_y) == 5) $mapOptions->marker_y .= "0";
	$mapOptions->crosshair = true;
	$mapOptions->centerOnCrosshair = true;
}
make_map($mapOptions);

$footerOptions = array();
$footerOptions['includeHtml'] = false;
require_once BASE_DIR . 'footer.php';

?>