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
  foreach ($productName as $id => $value) {
    print("<figure class='productCard'>
            <div class='productInfoLayer visiblepanel' id='product" . $id . "'>
              <h2 class='productName'>" . $productName[$id] . "</h2>
              " . $productDesc[$id] . "
            </div>
              <img src='img/products/" . $id . "-small.jpg' alt='product" . $id . "'/>
            <figcaption id='hoverProduct" . $id . "'>
              <div class='productText'>
                <h3>" . $productName[$id] . "</h3>
                <p>Black edition <i class='fa fa-info-circle' aria-hidden='true'></i></p>
              </div>
              <div class='price'>
                €" . $productPrice[$id] . "
              </div>
            </figcaption>
          </figure>");
  }
  ?>
      <div class="invisible">...</div>
  </div>
</div>
