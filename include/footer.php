<div class="detailsBackground" id="pageContact">
	<div class="contactDetail paddingTop100 paddingBottom70">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="contact">
						<h3 class="marginBottom50"<?= cEditable("footerLeftTitle") ?>><?= $texts["footerLeftTitle"] ?></h3>
						<p <?= cEditable("footerLeftText") ?>><?= $texts["footerLeftText"] ?></p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php /* the form only submits if we aren't editing, otherwise the <button contenteditable> wouldnt work */ ?>
					<?= !$editing ? "<form method=\"POST\" action=\"submitContact.php\">" : "" ?>
						<div class="contact">
							<h3 class="marginBottom50"<?= cEditable("contactTitle") ?>><?php echo $texts["contactTitle"]; ?></h3>
<?php
if(isset($_SESSION["contactError"]) && !empty($_SESSION["contactError"])) {
	// TODO: this currenlty uses inline styling, please fix
	echo "<div id='contactError' style='color: white; padding: 6px; font-weight: bold; margin-bottom: 8px; background-color: red'>" . $_SESSION["contactError"] . "</div>";
	$_SESSION["contactError"] = null;
}
?>
							<input type="text" name="fullname" <?= $editing ? "disabled" : "required" ?> placeholder="Name" />
							<input type="email" name="email" <?= $editing ? "disabled" : "required" ?> placeholder="Email" />
							<textarea placeholder="Message" name="message" <?= $editing ? "disabled" : "required" ?> rows="6"></textarea>
							<button type="submit" class="sendButton buttonColor marginBottom30"<?= cEditable("contactSendButton", true) ?>><?php echo $texts["contactSendButton"]; ?></button>
						</div>
					<?= $editing ? "" : "</form>" ?>
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="contact">
						<h3 class="marginBottom50"<?= cEditable("footerRightTitle") ?>><?php echo $texts["footerRightTitle"]; ?></h3>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="row">
							<div class="contactIcon">
								<i class="fa fa-phone" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 marginTop12px">
						<div class="contactIcon marginBottom20">
							<a class="textCollorEmail" href="tel:<?= $texts["contactPhone"] ?>" <?= cEditable("contactPhone", true) ?>><?= $texts["contactPhone"] ?></a>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<div class="row">
							<div class="contactIcon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
						</div>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-10 marginTop12px">
						<div class="contactIcon marginBottom20">
							<a class="textCollorEmail" href="mailto:<?=$texts['contactEmail'] ?>"<?= cEditable("contactEmail", true) ?>><?= $texts["contactEmail"] ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
