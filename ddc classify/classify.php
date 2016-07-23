<?php
$output = array ();
$url = "http://classify.oclc.org/classify2/Classify?";
$isbn = "";
$author = "";
$title = "";
$issn = "0018-9251";//multiple links
$owi = "2824522255";//multiple ddc
/**
 * for single ddc owi = "54756546"
 * or owi = "372335465"
 * @var unknown
 */
$year = 2012;
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url . "issn=$issn" );
// curl_setopt ( $ch, CURLOPT_URL, $GLOBALS ['url'] . "owi=$owi" );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt ( $ch, CURLOPT_PROXY, "10.3.100.207:8080" );
$curl_scraped_page = curl_exec ( $ch );
curl_close ( $ch );
$xml = simplexml_load_string ( $curl_scraped_page ) or die ( "Error: Cannot create object" );
classify ( $xml );
function classify($xml) {
	if (! (( string ) ($xml->workCount))) {
		generate_ddc ( $xml );
		print_ddc ( $GLOBALS ['output'] );
	} else {
		$works = $xml->works->work;
		foreach ( $works as $work ) {
			if((string)($work->attributes()["hyr"]) == $GLOBALS['year']) //lyr
			call_owi ( ( string ) ($work->attributes () ["owi"]) );
		}
		print_ddc ( $GLOBALS ['output'] );
	}
}
function call_owi($owi) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $GLOBALS ['url'] . "owi=$owi" );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt ( $ch, CURLOPT_PROXY, "10.3.100.207:8080" );
	$curl_scraped_page = curl_exec ( $ch );
	curl_close ( $ch );
	$xml = simplexml_load_string ( $curl_scraped_page ) or die ( "Error: Cannot create object" );
	generate_ddc ( $xml );
}
function generate_ddc($xml) {
	$mostPopular = $xml->recommendations->ddc->mostPopular;
	foreach ( $mostPopular as $ddc ) {
		generate_array ( ( string ) ($ddc->attributes () ["sfa"]) );//nsfa
	}
}
function generate_array($exact_DDC_Code) {
	array_push ( $GLOBALS ['output'], substr ( $exact_DDC_Code, 0, 1 ) . "00" );
	array_push ( $GLOBALS ['output'], substr ( $exact_DDC_Code, 0, 2 ) . "0" );
	array_push ( $GLOBALS ['output'], substr ( $exact_DDC_Code, 0, 3 ) );
}
function print_ddc($output) {
	$ddc_array = array_values ( array_unique ( $output ) );
	sort ( $ddc_array );
	print_r ( $ddc_array );
}
?>

