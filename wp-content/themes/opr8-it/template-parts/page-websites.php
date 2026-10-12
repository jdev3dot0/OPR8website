<?php
/**
 * Websites portfolio.
 */
$sites = [
	['www.denderstreekzuid.com', 'Custom developed CMS in PHP'],
	['www.europeanpainfederation.eu', 'WordPress-based CMS including training & administrative handover to site owner'],
	['www.generationcelta.be', 'WordPress-based CMS including training & administrative handover to site owner'],
	['www.dcphotography.be', 'WordPress-based CMS including training & administrative handover to site owner'],
	['www.lob-mechelenlogopedie.com', 'WordPress-based CMS including training & administrative handover to site owner'],
	['www.nygelverhaeren.be', 'WordPress-based CMS including training & administrative handover to site owner'],
];
?>
<div class="content-wrap">
	<p>Sites developed by OPR8-IT</p>
	<ul class="portfolio-list">
		<?php foreach ($sites as [$host, $note]) : ?>
			<li>
				<a href="<?php echo esc_url('https://' . $host); ?>" target="_blank" rel="noopener"><?php echo esc_html($host); ?></a>
				<span><?php echo esc_html($note); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
