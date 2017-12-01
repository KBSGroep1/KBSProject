<nav class="navbar navbar-default sidebar" role="navigation">
	<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
		<ul class="nav navbar-nav">
		<li <?php if (fnmatch("*roduct*", $_SERVER["PHP_SELF"])) { print("class='active'"); } ?>><a href="products.php">Producten</a></li>   
		<li <?php if (fnmatch("*ite*", $_SERVER["PHP_SELF"])) { print("class='active'"); } ?>><a href="sites.php">Website</a></li>		     
		<li <?php if (fnmatch("*ser*", $_SERVER["PHP_SELF"])) { print("class='active'");} if ($_SESSION["userRole"] < 3){ print("class='disabled'");}?>> <a <?php if($_SESSION["userRole"] < 3){
		}else{
			print("href='users.php'");
		}
		 ?>>Gebruikers</a></li>
		<li <?php if (fnmatch("*essage*", $_SERVER["PHP_SELF"])) { print("class='active'");} if ($_SESSION["userRole"] < 2){ print("class='disabled'");}?>> <a <?php if($_SESSION["userRole"] < 2){
		}else{
			print("href='messages.php'");
		}
		 ?>>Berichten</a></li> 
		</ul>
	</div>
	</div>
</nav>