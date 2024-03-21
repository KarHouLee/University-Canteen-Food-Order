<?php
    //Include constants file
    include('../config/constants.php');

    // echo "Delete Page";
    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Get the Value and Delete
        // echo "Get value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available
        if($image_name != "")
        {
            //Image is Available. So remove it
            $path = "../images/category/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If fail to remove image then add error messge and stop the process
            if($remove==false)
            {
                //Set the session message
                $_SESSION['remove'] = "<div class='error>Failed to Remove Category Image.</div>";
                //Redirect to Mnage Category page
                header('location;'.SITEURL.'admin/manage-category.php');
                //Stop the Process
                die();
            }
        }

        //Delet Data from DB
        //SQL Query to Delete data from DB
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is delete from db or not
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //Recirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Failed to Delete Category.</div>";
            //Recirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }



    }
    else
    {
        //Redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    
    }
?>