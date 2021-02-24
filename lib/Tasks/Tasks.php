<?php
class Tasks
{
    /**
     *
     */
    // public function CheckSuperuser()
    // {
    //     // Only super admin is allowed to access this page
    //     if ($_SESSION['admin_type'] !== 'super')
    //     {
    //         // Show permission denied message
    //         header('HTTP/1.1 401 Unauthorized', true, 401);
    //         exit('401 Unauthorized');
    //     }
    // }
    // public function CheckAdminuser()
    // {
    //     // Only super admin is allowed to access this page
    //     if ($_SESSION['admin_type'] !== 'admin')
    //     {
    //         // Show permission denied message
    //         header('HTTP/1.1 401 Unauthorized', true, 401);
    //         exit('401 Unauthorized');
    //     }
    // }
    // public function CheckAdmin()
    // {
    //     // Only super admin is allowed to access this page
    //     if ($_SESSION['admin_type'] !== 'super')
    //     {
    //         if($_SESSION['admin_type'] !== 'admin'){
    //             // Show permission denied message
    //             header('HTTP/1.1 401 Unauthorized', true, 401);
    //             exit('401 Unauthorized');
    //         }
            
    //     }
    // }
    // public function CheckUser()
    // {
    //     // Only super admin is allowed to access this page
    //     if ($_SESSION['admin_type'] !== 'admin')
    //     {
    //         // Show permission denied message
    //         header('HTTP/1.1 401 Unauthorized', true, 401);
    //         exit('401 Unauthorized');
    //     }
    // }


    // /**
    //  *Get admin id
    //  */
    // public function getId()
    // {
    //     return $_SESSION['user_id'];
    // }
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
            'username ' => 'Username',
            'tables' => 'Tables',
            'assign_at' => 'Assigning Time'
        ];

        return $ordering;
    }
    public function setFilteringValues()
    {
        $ordering = [
            // 'username ' => 'Username',
            // 'tables' => 'Tables',
            'assign_at' => 'Assigning Time',
            // 'assign_by' => 'Assign By',
            'completed_at' => 'Completion Time',
            // 'status' => 'Status'
        ];

        return $ordering;
    }
}
?>
