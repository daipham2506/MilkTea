<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])){ 
?>
    
<div class="container" style='padding:70px 0'>
    <a href="<?php echo URLROOT; ?>shoppings/orderpage/<?php echo $_SESSION['user_id']; ?>" class='btn btn-outline-primary'>Xem đơn hàng</a>
    <br>  <h4 id="cart-header" class="text-center">Giỏ hàng</h4>
    <hr>


    <!-- <form action="<?php echo URLROOT; ?>shoppings/ordercart/<?php echo $_SESSION['user_id']?>" method="POST"> -->
    <form action="<?php echo URLROOT; ?>payment/paymomo" method="POST">
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
                            $total_price = 0;
                            for ($i = 0; $i < count($data); $i++){ 
                                $total_price += $data[$i]['price'] * $data[$i]['quantity'];
                    ?>
                                
                                        <tr>
                                            <td>
                                                <figure class="media">
                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $data[$i]['image']; ?>" class="img-thumbnail img-sm img-cart" id="img-cart"></div>
                                                    <figcaption class="media-body">
                                                        <h6 class="title text-truncate"><?php echo $data[$i]['name']; ?></h6>
                                                    </figcaption>
                                                </figure> 
                                            </td>
                                            <td><?php 
                                                require_once APPROOT."/models/Product.php";
                                                $productModel = new Product;
                                                $size_and_price = $productModel->getPriceByProductId($data[$i]['idproduct']);
                                                echo "<select id='size-".$data[$i]['idproduct']."' name='size-".$data[$i]['idproduct']."' class='form-control' onchange='changePrice(".$data[$i]['idproduct'].")'>";
                                                while ($size_and_price_row = mysqli_fetch_assoc($size_and_price)){
                                                    if ($size_and_price_row['size'] == $data[$i]['size']){
                                                        echo "<option value='".$size_and_price_row['id']."' selected='selected'>".$size_and_price_row['size']."</option>";
                                                    }
                                                    else{
                                                        echo "<option value='".$size_and_price_row['id']."'>".$size_and_price_row['size']."</option>";
                                                    }
                                                    
                                                }
                                                echo "<select>";
                                                
                                            ?>
                                            </td>
                                            <td>
                                                <input class="form-control quantity" name="quantity-<?php echo $data[$i]['idproduct']?>" type="number" min="1" max="10" value="<?php echo $data[$i]['quantity']; ?>" onchange='changeTotalPrice()'> 
                                            </td>
                                            <td> 
                                                <div class="price-wrap"> 
                                                    <var class="price price-detail" id="price-<?php echo $data[$i]['idproduct'] ?>"><?php echo $data[$i]['price']; ?>đ</var> 
                                                </div> <!-- price-wrap .// -->
                                            </td>
                                            <td class="text-right">
                                                <a href="<?php echo URLROOT; ?>shoppings/cancelcart/<?php echo $_SESSION['user_id']."?productid=".$data[$i]['idproduct']?>"  class="btn btn-outline-danger" name='cancel' onClick=" return ConfirmDialog()">x Hủy</a>
                                            </td>
                                        </tr>
                                        
                                <?php } ?> 
                     
                </tbody>
            </table>
            <var class='price text-right' style='padding-right:10px' id='total-price'>Tổng giá tiền: <?php echo $total_price; ?>đ</var>
            <?php 
                require_once APPROOT."/models/User.php";
                $userModel = new User;
                $user_address_and_phone = $userModel->findAddressAndPhoneById($_SESSION['user_id']);
            ?>
            <div class="form-group row" style='padding:10px'>
                <label for="inputAddress" class="col-sm-3 col-form-label">Địa chỉ nhận hàng</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name='address' value="<?php if(!empty($user_address_and_phone)) echo $user_address_and_phone['address'] ?>">
                </div>
            </div>
            <div class="form-group row" style='padding:10px'>
                <label for="phone" class="col-sm-3 col-form-label">Số điện thoại</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name='phone' value="<?php if(!empty($user_address_and_phone)) echo $user_address_and_phone['phone'] ?>">
                </div>
            </div>
            
            
        </div> <!-- card.// -->
        
        <input type="submit"  name="ordercart" class="btn btn-outline-primary" id="order-bill-btn" value="Đặt hàng"> 
    <form>
     
   
    <?php }
    ?>                       
</div> 



<?php } else { ?>
    <h4>Bạn phải đăng nhập để sử dụng tính năng này</h4>
<?php } ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>


