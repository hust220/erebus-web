		<div class="navimain">
		    <?php if(empty($_SESSION['username'])): ?>
			<div class='navi'><a href="login.php" class="navlink" id=linklogin> Login </a><span class=info>Go to Log in page.</span></div>
		    <?php else: ?>
			<div class='navi'><a href="index.php" class="navlink" id=linkhome> Home/Overview </a><span class=info>Go to main page that lists your most recent submitted and finished tasks.</span></div>
			<div class='navi'><a href="submit.php" class="navlink" id=linksubmit> Submit a Task </a><span class=info>Submit new searching task.</span></div>
			<div class='navi'><a href="query.php" class="navlink" id=linkresults> Results </a><span class=info>Access all of your previous search results.</span></div>
			<div class='navi'><a href="profile.php" class="navlink" id=linkprofile> User Profile </a><span class=info>View or modify your login credentials and profile information.</span></div>
		    <?php endif ?>
			<div class='navi'><a href="help.php" class="navlink" id=linkinfo> Help </a><span class=info>Read Erebus documentation</span></div>
			<div class='navi'><a href="contact.php" class="navlink" id=linkcontact> Contact Us</a><span class=info>Contact us</span></div>

		    <?php if(!empty($_SESSION['username'])): ?>
			<div class='navi' id="sep">&nbsp;</div>
			<div class='navi'><a href="logout.php" class="navlink" id=linklogout> Log out </a><span class=info>End the current Erebus session.</span></div>
		    <?php endif ?>
			<?php
			if ($_SESSION['level'] >= 3) { # administration menu
			?>
			<div class='navi'><a href="useradmin.php" class="navlink"> <font color='red'> User Admin </font></a></div>
			<div class='navi'><a href="jobadmin.php" class="navlink"> <font color='red'> Job Admin </font></a></div>
			<div class='navi'><a href="pdbadmin.php" class="navlink"> <font color='red'>PDB Admin </font></a></div>
			<?php
			}
			?>
		</div>
