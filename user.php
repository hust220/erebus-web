<?php if(!empty($_SESSION['username'])): ?>
<?php if((int)$_SESSION['level'] < 1 && !empty($_SESSION['guestlink']) ): ?>
	<div class="navimain">
	    <div class="warning" style="text-align:center;">
		<h1>Guest login</h1>
	    </div>
	    <div style="padding-bottom:1em;">
		    In order to access data after your current session ends, please copy and save <a href=<?php  echo '"' . $_SESSION['guestlink'] . '"' ?> >this link</a>:
	    </div>
		<textarea readonly="readonly" rows=5><?php  echo $_SESSION['guestlink'] ?></textarea>
	    <div style="padding-bottom:1em;">
		Paste this link in your browser to access your data.<br>
	    </div>
		<strong>Note:</strong> Guest sessions and all related data are stored for <?php  echo $guesttimeout ?> hours.
	</div>
<?php else: ?>
	<div class="navimain">
	    <div style="padding-bottom:1em;">
		    Logged in as: <strong> <?php echo $_SESSION['username'];?></strong><span class=info>You are currently logged in as <strong> <?php echo $_SESSION['username'];?></strong>. <br><br> Click the <a href=logout.php>Log out</a> link in left column menu to end your session.</span>
	    </div>
	</div>
<?php endif ?>
<?php endif ?>
<div class="navimain">
    <h3 style="color:green;">Update</h3><hr><br>
    <div style="padding-bottom:1em;">
	Erebus server has <strong>resumed</strong> its function after the problems with the main storage node have been resolved.
<br>
	Jobs can be submitted and will be run normally.
<br>
	PDB database was updated and is now synchronized with RCSB servers.
<br>
	Thank you for your patience.
    </div>
</div>
