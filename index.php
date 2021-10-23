<?php require 'monitoring.php'; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>LezWatch Status Pages</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
	</head>

	<body class="bg-light">

		<div class="container">
			<main>
				<div class="py-5">
					<h2>LezWatch Status</h2>
					<p class="lead">We continuously monitor the status of LezWatch.TV and all its related services. If there are any interruptions, outages, or maintenances, information will be available here.</p>
				</div>

				<div class="row row-cols-1 row-cols-md-2 g-4">
				<?php

				if ( empty( $websites ) ) {
					?>
					<div class="col">
						<div class="card">
							<div class="card-body">
								<p>All monitors are currently paused <i class="bi bi-shield-slash"></i></p>
								<p>This may be for website updates/maintenance. Please check again later for an updated status report.</p>
							</div>
						</div>
					</div>
					<?php
				} else {
					foreach ( $websites as $website ) {
						?>
						<div class="col">
							<div class="card border-<?php echo $website['class']; ?>">
								<h5 class="card-header bg-<?php echo $website['class']; ?> text-white"><?php echo $website['monitor_status']; ?></h5>
								<div class="card-body">

									<p class="card-text"><i class="bi bi-graph-up-arrow"></i> Overall uptime (last 30 days): <?php echo $website['monitor_uptime']; ?>%</p>

									<p class="card-text"><i class="bi bi-clock-history"></i> <?php echo $website['monitor_info']; ?></p>

									<a href="<?php echo $website['monitor_link']; ?>" class="btn btn-secondary" target="_blank">Service Details</a>
									<a href="<?php echo $website['website_url']; ?>" class="btn btn-primary" target="_blank">Visit <?php echo $website['website_name']; ?></a>
								</div>
								<div class="card-footer bg-<?php echo $website['class']; ?>"><small class="text-white-50"><i class="bi bi-calendar2-plus"></i> Monitoring started <?php echo $website['monitor_started']; ?></small></div>
							</div>
						</div>
						<?php
					}
				}

				?>
				</div>
			</main>

			<footer class="my-5 pt-5 text-muted text-center text-small">
				<p class="mb-1">&copy; <?php echo date( 'Y' ); ?> LezPress | Powered by <a href="<?php echo $uptime_url; ?>">Uptime Robot</a></p>

				<p class="mb-1"><a href="https://github.com/LezWatch/status-page/" target="_blank"><i class="bi bi-github"></a></i> <a href="https://twitter.com/lezwatchtv/" target="_blank"><i class="bi bi-twitter"></i></a></p>

				<p class="mb-1">Licened <a href="/LICENSE">MIT</a></p>
			</footer>

		</div>
	</body>
</html>
