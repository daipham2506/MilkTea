<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])){ 

?>
<div class='container' style='padding:70px 0'>
    <h4 class="text-center">Danh sách các đơn hàng</h4>
    <?php
        for ($i = 0; $i < count($data); $i++){  ?>
            <h5 id="cart-header" class="text-center">Mã đơn hàng: <?php echo $data[$i]['id'] ?></h5>
            <div class='card'>
                <table class="table table-hover shopping-cart-wrap">
                    <thead class="text-muted">
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" width="100">Size</th>
                            <th scope="col" width="120">Số lượng</th>
                            <th scope="col" width="120">Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $total_price = 0;
                            for ($x = 0; $x < count($data[$i]['product']); $x++){ 
                                $product = $data[$i]['product'][$x];
                                $total_price += $product['quantity'] * $product['price'];
                                ?>
                                        <tr>
                                            <td>
                                                <figure class="media">
                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $product['image']; ?>" class="img-thumbnail img-sm" id="img-cart"></div>
                                                    <figcaption class="media-body">
                                                        <h6 class="title text-truncate"><?php echo $product['name']; ?></h6>
                                                    </figcaption>
                                                </figure> 
                                            </td>
                                            <td><?php echo $product['size']; ?></td>
                                            <td>
                                                <?php echo $product['quantity'] ?>
                                            </td>
                                            <td> 
                                                <div class="price-wrap"> 
                                                    <var class="price"><?php echo $product['price']; ?>đ</var> 
                                                </div> <!-- price-wrap .// -->
                                            </td>
                                        </tr>
    
                                <?php } ?> 
                    </tbody>
                </table>
                <var class='price text-right' style='padding-right:10px'>Tổng giá tiền: <?php echo $total_price; ?>đ</var>
            </div>    
        <?php  } ?>
</div>


<?php 
    }
    else{
        echo "<h4>Bạn phải đăng nhập để sử dụng tính năng này</h4>";
    }
?>
<?php require APPROOT . '/views/inc/footer.php'; ?>