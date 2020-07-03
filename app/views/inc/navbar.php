<nav id="navbar">
  <input type="checkbox" id="check">
  <label for="check" id="label-bars">
    <i class="fas fa-bars" id="btn"></i>
    <i class="fas fa-times" id="cancel"></i>
  </label>

  <a href="<?php echo URLROOT; ?>"><img id="logo" src="<?php echo URLROOT; ?>/img/logo7.png" alt="logo"></a>
  <?php if (isset($_SESSION['user_id'])) :
    require_once APPROOT . '/models/User.php';
    $userModel = new User;
    $avatarURL = $userModel->findUserById($_SESSION['user_id'])->avatar;
  ?>
    <a id="shopping-cart" href="#">
      <i class="fas fa-shopping-cart"></i>
      <span id="item-number">2</span>
    </a>
    <a id="user-avatar" href="<?php echo URLROOT; ?>users/detail/<?php echo $_SESSION['user_id'] ?>">
      <img id="avatar" src="<?php echo ($avatarURL) ? $avatarURL : "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png"; ?>" alt="user-avatar">
    </a>
  <?php endif; ?>


  <ul id="link" style="z-index: 2;">

    <li class="link-item "><a class="header-select" href="<?php echo URLROOT; ?>">Trang chủ</a></li>
    <li class="link-item"><a class="header-select" href="<?php echo URLROOT; ?>pages/about">Giới thiệu</a></li>
    <li class="link-item"><a class="header-select" href="<?php echo URLROOT; ?>pages/service">Dịch vụ</a></li>
    <li class="link-item"><a class="header-select" href="<?php echo URLROOT; ?>products">Trà sữa</a></li>
    <li class="link-item"><a class="header-select" href="<?php echo URLROOT; ?>pages/contact">Liên hệ</a></li>
    <?php if (isset($_SESSION['user_id'])) : ?>
      <li class="link-item"><a class="header-select" href="<?php echo URLROOT; ?>posts/listposts">Bài đăng</a></li>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_id'])) : ?>
      <li class="link-item">
        <a class="header-select" href="<?php echo URLROOT; ?>users/logout"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    <?php else : ?>
      <li class="link-item">
        <a class="header-select" href="<?php echo URLROOT; ?>users/register">Đăng kí</a>
      </li>
      <li class="link-item">
        <a class="header-select" href="<?php echo URLROOT; ?>users/login">Đăng nhập</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>