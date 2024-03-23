<?php 
    //Include Constans page
    include('../config/constants.php');

    // echo "Delete Food Page";

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to Delete
        // echo "Process to Delete";

        //1. Get ID and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        
        //2. Remove the image if Available 
        if($image_name != "")
        {
            //Image is Available. So remove it
            $path = "../images/food/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //If fail to remove image then add error messge and stop the process
            if($remove==false)
            {
                //Set the session message
                $_SESSION['remove'] = "<div class='error>Failed to Remove Image file.</div>";
                //Redirect to Mnage Category page
                header('location;'.SITEURL.'admin/manage-food.php');
                //Stop the Process
                die();
            }
    }
        
        //Delet Data from DB
        //SQL Query to Delete data from DB
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is delete from db or not
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            //Recirect to Manage food
            header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
            //Recirect to Manage food
            header('location:'.SITEURL.'admin/manage-food.php');
    }
}
    else
    {
        //Set the session message
        $_SESSION['unauthorize'] = "<div class='error>Unauthorized Access.</div>";
        header('location;'.SITEURL.'admin/manage-food.php');
    }

?>