<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <!-- Add jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/profile.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/product.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/postdetail.css">
  <title><?php echo SITENAME; ?></title>
</head>

<body>
  <div id="root" style="overflow-x: hidden;">
    <?php require APPROOT . '/views/inc/navbar.php'; ?>
    <div class="container-fluid main">
      <form class="input-group search-form">
        <input type="text" class="form-control" placeholder="Nhập từ khóa cần tìm kiếm">
        <div class="input-group-append">
          <button class="btn btn-secondary" type="button">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </form>