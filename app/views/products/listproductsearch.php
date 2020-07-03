<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
    // var_dump( $data["listProductSearch"]);
?>
<div class="container mt-3">
    <div class="row">
        <?php
        // var_dump($data["product"]);
        $product = $data["listProductSearch"];
        if(count($product) < 1){
            echo '<h1 class="text-danger w-100 text-center">No product here</h1>';
        }
        else{
            for($i = 0; $i < count($product); $i++){
                $product_id = $product[$i]["id"];
                $product_name = $product[$i]["name"];
                $product_image = $product[$i]["image"];
                $product_price = $product[$i]["price_list"];
                $price_display = "";
                $link_product = URLROOT . "products/detail/$product_id";
                foreach($product_price as $price_row){
                    $price = $price_row["price"];
                    $size_name = $price_row["size"];
                    $price_display .= "<li class='price'>Size $size_name : $price</li>";
                }
                echo "
                <div class='col-lg-4 col-md-6 col-12 product-item ml-md-0 ml-2 mb-3'>
                    <div class='card' data-aos='fade-down' data-aos-duration='1500'>
                        <a href='$link_product' class='btn btn-dark detail-button'><i class='fas fa-angle-double-right'></i></a>
                        <button class='btn btn-success add-cart'><i class='fas fa-cart-plus'></i></button>
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
        }
        ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>