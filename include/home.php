<div class="home" id="pageBrand">
	<div id="homeContainer" class="paraContainer"></div>
	<div class="homeContent">
		<div class="contentCentered floatRight">
			<div id="pageEndLogo" class="pageEndLogo"></div>
			<div class="introText" <?= cEditable("largeTitle") ?>>
				<?php echo $texts["largeTitle"]; ?>
			</div>
			<a <?= !$editing ? "href=\"#pageProducts\"" : "" ?>><div class="discoverButton buttonColor" <?= cEditable("scrollDownButton") ?>><?php echo $texts["scrollDownButton"]; ?></div></a>
		</div>
		<div class="containerArrow">
			<a href="#pageAbout">
				<div class="downArrow">
					<i class="fa fa-angle-down" aria-hidden="true"></i>
				</div>
			</a>
		</div>
	</div>
	<div class="blackLayer"></div>
</div>
