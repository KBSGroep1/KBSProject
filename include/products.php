<div class="products" id="pageProducts">
	<div id="productsContainer" class="paraContainer"><div class="blackLayerProducts"></div></div>
	<div class="textContainer paddingTopBottom30">
			<h1 class="titleAbout"><?php echo $texts["productTitle"]; ?></h1>
			<p class="bodyText">
				<?php echo $texts["productText"]; ?>
			</p>
	</div>
	<div class="textContainer2">
<?php
foreach($products as $product) {
?>
		<figure class="productCard">
			<div class="productInfoLayer visiblepanel" id="product<?= $product["productID"] ?>">
				<h2 class="productName"><?= $product["name"] ?></h2>
				<?= $product["description"] ?>
			</div>
			<img src="img/products/<?= $product["productID"] ?>-small.jpg" alt="<?= $product["name"] ?>" />
			<figcaption id="hoverProduct<?= $product["productID"] ?>">
				<div class="productText">
					<h3><?= $product["name"] ?></h3>
					<!-- TODO: what is 'black edition' ?? -->
					<p>Black edition <i class="fa fa-info-circle" aria-hidden="true"></i></p>
				</div>
				<div class="price">€<?= intval($product["price"]) / 100 ?></div>
			</figcaption>
		</figure>
<?php
}
?>
		<!-- TODO: why is this here? -->
		<div class="invisible">...</div>
	</div>
</div>
