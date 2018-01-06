<div class="products" id="pageProducts">
	<div id="productsContainer" class="paraContainer">
		<div class="blackLayerProducts"></div>
	</div>
	<div class="textContainer paddingTopBottom30">
		<h1 class="titleAbout"<?= cEditable("productTitle") ?>><?= $texts["productTitle"] ?></h1>
		<p class="bodyText" <?= cEditable("productText") ?>><?php echo $texts["productText"]; ?></p>
	</div>
	<div class="textContainer2">
<?php
if($editing !== true) { // $editing might not exist
	foreach($products as $product) {
?>
		<figure class="productCard">
			<div class="productInfoLayer visiblepanel" id="product<?= $product["productID"] ?>">
				<h2 class="productName"><?= $product["name"] ?></h2>
				<?= $product["description"] ?>
			</div>
			<a class="popup" href="img/products/<?= $product["productID"] ?>-large.jpg" >
				<img src="img/products/<?= $product["productID"] ?>-small.jpg" alt="<?= $product["name"] ?>" />
			</a>
			<figcaption id="hoverProduct<?= $product["productID"] ?>">
				<div class="productText">
					<h3><?= $product["name"] ?></h3>
					<p><?= $product["subInfo"] ?> <i class="fa fa-info-circle" aria-hidden="true"></i></p>
				</div>
<?php
		$price = intval($product["price"]) / 100;
		echo "<div class=\"price\">€ ";
		echo is_float($price) ? str_replace('.', ',', $price) : $price . ",-";
		echo "</div>";
		echo "</figcaption></figure>";
	}
?>
		<!-- dont remove this -->
		<div class="invisible">...</div>
<?php
}
?>

	</div>
</div>
