<?php
//$url = $_SERVER[ "SCRIPT_NAME" ];
//$break = Explode( '/', $url );
$file = $break[ count( $break ) - 1 ];

if ( !isset( $_SERVER[ 'REQUEST_URI' ] ) ) {
     $url = $_SERVER[ 'REQUEST_URI' ];
} else {
     $url = $_SERVER[ 'SCRIPT_NAME' ];
     $url .= ( !empty( $_SERVER[ 'QUERY_STRING' ] ) ) ? '?' . $_SERVER[ 'QUERY_STRING' ] : '';
}

$filename = $url . '.cache';

$cachefile = $_SERVER[ DOCUMENT_ROOT ] . '/global_resources/cache/cached-' . $filename . '.html';
echo $cachefile;
$cachetime = 18000;

// Serve from the cache if it is younger than $cachetime
if ( file_exists( $cachefile ) && time() - $cachetime < filemtime( $cachefile ) ) {
     echo "<!-- Cached copy, generated " . date( 'H:i', filemtime( $cachefile ) ) . " -->\n";
     include( $cachefile );
     exit;
}
ob_start(); // Start the output buffer
?>