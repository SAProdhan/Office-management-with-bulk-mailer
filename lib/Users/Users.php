<?php
class Users
{
    /**
     *
     */
    public function CheckSuperuser()
    {
        // Only super admin is allowed to access this page
        if(isset($_SESSION['admin_type'])){
            if ($_SESSION['admin_type'] !== 'super')
                {
                    // Show permission denied message
                    header('HTTP/1.1 401 Unauthorized', true, 401);
                    exit('401 Unauthorized');
                }
        }
        else{
            header('Location:index.php');
            exit();
        }
        
    }
    public function CheckifSuperuser()
    {
        // Only super admin is allowed to access this page
        if ($_SESSION['admin_type'] === 'super')
        {
            return true;
        }
        return false;
    }
    public function CheckAdminuser()
    {
        // Only super admin is allowed to access this page
        if ($_SESSION['admin_type'] !== 'admin')
        {
            // Show permission denied message
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit('401 Unauthorized');
        }
    }
    public function CheckAdmin()
    {
        // Only super admin is allowed to access this page
        if ($_SESSION['admin_type'] === 'super')
        {
            return true;
        }
        else if($_SESSION['admin_type'] === 'admin'){
            // Show permission denied message
            return true;
        }
        else{
            return false;
        }
        return false;
    }
    public function CheckUser()
    {
        // Only super admin is allowed to access this page
        if ($_SESSION['admin_type'] !== 'admin')
        {
            // Show permission denied message
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit('401 Unauthorized');
        }
    }
    /**
     *Get admin id
     */
    public function getId()
    {
        return $_SESSION['user_id'];
    }
    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'user_name' => 'Username',
            'email' => 'Email',
            'admin_type' => 'Admin Type'
        ];

        return $ordering;
    }
    public function getTabledetails(){
        $id = $this->getId();
        $db = getDbInstance();
        $db->where('id', $id);
        $userprivillage = $db->getOne("user_privillage");
        if($userprivillage){
            // $otp_on = $userprivillage['otp_on'];
            // $otp_mail = $userprivillage['otp_mail'];
            $tcl = json_decode($userprivillage['tables_columns'], true);
            return $tcl;
        }
        return false;
    }

    public function getColumns($table){
        $db = getDbInstance();
        $db->where('tables', $table);
        $column = $db->getOne("table_details");
        if($column){
            // $otp_on = $userprivillage['otp_on'];
            // $otp_mail = $userprivillage['otp_mail'];
            $tcl = json_decode($column['columns'], true);
            return $tcl;
        }
        return false;
    }
    public function getEmails(){
        $id = $this->getId();
        $db = getDbInstance();
        $db->where('id', $id);
        $userprivillage = $db->getOne("user_privillage");
        if($userprivillage){
            $result = json_decode($userprivillage['email_id'], true);
            return $result;
        }
        return false;
    }
}
?>
