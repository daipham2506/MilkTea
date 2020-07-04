<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-4">
    <div class="col-xl-2 col-md-3 col-12">
        <div class="list-group" id="menu-nar">
            <a href="#" class="list-group-item list-group-item-action disabled" style="font-weight: 600;color: black;background-color: white">LOẠI TRÀ SỮA</a>
            <?php
            while ($row = $data["category"]->fetch_assoc()) {
                $category_name = $row["name"];
                $category_id = $row["id"];
                $link = URLROOT . "products/category/$category_id";
                $classes = "list-group-item list-group-item-action";
                if($category_id == $data["categoryWithId"]["id"]){
                    $classes .= " menu-list-active";
                }
                echo "<a href='$link' class='$classes'>$category_name</a>";
            }
            ?>
            <!-- <a href="#latte-series" class="list-group-item list-group-item-action">LATTE SERIES</a>
            <a href="#special" class="list-group-item list-group-item-action">THỨC UỐNG ĐẶC BIỆT</a>
            <a href="#milk-tea" class="list-group-item list-group-item-action">TRÀ SỮA</a>
            <a href="#origin" class="list-group-item list-group-item-action">TRÀ NGUYÊN CHẤT</a>
            <a href="#creation" class="list-group-item list-group-item-action">THỨC UỐNG SÁNG TẠO</a>
            <a href="#ice" class="list-group-item list-group-item-action">THỨC UỐNG ĐÁ XAY</a>
            <a href="#topping" class="list-group-item list-group-item-action">TOPPING</a> -->
        </div>
    </div>
    <div class="col-xl-10 col-md-9 col-12" id="menu">
        <div class="row product-container" id="<?php echo "category" . $data["categoryWithId"]["id"] ?>">
            <div class="col-12" data-aos="fade-up" data-aos-duration="1500">
                <h2 class="title ml-md-0 ml-2"><?php echo $data["categoryWithId"]["name"] ?></h2>
            </div>
            <?php
            // var_dump($data["product"]);
            $product = $data["product"];
            for($i = 0; $i < count($product); $i++){
                $product_id = $product[$i]["id_product"];
                $product_name = $product[$i]["name_product"];
                $product_image = $product[$i]["image"];
                $product_price = $product[$i]["price_list"];
                $price_display = "";
                $link_product = URLROOT . "products/detail/$product_id";
                while($price_row = $product_price->fetch_assoc()){
                    $price = $price_row["price"];
                    $size_name = $price_row["size"];
                    $price_display .= "<li class='price'>Size $size_name : $price</li>";
                }
                echo "
                <div class='col-lg-4 col-md-6 col-12 product-item ml-md-0 ml-2'>
                    <div class='card' data-aos='fade-down' data-aos-duration='1500'>
                        <a href='$link_product' class='btn btn-dark detail-button'><i class='fas fa-angle-double-right'></i></a>
                        <a href='$link_product' class='btn btn-success add-cart'><i class='fas fa-cart-plus'></i></a>
                        <a  class='d-flex justify-content-center' href='$link_product'><img src='$product_image' class='card-img-top img-product' alt='$product_name'></a>
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
            ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>