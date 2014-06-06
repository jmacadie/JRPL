<?php if (!isset($_SESSION)) session_start();?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>The Julian Rimet Olympics Predictions League</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" lang="en" content="Julian Rimet, JRPL, World Cup, Predictions, Football, 2014"/>
	<meta name="description" lang="en" content="The Julian Rimet Predictions League -
		Home of the world's most accurate predictions"/>
	<meta name="author" content="Maccas">

	<!-- Styles -->
	
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	
	<!-- Custom styles for this template -->
	<link type="text/css" href="<?php htmlout($tab == 'home' ? '' : '../'); ?>assets/css/JRPL.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- Fav and touch icons -->
	<link rel="icon" href="<?php htmlout($tab == 'home' ? '' : '../'); ?>assets/ico/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="<?php htmlout($tab == 'home' ? '' : '../'); ?>assets/ico/favicon.png" type="image/x-icon">

</head>

<body>

	<?php
	// set logged in variables
	if (userIsLoggedIn())
	{
		if (isset($_SESSION['displayName'])) $displayName = $_SESSION['displayName'];
		if (isset($_SESSION['firstName'])) $firstName = $_SESSION['firstName'];
		if (isset($_SESSION['lastName'])) $lastName = $_SESSION['lastName'];
	}
	?>
	
	<!-- Navigation Bar -->
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://www.julianrimet.com">JRPL</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<?php htmlout($tab == 'fixtures' ?
						'<li class="active"><a href="./">Fixtures</a></li>' :
						'<li><a href="'.($tab == 'home' ? '' : '../').'fixtures/">Fixtures</a></li>'); ?>
					<?php htmlout($tab == 'tables' ?
						'<li class="active"><a href="./">Results</a></li>' :
						'<li><a href="'.($tab == 'home' ? '' : '../').'results/">Results</a></li>'); ?>
					<?php htmlout($tab == 'rules' ?
						'<li class="active"><a href="./">Rules</a></li>' :
						'<li><a href="'.($tab == 'home' ? '' : '../').'rules/">Rules</a></li>'); ?>
					<?php if (isset($_SESSION['isAdmin']) and $_SESSION['isAdmin'] == TRUE)
						htmlout($tab == 'admin' ?
							'<li class="active"><a href="./">Admin</a></li>' :
							'<li><a href="'.($tab == 'home'?'':'../').'admin/">Admin</a></li>'); ?>
				</ul>
				<?php if (!isset($_SESSION['loggedIn']) or $_SESSION['loggedIn'] == FALSE): ?>
					<ul class="nav navbar-nav navbar-right">
						<?php htmlout($tab == 'login' ?
							'<li class="active"><a href="./">Log In</a></li>' :
							'<li><a href="'.($tab == 'home' ? '' : '../').'login/">Log In</a></li>'); ?>
					</ul>
				<?php else: ?>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">logged in as
								<?php htmlout($displayName == '' ? $firstName.' '.$lastName : $displayName); ?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php htmlout($tab == 'home' ? '' : '../'); ?>details">Profile</a></li>
								<li class="divider"></li>
								<li><a href="#" id="logOut">Log Out</a></li>
							</ul>
						</li>
					</ul>
				<?php endif; ?>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	<div class="container">
		
		<div class="page-content">
		<?php
			// Load the specific page's content
			include $content;
		?>
		</div>
		
		<footer class="footer">
			<hr>
			<p>&copy; Keep predicting! Julian & Will</p>
		</footer>

	</div> <!-- /container -->

	<!-- Javascript
   ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="<?php htmlout($tab == 'home' ? '' : '../'); ?>assets/js/logout.js"></script>

	<?php
		// Load the specific page's additional javascript content
		include $contentjs;
	?>

</body>

</html>