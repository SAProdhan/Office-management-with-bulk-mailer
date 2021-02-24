<?php
require_once 'config/config.php';
require "signature_creator.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_name = $_POST["un"];
    $db = getDbInstance();
    $db->where ("user_name", $user_name);
    $admin_accounts=$db->getOne("admin_accounts");
    echo (CreateSignature($admin_accounts['id']));
}
?>