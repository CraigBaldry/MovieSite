<!doctype html>
<html>
<head>
<title><?php echo basename( __FILE__, '.php' ); ?></title>
<link href="main.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container">
  <div class="header">
	<?php require_once 'include/inc_logo.php'; ?>
  </div>
  <div class="sidebar1">
	<?php
	require_once 'include/inc_nav.php';
	require_once 'include/inc_sidebar1.php';
	?>
  </div>
  <div class="sidebar2">
	<?php
	require_once 'include/inc_nav.php';
	require_once 'include/inc_sidebar2.php';
	?>
  </div>
  <div class="content">
	<h1>About</h1>
	<p>This is about me</p>	
  </div>
  <div class="footer">
	<?php require_once 'include/inc_footer.php'; ?>
  </div>
</div>
</body>
</html>
