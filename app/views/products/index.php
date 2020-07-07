<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-4">
    <div class="col-xl-2 col-md-3 col-12">
        <div class="list-group" id="menu-nar">
            <a href="#" class="list-group-item list-group-item-action disabled" style="font-weight: 600;color: black;background-color: white">LOẠI TRÀ SỮA</a>
            <a href="<?php echo URLROOT;?>products" class="list-group-item list-group-item-action menu-list-active">TẤT CẢ</a>
            <?php
            while ($row = $data["category"]->fetch_assoc()) {
                $category_name = $row["name"];
                $category_id = $row["id"];
                $link = URLROOT . "products/category/$category_id";
                $classes = "list-group-item list-group-item-action";
                // if($category_id == $data["categoryWithId"]["id"]){
                //     $classes .= " menu-list-active";
                // }
                echo "<a href='$link' class='$classes'>$category_name</a>";
            }
            ?>
        </div>
    </div>
    <div class="col-xl-10 col-md-9 col-12" id="menu">
            <?php 
            $category = $data["productWithCategory"];
            for($i = 0; $i < count($category); $i++){
                $idcategory = $category[$i][0]["idcategory"];
                $category_name =  $category[$i][0]["name_category"];
                $product = $category[$i]; // product list with category
                $product_display = "";
                for($k = 0; $k < count($product); $k++){
                    $product_id = $product[$k]["id_product"];
                    $product_name = $product[$k]["name_product"];
                    $product_image = $product[$k]["image"];
                    $product_price = $product[$k]["price_list"];
                    $price_display = "";
                    $id_size = array();
                    // echo  $product_name . "<br>";
                    $j = 0;
                    $link_product = URLROOT . "products/detail/$product_id";
                    while($price_row = $product_price->fetch_assoc()){
                        $id_size[$j] = $price_row["id"];
                        $j++;
                        $price = $price_row["price"];
                        $size_name = $price_row["size"];
                        $price_display .= "<li class='price'>Size $size_name : $price</li>";
                        $button_add_card  = "";
                        if (isset($_SESSION['user_id'])){
                            $button_add_card = "<a href='".URLROOT."products/addOneToCart/".$product_id."?size=".$id_size[0]."' class='btn btn-success add-cart'><i class='fas fa-cart-plus'></i></a>";
                        }
                    }
                    $product_display .= "
                    <div class='col-lg-4 col-md-6 col-12 product-item ml-md-0 ml-2'>
                        <div class='card' data-aos='fade-down' data-aos-duration='1500'>
                            <a href='$link_product' class='btn btn-dark detail-button'><i class='fas fa-angle-double-right'></i></a>"
                            .$button_add_card.
                            "<a  class='d-flex justify-content-center' href='$link_product'><img src='$product_image' class='card-img-top img-product' alt='$product_name'></a>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_name</h5>
                                <ul class='cart-text'>
                                "
                                .$price_display.
                                "
                                </ul>
                            </div>
                        </div>
                    </div>
                    ";
                    }


                echo
                "
                <div class='row product-container' id='category".$idcategory."'>
                    <div class='col-12' data-aos='fade-up' data-aos-duration='1500'>
                        <h2 class='title ml-md-0 ml-2'>$category_name</h2>
                    </div>
                    ".$product_display."
                </div>
                ";
            }
            ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>