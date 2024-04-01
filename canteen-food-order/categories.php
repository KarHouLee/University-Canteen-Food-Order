
<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories" style="background-image: url('images/foodexplore.jpg');">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            
                //Display all the category that are active
                //Sql Quey 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check Whether category aavailable or not
                if($count>0)
                {
                    //Category Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                         <div class="box-3 float-container">
                                <?php
                                    if($image_name=="")
                                    {
                                        //Image not available
                                        echo "<div class='error'>Image not Found.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Chinese Cuisine" class="img-responsive img-curve">
                                        <?php

                                    }
                                ?>
                                

                             <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                       </a>


                        <?php
                    }
                }
                else
                {
                    //Categpry not Availablr
                    echo "<div class='error'>Category not found.</div>";
                }

            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>