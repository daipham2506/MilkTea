<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])){ 
?>
    
<div class="container" style='padding:70px 0'>
    <a href="<?php echo URLROOT; ?>shoppings/orderpage/<?php echo $_SESSION['user_id']; ?>" class='btn btn-outline-primary'>Xem đơn hàng</a>
    <br>  <h4 id="cart-header" class="text-center">Giỏ hàng</h4>
    <hr>


    <form action="<?php echo URLROOT; ?>shoppings/ordercart/<?php echo $_SESSION['user_id']?>" method="POST">
        <div class="card">
        <?php
            flash('changeQuantity');
            flash('cancelProduct');
            flash('ordercart');
            if (count($data) == 0){
                echo "<p>Giỏ hàng trống</p>";
            }
            else{
            ?>

            <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col" width="100">Size</th>
                        <th scope="col" width="120">Số lượng</th>
                        <th scope="col" width="120">Giá</th>
                        <th scope="col" width="200" class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            for ($i = 0; $i < count($data); $i++){ ?>
                                        <tr>
                                            <td>
                                                <figure class="media">
                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $data[$i]['image']; ?>" class="img-thumbnail img-sm img-cart" id="img-cart"></div>
                                                    <figcaption class="media-body">
                                                        <h6 class="title text-truncate"><?php echo $data[$i]['name']; ?></h6>
                                                    </figcaption>
                                                </figure> 
                                            </td>
                                            <td><?php echo $data[$i]['size']; ?></td>
                                            <td>
                                                <input class="form-control" name="quantity-<?php echo $data[$i]['idproduct']?>" type="number" min="1" max="10" value="<?php echo $data[$i]['quantity']; ?>"> 
                                            </td>
                                            <td> 
                                                <div class="price-wrap"> 
                                                    <var class="price"><?php echo $data[$i]['price']; ?>đ</var> 
                                                </div> <!-- price-wrap .// -->
                                            </td>
                                            <td class="text-right">
                                                <a href="<?php echo URLROOT; ?>shoppings/cancelcart/<?php echo $_SESSION['user_id']."?productid=".$data[$i]['idproduct']?>"  class="btn btn-outline-danger" name='cancel' onClick=" return ConfirmDialog()">x Hủy</a>
                                            </td>
                                        </tr>
                                        
                                <?php } ?> 
                     
                </tbody>
            </table>

            
            
        </div> <!-- card.// -->
        
        <input type="submit" class="btn btn-outline-primary" id="order-bill-btn" name="ordercart" value="Đặt hàng">
    <form>
   
    <?php }
    ?>                       

</div> 


<?php } else { ?>
    <h4>Bạn phải đăng nhập để sử dụng tính năng này</h4>
<?php } ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
     function ConfirmDialog()  {
 
        var result = confirm("Xác nhận bỏ sản phẩm khỏi giỏ hàng ?");

        if(result)  {
            return true;
        } else {
            return false;
        }
}
</script>
