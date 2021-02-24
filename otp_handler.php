<?php
require_once 'config/config.php';
require "mailer/Mailer.php"; 
date_default_timezone_set("Asia/Dhaka");

function getVerificationCode()
{
    return (int) substr(number_format(time() * rand(), 0, '', ''), 0, 6);
}

function getHTMLMessage($otp){  
    $htmlMessage=<<<MSG
    <!DOCTYPE html>
    <html>
     <body>
        <h1>Your verification code is {$otp}</h1>
        <p>Use this code to verify your account.</p>
     </body>
    </html>        
MSG;
return $htmlMessage;
}


function checkOTP($id){
    $db = getDbInstance();
    $db->where('id', $id);
    $db->where('otp_on', 1);
    $db->get('user_privillage');
    if($db->count >= 1){
        return true;
    }
    return false;
}

function sentOTP($id, $reciver){
    $vc=new Mailer('sales@paxzonebd.com', 'pazoneelectronics','sg2plcpnl0221.prod.sin2.secureserver.net', 465);
    $db = getDbInstance();
    $db->where('id', $id);
    $user_privillage = $db->getOne('user_privillage u');
    $otp = getVerificationCode();
    $msg = getHTMLMessage($otp);
    if(strlen($user_privillage['otp_mail']) > 5){
        $reciver = $user_privillage['otp_mail'];
    }
    if(filter_var($reciver, FILTER_VALIDATE_EMAIL)){
        if($vc->sendMail($reciver, $msg, $sub)){
            $data = Array(
                'otp'     => $otp,
                'user_id' => $id,
            );
            $status = $db->insert('otp_expiry', $data);
            if($status){
                return true;
            }else{
                $_SESSION['login_failure'] = 'Error! '.$db->getLastError();
                header('Location: login.php');
            }
        }else{
            $_SESSION['login_failure'] = 'Error! Failed to send OTP!';
            header('Location: login.php');
        }
    }else{
        $_SESSION['login_failure'] = 'Error! Invalid email!';
        header('Location: login.php');
    }
    return false;
}
function verifyOTP($id, $otp){
    $db = getDbInstance();
    $db->where('user_id ', $id);
    $db->where('otp', $otp);
    $db->where('is_expired', 0);
    $db->getOne('user_privillage');
    if($db->count >= 1){
        $db = getDbInstance();
        $db->where('user_id ', $id);
        if($db->delete('user_privillage')){
            return true;
        }
    }
    return false;
}


?>