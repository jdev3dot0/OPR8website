<?php
/**
 * Front page — Diensten (mirrors opr8-it.be home).
 */
get_header();

$theme_uri = get_template_directory_uri();
$slides = [
	$theme_uri . '/assets/images/businessmen1240.jpg',
	$theme_uri . '/assets/images/elderly1240.jpg',
	$theme_uri . '/assets/images/fatherson1240.jpg',
];
?>
<main id="main">
	<section class="hero" data-hero>
		<div class="hero-slides" aria-hidden="true">
			<?php foreach ($slides as $i => $src) : ?>
				<div class="hero-slide<?php echo $i === 0 ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url($src); ?>')"></div>
			<?php endforeach; ?>
		</div>
		<div class="container hero-content">
			<img class="hero-logo" src="<?php echo esc_url(opr8_asset('images/logo-black.gif')); ?>" alt="OPR8-IT">
			<p class="hero-kicker">Kies <strong>herstellingen</strong></p>
			<p class="hero-sub">Ongewoon bezorgd om uw IT activiteiten</p>
			<a class="btn" href="#diensten">Alle info</a>
		</div>
		<div class="hero-dots" data-hero-dots>
			<?php foreach ($slides as $i => $_) : ?>
				<button type="button" class="<?php echo $i === 0 ? 'is-active' : ''; ?>" aria-label="Slide <?php echo (int) ($i + 1); ?>"></button>
			<?php endforeach; ?>
		</div>
	</section>

	<section id="diensten" class="section">
		<div class="container">
			<p class="platforms"><strong>Windows (10&amp;11, Server 2016/2019/2022) – Linux – Android – IOS</strong></p>
			<div class="services-grid">
				<article class="service-card">
					<h3>Hardware: Verkoop/Herstellingen</h3>
					<p>OPR8-IT adviseert U en verkoopt U het meeste geschikte apparaat voor Uw noden, of herstelt Uw apparaat</p>
				</article>
				<article class="service-card">
					<h3>Netwerk</h3>
					<p>OPR8-IT ontwerpt en bouwt Uw nieuw netwerk, of optimaliseert Uw bestaande infrastructuur</p>
				</article>
				<article class="service-card">
					<h3>KMO</h3>
					<p>Kantooroptimalisatie (netwerkprinting, NAS – netwerkopslag, centralisatie van online kalenders,…), Office 365 activatie / migratie, kassa’s / POS systemen op Windows10 – MS Surface</p>
				</article>
				<article class="service-card">
					<h3>Websites</h3>
					<p>Design, ontwikkeling en onderhoud van websites</p>
				</article>
			</div>
		</div>
	</section>

	<section class="section section-muted">
		<div class="container passion">
			<p>OPR8-IT is gepassioneerd door IT … en … zeilen … en …drones! Klik op de icons om meer te weten te komen</p>
			<div class="passion-icons">
				<a href="<?php echo esc_url(home_url('/opr8-it-zeilen/')); ?>">
					<img src="<?php echo esc_url(opr8_asset('images/sailing_icon.gif')); ?>" alt="">
					<span>Zeilen</span>
				</a>
				<a href="<?php echo esc_url(home_url('/opr8-it-drones/')); ?>">
					<img src="<?php echo esc_url(opr8_asset('images/drone_icon.png')); ?>" alt="">
					<span>Drones</span>
				</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
