<?php
require_once 'config/config.php';

function path2url($file_path) 
{
    $file_path=str_replace('\\','/',$file_path);
    $file_path=str_replace(' ', '%20',$file_path);
    $file_path=str_replace($_SERVER['DOCUMENT_ROOT'],'',$file_path);
    $file_path='http://'.$_SERVER['HTTP_HOST'].'/'.$file_path;
    return $file_path;
    // return $Protocol.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($file));
}

function CreateSignature($id){
    $db = getDbInstance();
    $db->where ("id", $id);
    $user_details=$db->getOne("user_details");
    $path = path2url($user_details["path"]);
    $temp = '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; text-size-adjust: 100%; background-color: rgb(255, 255, 255); border-top: 0px; border-bottom: 0px; color: rgb(0, 0, 0); font-family: arial, sans-serif; font-size: small; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-style: initial; text-decoration-color: initial;" width="600"><tbody><tr><td style="text-size-adjust: 100%;" width="157"><img class="CToWUd" src="'.$path.'" alt="" width="136" height="147" style="border: 0px; height: auto; outline: none; text-decoration: none;"></td><td style="text-size-adjust: 100%;"><table style="border-collapse: collapse; text-size-adjust: 100%; height: 219px;" width="425"><tbody><tr style="height: 185px;"><td style="text-size-adjust: 100%; height: 185px; width: 423px;"><p style="margin: 10px 0px; padding: 0px; text-size-adjust: 100%;"><br><strong>Best Regards,<br></strong><strong>'.$user_details["name"].' <br></strong>'.$user_details["designation"].'<br><strong>Paxzone Electronics<br>P: +88029112698 M: '.$user_details["cell_no"].'<br>A:&nbsp;3rd Floor, 1/1, Shukrabad, Dhanmondi 32, Dhaka1207<br><a data-saferedirecturl="https://www.google.com/url?q=https://www.paxzonebd.com/&source=gmail&ust=1602999108788000&usg=AFQjCNGNucBlt5Me6CDYL-qukm0OpJfDzg" href="https://www.paxzonebd.com/" rel="noopener" style="text-size-adjust: 100%;" target="_blank">W:&nbsp;www.paxzonebd.com</a>&nbsp; &nbsp; &nbsp;<a href="mailto:sales@paxzonebd.com" rel="noopener" style="text-size-adjust: 100%;" target="_blank">E:&nbsp;sales@paxzonebd.com</a></strong></p></td></tr></tbody></table></td></tr></tbody></table>';
    return $temp;
    }
?>