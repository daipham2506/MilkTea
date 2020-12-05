<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])){ 
?>
<div class="container" style='padding:12px 0'>
    <h4 id="cart-header" class="text-center">Thanh toán</h4>
    <hr>

    <!-- <form action="<?php echo URLROOT."payment/handlepayment" ?>" method="POST"> -->
        <div class="card">

            <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                    <tr>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col" width="100">Size</th>
                        <th scope="col" width="120">Số lượng</th>
                        <th scope="col" width="120">Còn lại(sp)</th>
                        <th scope="col" width="120">Giá</th>
                    </tr>
                </thead>
                <tbody>

            <?php
                $total_price = 0;
                for ($i = 0; $i < count($data["productInCart"]); $i++){ 
                $total_price += $data["productInCart"][$i]['price'] * $data["productInCart"][$i]['quantity'];
            ?>

                    <tr>
                        <td>
                            <figure class="media">
                                <div class="img-wrap" id='container-img-cart'><img src="<?php echo $data["productInCart"][$i]['image']; ?>" class="img-thumbnail img-sm img-cart" id="img-cart"></div>
                                <figcaption class="media-body">
                                    <h6 class="title text-truncate"><?php echo $data["productInCart"][$i]['name']; ?></h6>
                                </figcaption>
                            </figure> 
                        </td>
                        <td><?php 
                            echo $data["productInCart"][$i]['size'];
                        ?>
                        <input value="<?php echo $data["productInCart"][$i]['size']; ?>" style="display: none;" type="text" name="<?php echo "size-".$data["productInCart"][$i]['idproduct']; ?>"/>
                        </td>
                        <td>
                            <?php echo $data["productInCart"][$i]['quantity']?>
                        <input value="<?php echo $data["productInCart"][$i]['quantity']?>" style="display: none;" type="number" name="quantity-<?php echo $data["productInCart"][$i]['idproduct']?>"/>
                        </td>
                        <td>
                            <?php echo $data["productInCart"][$i]["total_quantity"];?>
                        </td>
                        <td> 
                            <div class="price-wrap"> 
                                <var class="price price-detail" id="price-<?php echo $data["productInCart"][$i]['idproduct'] ?>"><?php echo $data["productInCart"][$i]['price']; ?>đ</var> 
                            </div> <!-- price-wrap .// -->
                        </td>
                    </tr>
                    
            <?php } ?> 
                </tbody>
            </table>
            <var class='price' style='padding:20px;' id='total-price'>Tổng giá tiền: <?php echo $total_price; ?>  đ</var>
            <div style="padding-left: 20px;">
                <span>Địa chỉ: </span> <?php echo $data["address"]; ?>
            </div>
            <div style="padding-left: 20px;">
                <span>Số điện thoại: </span> <?php echo $data["phone"]; ?>
            </div>

            <div style="padding: 20px;">
                <div>Hình thức thanh toán</div>
                <select name="type_payment" style="padding: 6px; margin-bottom: 30px;" id="type-payment">
                    <option value="momo">Thanh toán bằng Momo</option>
                    <option value="normal">Thanh toán khi nhận hàng</option>
                </select>
                <br />
                <button name="ordercart" userId="<?php echo $_SESSION["user_id"]; ?>" 
                urlRoot="<?php echo URLROOT; ?>" class="btn btn-info" id="pay-with-momo" 
                orderId="<?php echo uniqid(); ?>"
                address="<?php echo $data["address"]; ?>"
                phone="<?php echo $data["phone"]; ?>"
                totalPrice="<?php echo $total_price; ?>"
                >Thanh toán</button>
            </div>
        </div>
    <!-- </form> -->
</div>

<?php } else { ?>
    <h4>Bạn phải đăng nhập để sử dụng tính năng này</h4>
<?php } ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>