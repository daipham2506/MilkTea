<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('addtocart'); ?>
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
                    $star = printStar(rand(3,5));
                    $numOfReview = rand(20,50);
                    $numOfSale = rand(100,300);
                    while($price_row = $product_price->fetch_assoc()){
                        $id_size[$j] = $price_row["id"];
                        $j++;
                        $price = $price_row["price"];
                        $size_name = $price_row["size"];
                        $quantity = $price_row["quantity"];
                        // $price_display .=                         
                        // "
                        // <ul class='size'>Size $size_name : 
                        //     <li class='price'>Giá: $price đ</li>
                        //     <li class='price'>Số lượng: $quantity </li>
                        // </ul>
                        // ";
                        $price_display = 'đ '. $price;
                        $button_add_card  = "";
                        if (isset($_SESSION['user_id'])){
                            $button_add_card = "<a href='".URLROOT."products/addOneToCart/".$product_id."?size=".$id_size[0]."' class=''><img class='' src='".URLROOT."/img/product/add_to_cart.png' alt='new-item'/></a>";
                        }
                        // <a href='$link_product' class='btn btn-dark detail-button'><i class='fas fa-angle-double-right'></i></a>
                    }
                    $product_display .= "
                    <div class='col-xl-4 col-lg-6 col-md-6 col-12 product-item ml-md-0 ml-2'>
                        <div class='card' data-aos='fade-down' data-aos-duration='1500'>
                            <div class='d-flex justify-content-between'>
                                <img class='' src='".URLROOT."/img/product/new.png' alt='new-item'/>
                                <img class='' src='".URLROOT."/img/product/gift.png' alt='new-item'/>
                            </div>
                            <a  class='d-flex justify-content-center' href='$link_product'><img src='$product_image' class='card-img-top img-product' alt='$product_name'></a>
                            <div class='card-body product-body'>
                                <div class='wrap-add-cart'>
                                    <h5 class='card-title title-product'>$product_name</h5>
                                    ".$button_add_card.
                                    "
                                </div>
                                <div class='price-product'>"
                                .$price_display.
                                "</div>
                            </div>
                            <div class='row'>
                                <div class='star-review'>$star <span class='num-of-review'>($numOfReview)</span></div>
                                <div class='sold-product-num'>Đã bán $numOfSale</div>
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