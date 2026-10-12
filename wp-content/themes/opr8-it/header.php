<?php
/**
 * Header template.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo esc_url(opr8_asset('images/favicon.ico')); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#main" style="position:absolute;left:-9999px;">Skip to content</a>
<header class="site-header">
	<div class="container header-inner">
		<div class="site-branding">
			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<img src="<?php echo esc_url(opr8_asset('images/logo.gif')); ?>" alt="OPR8-IT">
			</a>
		</div>
		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-nav-toggle>
			Menu
		</button>
		<nav id="primary-nav" class="primary-nav" data-primary-nav aria-label="Hoofdmenu">
			<?php
			if (has_nav_menu('primary')) {
				wp_nav_menu([
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu',
					'depth'          => 1,
					'fallback_cb'    => false,
				]);
			} else {
				echo '<ul class="menu">';
				$items = [
					['/', 'Diensten'],
					['/contact/', 'Contact'],
					['/wie-is-opr8-it/', 'Wie is OPR8-IT?'],
					['/websites/', 'Websites'],
					['/opr8-it-drones/', 'OPR8-IT & drones'],
				];
				foreach ($items as [$path, $label]) {
					$url = home_url($path);
					$current = (untrailingslashit($_SERVER['REQUEST_URI'] ?? '') === untrailingslashit(wp_parse_url($url, PHP_URL_PATH) ?: '')) ? ' current-menu-item' : '';
					if ($path === '/' && (is_front_page() || is_home())) {
						$current = ' current-menu-item';
					}
					printf(
						'<li class="menu-item%s"><a href="%s">%s</a></li>',
						esc_attr($current),
						esc_url($url),
						esc_html($label)
					);
				}
				echo '</ul>';
			}
			?>
		</nav>
	</div>
</header>
