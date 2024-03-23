<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id =$_GET['id'];
            }
        ?>  

        <form action="" method="POST">

            <table class="tbl-30">

                <tr>
                    <td>Current Password: </td>
                    <td>
                         <input type="password" name="current_password" placeholder="Old Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                         <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                         <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>


            </table>


        </form>


    </div>
</div>

<?php 

    //Check whether the submit button is Clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";

        //1. Get all the values from form to update
         $id = $_POST['id'];
         $current_password = md5($_POST['current_password']);
         $new_password = md5($_POST['new_password']);
         $confirm_password = md5($_POST['confirm_password']);

        //2. Check whether the user with current ID and current password Exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
      
        // //Execite the Query
        $res = mysqli_query($conn, $sql);

         if($res==true)
         {
            //Check whether data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //User exists and password can be change
                //echo "user found";

                //Check whether the new pass and confirm match or not
                if($new_password==$confirm_password)
                {
                    //Update the Password
                    $sql2 = "UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                    ";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);
                    
                    //Check whether the query executed or not
                    if($res2==true)
                    {
                    //Display Success message
                    //redirect to manage Admin Page With success Message
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                    //Redirect to User
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                    //Display Error message
                    //redirect to manage Admin Page With error Message
                    $_SESSION['change-pwd'] = "<div class='error'>failed to change password.</div>";
                    //Redirect to User
                    header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //Query executed and Admin Updated
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password not match.</div>";
                    //Redirect to User
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        }
         else
         {
             //Failed to Update Admin
             $_SESSION['user-not-found'] = "<div class='error'>User not found.</div>";
             //Redirect to User
            header('location:'.SITEURL.'admin/manage-admin.php');
         }
    }


?>   

<?php include('partials/footer.php'); ?>