<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo TITLE?></title>
<meta name="description" content="">

<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap-responsive.css">
<link rel="stylesheet" href="css/jquery.fancybox.css">
<link rel="stylesheet" href="css/uniform.default.css">
<link rel="stylesheet" href="css/bootstrap.datepicker.css">
<link rel="stylesheet" href="css/jquery.cleditor.css">
<link rel="stylesheet" href="css/jquery.plupload.queue.css">
<link rel="stylesheet" href="css/jquery.tagsinput.css">
<link rel="stylesheet" href="css/jquery.ui.plupload.css">
<link rel="stylesheet" href="js/tableTools/css/TableTools.css">
<link rel="stylesheet" href="css/chosen.css">
<link rel="stylesheet" href="css/jquery.jgrowl.css">
<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="topbar clearfix">
		<div class="container-fluid">
			<a href="index.php" class='company'><?php echo TITLE ?> Admin Panel</a>

			<ul class='mini'>
				<li><a href="index.php?page=settings"> <img
						src="img/icons/fugue/gear.png" alt=""> Settings
				</a></li>
				<li><a href="index.php?page=logout"> <img
						src="img/icons/fugue/control-power.png" alt=""> Logout
				</a></li>
			</ul>
		</div>
	</div>
	<div class="breadcrumbs">
		<div class="container-fluid">
			<ul class="bread pull-left">
				<li><a href="index.php"><i class="icon-home icon-white"></i></a></li>
				<li>
				<?php
                switch (true) {
                    /*
                     * case ($page == 'featured' || $page == 'editfeatured'):
                     * echo "<a href='index.php?page=featured'>Featured Apps</a>";
                     * break;
                     * case ($page == 'user' || $page == 'edituser'):
                     * echo "<a href='index.php?page=user'>User</a>";
                     * break;
                     * case ($page == 'bookmark' || $page == 'editbookmark'):
                     * echo "<a href='index.php?page=bookmark'>Bookmarks</a>";
                     * break;
                     */
                    case ($page == 'merchants' || $page == 'editmerchant' 
                        || $page == 'offer' || $page == 'editoffer' 
                        || $page == 'beacon' || $page == 'editbeacon' ):
                        echo "<a href='index.php?page=merchants'>Merchants</a>";
                        break;
                    default:
                        echo "<a href='index.php'>Dashboard</a>";
                        break;
                }
                ?>
			 </li>
			 <?php if ( $page == 'beacon' || $page == 'offer' ) {
			     $merchant = $db->single_row("merchant", "*", "id='" . $_REQUEST['mID'] . "'");
			 ?>
			 <li>
			     <a href='#'><?php echo $merchant['business_name']?></a>
			 </li>
			 <?php } ?>
			</ul>
		</div>
	</div>
	<div class="main">
		<div class="container-fluid">
			<div class="navi">
				<ul class='main-nav'>
					<li><a href="index.php?page=home" class='light'>
							<div class="ico">
								<i class="icon-home icon-white"></i>
							</div> Dashboard <!-- <span class="label label-warning">10</span> -->
					</a></li>

					<li class='active open'><a href="#" class='light toggle-collapsed'>
							<div class="ico">
								<i class="icon-signal icon-white"></i>
							</div> Merchants <img src="img/toggle-subnav-down.png" alt="">
                        </a>
						<ul class='collapsed-nav'>
							<li
								<?php if($_REQUEST['page']=='merchants' || $_REQUEST['page']=='editmerchant'){?>
								class='active' <?php }?>><a href="index.php?page=merchants">
									Merchants</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="content">
				<div class="row-fluid">
				<?php
                    foreach ($MiddleContents as $fld => $val) {
                        include ($val);
                    }
                ?>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery.js"></script>
	<script src="js/less.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/bootstrap.timepicker.js"></script>
	<script src="js/bootstrap.datepicker.js"></script>
	<script src="js/chosen.jquery.min.js"></script>
	<script src="js/jquery.fancybox.js"></script>
	<script src="js/plupload/plupload.full.js"></script>
	<script src="js/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<script src="js/jquery.cleditor.min.js"></script>
	<script src="js/jquery.inputmask.min.js"></script>
	<script src="js/jquery.tagsinput.min.js"></script>
	<script src="js/jquery.mousewheel.js"></script>
	<script src="js/jquery.jgrowl_minimized.js"></script>
	<script src="js/jquery.form.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/bbq.js"></script>
	<script src="js/jquery-ui-1.8.22.custom.min.js"></script>
	<script src="js/jquery.form.wizard-min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/jquery.dataTables.bootstrap.js"></script>
	<script src="js/jquery.textareaCounter.plugin.js"></script>
	<script src="js/ui.spinner.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/tableTools/js/TableTools.min.js"></script>
	<script src="js/jquery.metadata.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/demo.js"></script>
</body>
</html>