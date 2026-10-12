<?php
/**
 * Default page template.
 */
get_header();

$slug = get_post_field('post_name', get_queried_object_id());
$parts = [
	'contact'        => 'contact',
	'wie-is-opr8-it' => 'about',
	'websites'       => 'websites',
	'opr8-it-drones' => 'drones',
	'opr8-it-zeilen' => 'zeilen',
];
?>
<main id="main">
	<div class="page-hero">
		<div class="container">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
	<div class="container entry-content">
		<?php
		if (isset($parts[$slug])) {
			get_template_part('template-parts/page', $parts[$slug]);
		} else {
			while (have_posts()) :
				the_post();
				echo '<div class="content-wrap">';
				the_content();
				echo '</div>';
			endwhile;
		}
		?>
	</div>
</main>
<?php
get_footer();
