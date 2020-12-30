<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
    // var_dump( $data["listProductSearch"]);
?>
<div class="container mt-3">
    <div class="row" id="menu">
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
                $star = printStar(rand(3,5));
                $numOfReview = rand(20,50);
                $numOfSale = rand(100,300);
                $id_size = array();
                $j=0;
                foreach($product_price as $price_row){
                    // print_r($product_price);
                    $id_size[$j] = $price_row["id"];
                    $j++;
                    $price = $price_row["price"];
                    $size_name = $price_row["size"];
                    array_push($list_price_id,$price_row["id"]);
                    $price_display = 'đ '. $price;
                    $button_add_card  = "";
                    if (isset($_SESSION['user_id'])){
                        $button_add_card = "<a href='".URLROOT."products/addOneToCart/".$product_id."?size=".$id_size[0]."' class=''><img class='' src='".URLROOT."/img/product/add_to_cart.png' alt='new-item'/></a>";
                    }
                }
                echo "
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
        }
        ?>
    </div>
    <div class="d-flex justify-content-end align-items-center">
        <p style="margin-right: 4px;">Trang: </p>
        <nav aria-label="Page navigation example">
            <ul class="pagination" id="pagination">
                <?php 
                    $page_no = 1;
                    if(isset($_GET["pageno"])){
                        $page_no = $_GET["pageno"];
                    }
                    $name_key = $data["name_key"];
                    $urlGetListPost = URLROOT . "products/listproductsearch?" . "name_key=$name_key&" . "pageno=";
                    for ($i = 1; $i <= $data['totalPage']; $i++){
                        $url = $urlGetListPost . $i;
                        if($page_no == $i){
                            echo <<< _END
                                <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page active_page">$i</p></a>
                            _END;
                        }
                        else{
                            echo <<< _END
                                <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page">$i</p></a>
                            _END;
                        }
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>