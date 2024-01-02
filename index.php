<?php require 'monitoring.php'; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>LezWatch Status Page</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
	</head>

	<body class="bg-light">
		<main>
			<div class="container">
				<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
					<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
						<?php echo file_get_contents( 'toaster.svg' ); ?>
						<span class="fs-4">LezWatch Status</span>
					</a>

					<ul class="nav nav-pills">
						<li class="nav-item"><a href="/" class="nav-link active" aria-current="page">Status</a></li>
						<li class="nav-item"><a href="https://lezwatchtv.com/" class="nav-link">LezWatch.TV</a></li>
						<li class="nav-item"><a href="https://docs.lezwatchtv.com/" class="nav-link">Documentation</a></li>
					</ul>
				</header>

				<p class="lead">We continuously monitor the status of LezWatch.TV and all its related services. If there are any interruptions, outages, or maintenances, information will be available here.</p>

				<h2>Current Status</h2>

				<?php
				if ( empty( $websites ) ) {
					?>
					<div class="alert alert-danger" role="alert">
						<p>All monitors are currently paused <i class="bi bi-shield-slash"></i></p>
						<p>This may be for website updates/maintenance. Please check again later for an updated status report.</p>
					</div>
					<?php
				} else {
					// Overview of statuses
					?>
					<ul class="list-group">
						<?php
						foreach ( $websites as $website ) {
							?>
							<li class="list-group-item list-group-item-<?php echo $website['class']; ?>">
								<?php echo $website['monitor_status']; ?>
							</li>
							<?php
						}
						?>
					</ul>

					<hr>

					<h2>Detailed Information</h2>

					<?php
					foreach ( $websites as $website ) {
						?>
						<div class="card">
							<h5 class="card-header"><a href="<?php echo $website['website_url']; ?>"><?php echo $website['website_name']; ?></a></h5>
							<div class="card-body">
								<p class="card-text"><i class="bi bi-graph-up-arrow"></i> Overall uptime (last 30 days): <?php echo $website['monitor_uptime']; ?>%</p>
								<p class="card-text"><i class="bi bi-clock-history"></i> <?php echo $website['monitor_info']; ?></p>

								<a href="<?php echo $website['monitor_link']; ?>" class="btn btn-outline-dark btn-sm" target="_blank">Service Details</a>
								<a href="<?php echo $website['website_url']; ?>" class="btn btn-outline-primary btn-sm" target="_blank">Visit <?php echo $website['website_name']; ?></a>
							</div>
						</div>
						<p>&nbsp;</p>
						<?php
					}
				}
				?>
				</div>
			</main>

			<footer class="my-5 pt-5 text-muted text-center text-small">
				<p class="mb-1">&copy; <?php echo date( 'Y' ); ?> LezWatch.TV | Powered by <a href="<?php echo $uptime_url; ?>">Uptime Robot</a></p>

				<p class="mb-1">
					<a href="https://github.com/LezWatch/status-page/" target="_blank"><i class="bi bi-github"></a></i>&nbsp;
					<a rel="me" href="https://twitter.com/lezwatchtv/" target="_blank"><i class="bi bi-twitter-x"></i></a>&nbsp;
					<a rel="me" href="https://mstdn.social/@lezwatchtv" target="_blank"><i class="bi bi-mastodon"></i></a>
				</p>

				<p class="mb-1">Licensed <a href="/LICENSE">MIT</a></p>
			</footer>

		</div>
	</body>
</html>
