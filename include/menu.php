<div class="fixedContentContainer">
    <nav>
        <div class="navGradiant" id="navId">
            <div id="hamburgermenu" class="hamburgerMenu"><i class="fa fa-bars hamburger"></i></div>
            <div id="navAbfix" class="navAbfix">
            <div id="navOverflow" class="navOverflow">
                <div class="navPadding">
                    <div class="navContainer clearfix">
                        <ul class="clearfix">
                            <li>
                                <a title="Brand" href="#pageBrand" <?= cEditable("menuBrand", true) ?>><?php echo $texts["menuBrand"]; ?></a>
                            </li>
                            <li>
                                <a title="About Us" href="#pageAbout" <?= cEditable("menuAbout", true) ?>><?php echo $texts["menuAbout"]; ?></a>
                            </li>
                            <li>
                                <a title="The product" href="#pageProducts" <?= cEditable("menuProducts", true) ?>><?php echo $texts["menuProducts"]; ?></a>
                            </li>
                            <li>
                                <a title="Contact Us" href="#pageContact" <?= cEditable("menuContact", true) ?>><?php echo $texts["menuContact"]; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
          </div>
            <div id="logoContainer" class="logoContainer">
                <img alt="logo" src="img/logo/1-largeLogo.svg">
            </div>
        </div>
    </nav>
</div>
