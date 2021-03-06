<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row mb-5">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <?php flash('register_success'); ?>
      <?php flash('changepass_success'); ?>
      <h2>Đăng nhập</h2>
      <p>Vui lòng điền email và mật khẩu</p>
      <form action="<?php echo URLROOT; ?>users/login" method="post">
        <div class="form-group">
          <label for="email">Email: <sup>*</sup></label>
          <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu: <sup>*</sup></label>
          <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>
        <div class="row">
          <div class="col">
            <input type="submit" value="Đăng nhập" class="btn btn-success btn-block">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT; ?>users/register" class="btn btn-light btn-block">Không có tài khoản? Đăng kí ngay</a>
          </div>
        </div>
        <div class="row text-center" style="margin: 15px 2px 5px 2px;">
          <a href="<?php echo URLROOT; ?>users/forgotpass" class="btn btn-light btn-block">Quên mật khẩu</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>