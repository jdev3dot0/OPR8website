<?php
/**
 * Contact page body.
 */
?>
<div class="contact-grid">
	<div>
		<div class="contact-item">
			<img src="<?php echo esc_url(opr8_asset('images/icon-home.png')); ?>" alt="">
			<div>Leopold Luypaertstraat 208<br>1850 Grimbergen</div>
		</div>
		<div class="contact-item">
			<img src="<?php echo esc_url(opr8_asset('images/icon-phone.png')); ?>" alt="">
			<div>Mob: <a href="tel:+32479991561">0032479991561</a></div>
		</div>
		<div class="contact-item">
			<img src="<?php echo esc_url(opr8_asset('images/icon-email.png')); ?>" alt="">
			<div>Email: info @ opr8-it.be</div>
		</div>
		<div class="contact-item">
			<img src="<?php echo esc_url(opr8_asset('images/icon-euro.png')); ?>" alt="">
			<div>BTW nr: 0847.525.919</div>
		</div>
		<p>
			<a href="https://www.computerwinkel-info.be/bdr3184616-OPRIT.html"><u>OPR8-IT</u></a>
			is ook te vinden op
			<a href="https://www.computerwinkel-info.be">www.computerwinkel-info.be</a>.
		</p>
	</div>
	<div class="contact-form">
		<?php opr8_contact_notice(); ?>
		<form method="post" action="">
			<?php wp_nonce_field('opr8_contact', 'opr8_contact_nonce'); ?>
			<div class="field">
				<label for="opr8_name">Je naam (verplicht)</label>
				<input id="opr8_name" name="opr8_name" type="text" required>
			</div>
			<div class="field">
				<label for="opr8_email">Je e-mail (verplicht)</label>
				<input id="opr8_email" name="opr8_email" type="email" required>
			</div>
			<div class="field">
				<label for="opr8_subject">Onderwerp</label>
				<input id="opr8_subject" name="opr8_subject" type="text">
			</div>
			<div class="field">
				<label for="opr8_message">Je bericht</label>
				<textarea id="opr8_message" name="opr8_message" rows="6" required></textarea>
			</div>
			<button class="btn" type="submit">Verstuur</button>
		</form>
	</div>
</div>
<div class="map-embed">
	<iframe
		title="OPR8-IT locatie"
		loading="lazy"
		referrerpolicy="no-referrer-when-downgrade"
		src="https://maps.google.com/maps?q=Leopold%20Luypaertstraat%20208%201850%20Grimbergen&z=13&output=embed"
	></iframe>
</div>
