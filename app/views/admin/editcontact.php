<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
    <div class="row mt-3">
        <div class="col-lg-2 col-12">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action " id="list-info-list" href="<?php echo URLROOT; ?>admin/index" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Quản lý người dùng</a>

                <a class="list-group-item list-group-item-action " id="list-order-list" href="<?php echo URLROOT; ?>admin/manageOrders" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>

                <a class="list-group-item list-group-item-action" id="list-products-list" href="<?php echo URLROOT; ?>manageproducts" role="tab" aria-controls="products"><i class="fas fa-coffee"></i> &nbsp;&nbsp;Quản lí sản phẩm</a>

                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="<?php echo URLROOT; ?>admin/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
            </div>
        </div>
        <div class="col-lg-10 col-12">
            <div class="card card-body bg-light mb-5 mr-lg-4 ml-lg-4">
                <h2>Cập nhật thông tin liên hệ</h2>
                <form action="<?php echo URLROOT; ?>admin/editcontact" method="post">
                    <div class="form-group">
                        <label for="address">Địa chỉ: <sup>*</sup></label>
                        <input type="text" name="address" id="address" class="form-control form-control-lg" value="<?php echo $data["address"]?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại: <sup>*</sup></label>
                        <input type="tel" id="phone" name="phone"  class="form-control form-control-lg" pattern="0[1-9][0-9]{8}" value="<?php echo $data["phone"]?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" value="<?php echo $data["email"]?>" required>
                    </div>
                    <div class="form-group">
                        <label for="facebook"><i class="fab fa-facebook fa-2x" style="color: #4267B2;"></i><sup>*</sup></label>
                        <input type="text" name="facebook" id="facebook" class="form-control form-control-lg" value="<?php echo $data["facebook"]?>" required>
                    </div>
                    <div class="form-group">
                        <label for="instagram"><i class="fab fa-instagram fa-2x"></i><sup>*</sup></label>
                        <input type="text" name="instagram" id="instagram" class="form-control form-control-lg" value="<?php echo $data["instagram"]?>" required>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div>
                            <input type="submit" value="Cập nhật thông tin" class="btn btn-success btn-block button-hover" id="submit-button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php else : ?>
    <h1 style="text-align: center">Bạn phải là Adminitrator để xem được thông tin này</h1>
<?php endif; ?>