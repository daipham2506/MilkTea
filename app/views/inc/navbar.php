<nav id="navbar">
      <input type="checkbox" id="check">
      <label for="check" id="label-bars">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
      </label>
      <a href="<?php echo URLROOT; ?>"><img src="<?php echo URLROOT;?>/img/logo7.png" alt="logo"></a>
      <ul id="link" style="z-index: 2;">
        <li class="link-item"><a href="<?php echo URLROOT; ?>">Trang chủ</a></li>
        <li class="link-item"><a href="<?php echo URLROOT; ?>pages/about">Giới thiệu</a></li>
        <li class="link-item"><a href="<?php echo URLROOT; ?>pages/service">Dịch vụ</a></li>
        <li class="link-item"><a href="<?php echo URLROOT; ?>pages/product">Trà sữa</a></li>
        <li class="link-item"><a href="<?php echo URLROOT; ?>pages/contact">Liên hệ</a></li>
        <?php if(isset($_SESSION['user_id'])) : ?>
          <li class="link-item">
              <a href="<?php echo URLROOT; ?>/users/logout">Đăng xuất</a>
            </li>
          <?php else : ?>
            <li class="link-item">
              <a href="<?php echo URLROOT; ?>/users/register">Đăng kí</a>
            </li>
            <li class="link-item">
              <a href="<?php echo URLROOT; ?>/users/login">Đăng nhập</a>
            </li>
          <?php endif; ?>
      </ul>
</nav>
