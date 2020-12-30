  </div>
  <!-- footer here -->
<?php 
	// Require model file
	require_once '../app/models/InfoWeb.php';
	$InfoWeb = new InfoWeb();
	$data = ["InfoWeb" => $InfoWeb->getContact()];
?>
  <div class="pt-5 pb-5 footer">
  	<div class="container">
  		<div class="row">
			<?php
			//  print_r($data["InfoWeb"]);
			 $address = $data["InfoWeb"]["address"];
			 $phone = $data["InfoWeb"]["phone"];
			 $email = $data["InfoWeb"]["email"];
			 $facebook = $data["InfoWeb"]["facebook"];
			 $instagram =$data["InfoWeb"]["instagram"];
			 ?>
  			<div class="col-lg-5 col-xs-12 about-company">
  				<h2>MilkTeaX</h2>
  				<p class="pr-5 text-white-50">Truy cập các liên kết bên dưới để có thêm thông tin</p>
  				<p><a href="<?php echo $facebook?>" target="_blank"><i class="fab fa-facebook mr-2"></i>
  					</a><a href="<?php echo $instagram?>" target="_blank"><i class="fab fa-instagram"></i></a></p>
  			</div>
  			<div class="col-lg-3 col-xs-12 links">
  				<?php
					if (!isset($_SESSION['isAdmin'])) : ?>
  					<h4 class="mt-lg-0 mt-sm-3">Liên kết</h4>
  					<ul class="m-0 p-0">
  						<li> <a href="<?php echo URLROOT; ?>">Trang chủ</a></li>
  						<li><a href="<?php echo URLROOT; ?>pages/about">Giới thiệu</a></li>
  						<li><a href="<?php echo URLROOT; ?>pages/service">Dịch vụ</a></li>
  						<li><a href="<?php echo URLROOT; ?>products">Trà sữa</a></li>
  						<li><a href="<?php echo URLROOT; ?>pages/contact">Liên hệ</a></li>
  					</ul>
  				<?php endif; ?>
  			</div>
  			<div class="col-lg-4 col-xs-12 location">
  				<h4 class="mt-lg-0 mt-sm-4">Văn phòng đại diện</h4>
  				<p><i class="fas fa-map-marker-alt mr-3"></i><?php echo $address?></p>
  				<p class="mb-0"><i class="fa fa-phone mr-3"></i><?php echo $phone?></p>
  				<p><i class="far fa-envelope mr-3"></i><?php echo $email?></p>
  			</div>
  		</div>

  		<?php if (isset($_SESSION['isAdmin'])) : ?>
  			<div class="row justify-content-center">
  				<a href="<?php echo URLROOT;?>admin/editcontact" class="btn btn-light">Sửa thông tin &nbsp;&nbsp;<i class="fas fa-pen"></i></a>
  			</div>
  		<?php endif; ?>

  		<div class="row mt-5">
  			<div class="col copyright">
  				<p class=""><small class="text-white-50">© 2020. All Rights Reserved.</small></p>
  			</div>
  		</div>
  	</div>
  </div>
  <button id="move-to-top" onclick="moveToTop();" class="hvr-bob"><i class="fas fa-arrow-up"></i></button>
  </div>
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  <script src="<?php echo URLROOT; ?>/js/moveToTop.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="<?php echo URLROOT; ?>js/main.js"></script>
  <script src="<?php echo URLROOT; ?>js/about.js"></script>
  <script src="<?php echo URLROOT; ?>js/readImageURL.js"></script>
  <script src="<?php echo URLROOT; ?>js/rating.js"></script>
  <script src="<?php echo URLROOT; ?>js/header.js"></script>
  <script src="<?php echo URLROOT; ?>js/postDetail.js"></script>
  <script src="<?php echo URLROOT; ?>js/editPost.js"></script>
  <script src="<?php echo URLROOT; ?>js/payment.js"></script>

  <script src="<?php echo URLROOT; ?>js/shoppingcart.js"></script>
  </body>

  <script src="<?php echo URLROOT; ?>js/displaySizeContainer.js"></script>
  </body>

  </html>