<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
    // var_dump( $data["listProductSearch"]);
?>
<div class="container mt-3">
    <div class="row">
        <?php
        // var_dump($data["product"]);
        // echo $data["totalPage"];
        $product = $data["listProductSearch"];
        if(count($product) < 1){
            echo '<h1 class="text-danger w-100 text-center mb-5 mt-5">No product here</h1>';
        }
        else{
            for($i = 0; $i < count($product); $i++){
                $product_id = $product[$i]["id"];
                $product_name = $product[$i]["name"];
                $product_image = $product[$i]["image"];
                $product_price = $product[$i]["price_list"];
                $price_display = "";
                $link_product = URLROOT . "products/detail/$product_id";
                $list_price_id = [];
                foreach($product_price as $price_row){
                    // print_r($product_price);
                    $price = $price_row["price"];
                    $size_name = $price_row["size"];
                    array_push($list_price_id,$price_row["id"]);
                    $price_display .= "<li class='price'>Size $size_name : $price</li>";
                }
                echo "
                <div class='col-lg-4 col-md-6 col-12 product-item ml-md-0 ml-2 mb-3'>
                    <div class='card' data-aos='fade-down' data-aos-duration='1500'>
                        <a href='$link_product' class='btn btn-dark detail-button'><i class='fas fa-angle-double-right'></i></a>
                        <a href='".URLROOT."products/addOneToCart/".$product_id."?size=".$list_price_id[0]."' class='btn btn-success add-cart'><i class='fas fa-cart-plus'></i></a>
                        <a  class='d-flex justify-content-center' href='$link_product'><img src='$product_image' class='card-img-top img-product' alt='$product_name'></a>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_name</h5>
                            <ul class='cart-text list-price-product'>
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
    <div class="d-flex justify-content-end align-items-center">
        <p style="margin-right: 4px;">Trang: </p>
        <nav aria-label="Page navigation example">
            <ul class="pagination" id="pagination">
                <?php 
                    $name_key = $data["name_key"];
                    $urlGetListPost = URLROOT . "products/listproductsearch?" . "name_key=$name_key&" . "pageno=";
                    for ($i = 1; $i <= $data['totalPage']; $i++){
                        $url = $urlGetListPost . $i;
                        echo <<< _END
                            <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page">$i</p></a>
                        _END;
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>