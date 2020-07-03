<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
    <div class="row mt-3">
        <div class="col-md-2 col-12" style="margin-left:40px">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action" id="list-info-list" href="<?php echo URLROOT; ?>admin/index" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Quản lý người dùng</a>
                <a class="list-group-item list-group-item-action" id="list-order-list" href="#" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>
                <a class="list-group-item list-group-item-action active" id="list-changePass-list" href="<?php echo URLROOT; ?>admin/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="card card-body bg-light mb-5 mr-lg-4 ml-lg-4">
                <h2>Thay đổi mật khẩu</h2>
                <!-- <p>Vui lòng điền vào form bên dưới để cập nhật thông tin</p> -->
                <form action="<?php echo URLROOT; ?>admin/changepass/<?php echo $data['id'] ?>" method="post">
                    <div class="form-group">
                        <label for="name">Mật khẩu hiện tại: <sup>*</sup></label>
                        <input type="password" name="old-pass" id="old-pass" class="form-control form-control-lg <?php echo (!empty($data['old_pass_err'])) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['old_pass_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu mới: <sup>*</sup></label>
                        <input type="password" name="new-pass" id="new-pass" class="form-control form-control-lg <?php echo (!empty($data['new_pass_err'])) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['new_pass_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Nhập lại mật khẩu mới: <sup>*</sup></label>
                        <input type="password" name="confirm-pass" id="confirm-pass" class="form-control form-control-lg <?php echo (!empty($data['confirm_pass_err'])) ? 'is-invalid' : ''; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['confirm_pass_err']; ?></span>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div>
                            <input type="submit" value="Thay đổi mật khẩu" class="btn btn-success btn-block" id="submit-button">
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