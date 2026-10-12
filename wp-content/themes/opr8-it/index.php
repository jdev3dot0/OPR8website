<?php
/**
 * Fallback index.
 */
get_header();
?>
<main id="main">
	<?php if (have_posts()) : ?>
		<div class="page-hero"><div class="container"><h1><?php echo esc_html(get_the_title()); ?></h1></div></div>
		<div class="container entry-content">
			<?php
			while (have_posts()) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	<?php else : ?>
		<div class="container entry-content"><p>Geen inhoud gevonden.</p></div>
	<?php endif; ?>
</main>
<?php
get_footer();
