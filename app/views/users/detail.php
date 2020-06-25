<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row mt-3">
        <div class="col-md-3 col-12">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action active" id="list-info-list" href="<?php echo URLROOT; ?>users/detail/<?php echo $_SESSION['user_id'] ?>" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Thông tin cá nhân</a>
                <a class="list-group-item list-group-item-action" id="list-order-list" href="#list-order" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>
                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="#list-changePass" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="profile-grid my-1">
                <!-- Top -->
                <div class="profile-top bg-primary p-2 text-white">
                    <img class="round-img my-1" src="<?php echo ($data['avatar']) ? $data['avatar'] : "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" ?> " alt="avatar" />
                    <h1 class="large"><?php echo $data["name"]?></h1>
                    <p class="lead"><?php echo $data['email']?></p>
                </div>
                <!-- About -->
                <div class="profile-about bg-light p-2">
                    <h2 class="text-primary">Địa chỉ</h2>
                    <p>
                    <?php echo $data['address'] ?  $data['address'] : "..."?>
                    </p>
                    <div class="line"></div>
                    <h2 class="text-primary">Thông tin thêm</h2>
                    <div class="skills">
                        <div class="p-4"><i class="fas fa-birthday-cake"></i>&nbsp;&nbsp;<?php echo ($data["birthday"]) ? $data['birthday'] : "..."?></div>
                        <div class="p-4"><i class="fas fa-venus-mars"></i>&nbsp;&nbsp; <?php echo ($data['gender'] == NULL) ? "..." : (($data['gender'] == 0 || $data['gender'] == "0") ? "Nữ" : "Nam" ) ?></div>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-center">
                <a href="<?php echo URLROOT;?>users/edit/<?php echo $data['id']?>" class="btn btn-dark mb-3">Cập nhật thông tin</a>
            </div>
        </div>
    </div>
<?php else: ?>
    <h1 class="text-center">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>