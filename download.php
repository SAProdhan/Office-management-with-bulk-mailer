<?php
session_start();
require_once 'config/config.php';
$db = getDbInstance();
if(isset($_REQUEST["proposal_id"])){
    $proposal_id = urldecode($_REQUEST["proposal_id"]);
    $db->where ("id", $proposal_id);
    $proposal=$db->getOne("proposals");
    // Get parameters
    $file = $proposal['path']; // Decode URL-encoded string

    /* Test whether the file name contains illegal characters
    such as "../" using the regular expression */
    // if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
        $filepath = $file;

        // Process download
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            die();
        } else {
            http_response_code(404);
	        die();
        }
    // } 
    // else {
    //     die("Invalid file name!");
    // }
}
if(isset($_REQUEST["account_id"])){
    $account_id = urldecode($_REQUEST["account_id"]);
    $db->where ("id", $account_id);
    $account=$db->getOne("accounts");
    // Get parameters
    $file = $account['file']; // Decode URL-encoded string

    /* Test whether the file name contains illegal characters
    such as "../" using the regular expression */
    // if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i', $file)){
        $filepath = $file;

        // Process download
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            die();
        } else {
            http_response_code(404);
	        die();
        }
    // } 
    // else {
    //     die("Invalid file name!");
    // }
}
?>