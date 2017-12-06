<div class="detailsBackground" id="pageContact">
	<div class="contactDetail paddingTop100 paddingBottom70">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="contact">
						<h3 class="marginBottom50"><?php echo $texts["footerLeftTitle"]; ?></h3>
						<p><?php echo $texts["footerLeftText"]; ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<form method="POST" action="submitContact.php">
						<div class="contact">
							<h3 class="marginBottom50"><?php echo $texts["contactTitle"]; ?></h3>
<?php
if(isset($_SESSION["contactError"]) && !empty($_SESSION["contactError"])) {
	// TODO: this currenlty uses inline styling, please fix
	echo "<div id='contactError' style='color: white; padding: 6px; font-weight: bold; margin-bottom: 8px; background-color: red'>" . $_SESSION["contactError"] . "</div>";
	$_SESSION["contactError"] = null;
}
?>
							<input type="text" name="fullname" required placeholder="Name">
							<input type="email" name="email" placeholder="Email">
							<textarea placeholder="Message" name="message" required rows="6"></textarea>
							<button type="submit" class="sendButton buttonColor marginBottom30"><?php echo $texts["contactSendButton"]; ?></button>
						</div>
					</form>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="contact">
						<h3 class="marginBottom50"><?php echo $texts["footerRightTitle"]; ?></h3>
						<p><?php echo $texts["footerRightTitle"]; ?></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="row">
							<div class="contactIcon">
								<i class="fa fa-map-marker" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10">
						<div class="contactIcon marginBottom20">
							<a class="textCollorEmail" href="https://www.google.nl/maps/place/Wilpe.com/@52.5615758,6.6335481,18.3z/data=!4m13!1m7!3m6!1s0x47c801d363d5e99f:0x5457d1bcfc1f438a!2sHandelsstraat+52,+7772+TR+Hardenberg!3b1!8m2!3d52.5616499!4d6.63382!3m4!1s0x47c8002cf076d953:0xa6e2b551ce17671c!8m2!3d52.5616499!4d6.63382" target="_blank" ><?php echo $texts["contactLocation"]; ?></a>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="row">
							<div class="contactIcon">
								<i class="fa fa-phone" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10">
						<div class="contactIcon marginBottom20">
							<a class="textCollorEmail" href="tel:+0637119910"><?php echo $texts["contactPhone"]; ?></a>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="row">
							<div class="contactIcon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10">
						<div class="contactIcon marginBottom20">
							<a class="textCollorEmail" href="mailto:<?php print($texts['contactEmail']);?>" ><?php echo $texts["contactEmail"]; ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
