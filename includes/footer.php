        <div id="alert_popover">
            <div class="wrapper">
                <div class="content">
                </div>
            </div>
        </div>
</div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <!-- Bootstrap Core JavaScript -->
    <style>
        #alert_popover {
            display: block;
            position: absolute;
            bottom: 50px;
            left: 50px;
        }

        .wrapper {
            display: table-cell;
            vertical-align: bottom;
            height: auto;
            width: 200px;
        }

        .alert_default {
            color: #333333;
            background-color: #f2f2f2;
            border-color: #cccccc;
        }
    </style>
<script>    
    var interval = 5000;
    $(document).ready(function () {
        $(document).on('click', '#closeR', function(){  
            interval = 1800000;
        });
        setInterval(function () {
            load_last_notification();
        }, interval);

        function load_last_notification() {
            var user_name = "<?php echo (isset($admin_data['user_name'])? $admin_data['user_name'] : 'User Profile');?>";
            $.ajax({
                url: "fetch.php",
                method: "POST",
                data:{user_name:user_name}, 
                success: function (data) {
                    $('.content').html(data);
                }
            })
        } 
        $(document).on('click', '#deleteReminder', function(){  
            var id = $(this).data("id1"); 
            $.ajax({
                url: "delete_reminder.php",
                method: "POST",
                data:{id:id}, 
                success: function (data) {
                    interval = 0;
                }
            })
        }); 
});

</script>
</body>

</html>