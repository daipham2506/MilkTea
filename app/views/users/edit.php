<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row mt-3">
        <div class="col-md-3 col-12">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action active" id="list-info-list" href="<?php echo URLROOT; ?>users/detail/<?php echo $_SESSION['user_id'] ?>" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Thông tin cá nhân</a>
                <a class="list-group-item list-group-item-action" id="list-order-list" href="<?php echo URLROOT; ?>shoppings/orderpage/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>
                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="<?php echo URLROOT; ?>users/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="card card-body bg-light mb-5 mr-lg-4 ml-lg-4">
                <h2>Cập nhật thông tin</h2>
                <p>Vui lòng điền vào form bên dưới để cập nhật thông tin</p>
                <form action="<?php echo URLROOT; ?>users/update/<?php echo $data['id'] ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="current-avatar" id="current-avatar" value="<?php echo $data["avatar"];?>">
                    <div class="form-group">
                        <label for="name">Tên: </label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" required aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">Chúng tôi không bao giờ chia sẻ email của bạn</small>
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" name="address" id="address" class="form-control form-control-lg" value="<?php echo $data['address']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone"  class="form-control form-control-lg" pattern="0[1-9][0-9]{8}" aria-describedby="phoneHelp">
                        <small id="phoneHelp" class="form-text text-muted">Chúng tôi không bao giờ chia sẻ số điện thoại của bạn</small>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input type="date" name="birthday" id="birthday" class="form-control form-control-lg" value="<?php echo $data['birthday']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <label class="checkbox-inline ml-5"><input type="radio" name="gender" value=1 <?php if ($data['gender'] == 1) echo "checked" ?>>Nam</label>
                        <label class="checkbox-inline ml-5"><input type="radio" name="gender" value=0 <?php if ($data['gender'] == 0) echo "checked" ?>>Nữ</label>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Chọn ảnh</label>
                        <input type="file" class="form-control-file" name="avatar" id="avatar" onchange="readImageURL(this);">
                        <p class="text-danger"><?php if(array_key_exists('avatar_err', $data)) echo $data['avatar_err']; ?></p>
                        <div class="row d-flex justify-content-center">
                            <img id="avatar-preview" src="<?php echo $data['avatar'];?>" alt="your image" class="border border-secondary rounded">
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div>
                            <input type="submit" value="Cập nhật thông tin" class="btn btn-success btn-block" id="submit-button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php else : ?>
    <h1 class="text-center">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>