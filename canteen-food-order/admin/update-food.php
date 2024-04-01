<?php  include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        
        <br><br>

<?php
    //Check whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL Query to get selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Det the individual value of selected food
        //Get all the data
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    
    }
    else
    {
        //Redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"<?php echo $description; ?>></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                        if($current_image == "")
                        {
                            //Image not Available 
                           echo "<div class='error'>Image not Available.</div>"; 
                           
                        }
                        else
                        {
                           //Image Available
                           ?>
                           <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                           <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image: </td>
                <td>
                     <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                        <?php
                            //Query to get active category
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Execute theQuery
                            $res = mysqli_query($conn, $sql);
                            //Count Rows
                            $count = mysqli_num_rows($res);

                            //Check whether ctegory availablr or not
                            if($count>0)
                            {
                                //Category Available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_title'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //Category unavailable
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                        ?>
                        <option value="0">Test Category</option>
                    </select>
                </td>
            </tr>
        
            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary"> 
                </td>
            </tr>
        
        </table>
        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                 //1. Get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Upload the image if selected
                //Check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Upload Button Clicked
                    $image_name = $_FILES['image']['name'];//New Image Name

                     //Check whether the image is available or not
                     if($image_name!= "")
                     {
                         //Image Available
                        //A. Upload the new Image

                         //Auto rename our image
                        //Get the extension of our image 
                        $ext = end(explode('.', $image_name));

                        //Rename the image 
                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;//This will be renamed image

                        //Get he source path and destination path
                        $src_path = $_FILES['image']['tmp_name'];//source path
                        $dest_path = "../images/food/".$image_name;//destination path

                        //Upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload new Image. </div>";
                            //Redirect to Add food Page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                          //3. Remove the image if new umage is uploaded and current image exists  
                          //B. Remove the current image if available
                          if($current_image!="")
                          { 
                              $remove_path = "../images/food/".$current_image;
  
                              $remove = unlink($remove_path);
  
                              //Check whether the image is removed or not
                              //If failed to removed then display message and stop the process
                              if($remove==false)
                              {
                                  //Failed to remove image
                                  $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                  header('location:'.SITEURL.'admin/manage-food.php');
                                  die();//Stop the Process 
                          }
                      }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }


            //4. uPDATE THE FOOD IN DB
            $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            "; 


            //Execute the SQL Query
            $res3 = mysqli_query($conn, $sql3);

            //Check whether executed or not
            if($res3==true)
            {
                //Food Updated
                $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //failed to update cfood
                $_SESSION['update'] = "<div class='error'>Failed Update Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

         }
        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>