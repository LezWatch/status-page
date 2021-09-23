<?php require 'monitoring.php'; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>LezWatch Status Pages</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	</head>

	<body class="bg-light">

		<div class="container">
			<main>
				<div class="py-5">
					<h2>LezWatch Status</h2>
					<p class="lead">We continuously monitor the status of LezWatch.TV and all its related services. If there are any service interruptions or maintenances, information will be available here. </p>
				</div>


				<div class="row row-cols-1 row-cols-md-2 g-4">
				<?php

				if ( empty( $websites ) ) {
					?>
					<div class="col">
						<div class="card">
							<div class="card-body">
								<p>Monitors are currently paused <i class="bi bi-shield-slash"></i></p>
								<p>This may be for website updates/maintenance. Please check again later for an updated status report.</p>
							</div>
						</div>
					</div>
					<?php
				} else {
					foreach ( $websites as $website ) {
						?>
						<div class="col">
							<div class="card <?= $website['border']; ?>">
								<h5 class="card-header"><a href="<?= $website['website_url']; ?>"><?= $website['website_name']; ?></a></h5>
								<div class="card-body">
									<h5 class="card-title"><?= $website['monitor_status']; ?></h5>
									<p class="card-text"><?= $website['monitor_info']; ?></p>
									<p class="card-text">Overall uptime (last 30 days): <?= $website['monitor_uptime']; ?>%</p>
									<a href="<?= $website['website_url']; ?>" class="btn btn-primary">Visit <?= $website['website_name']; ?></a>
								</div>
								<div class="card-footer"><small class="text-muted">Monitoring started <?= $website['monitor_started']; ?></small></div>
							</div>
						</div>
						<?php
					}
				}

				?>
				</div>
			</main>

			<footer class="my-5 pt-5 text-muted text-center text-small">
				<p class="mb-1">&copy; <?php echo date( 'Y' ); ?> LezPress</p>
				<p class="mb-1">Powered by <a href="https://stats.uptimerobot.com/926OOTk28x">Uptime Robot</a></p>
			</footer>

		</div>
	</body>
</html>
