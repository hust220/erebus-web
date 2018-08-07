<?php
require('config/config.inc.php');
pagesetup(true);

if (empty($_SESSION['username'])){
    header("Location: login.php");
    die("");
}

if (empty($_SESSION['upload'])) {
    $_SESSION['save_qwidth'] = $defqwidth;
    $_SESSION['save_qminweight'] = $defqminweight;
    $_SESSION['save_symatoms'] = $defsymatoms;
}

?>

<html>
<head>
<?php echo $server_title; ?>
	<style type="text/css">
      <!--
        @import url(style/erebus.css);
      -->
    </style>
    <script src="style/js/utils.js" language="javascript" type="text/javascript"></script>
    <script src="style/js/efile.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">function onwload() { setbwidth(); inituplform(); document.getElementById("subTable").className="subTable"; } window.addEventListener("load", onwload, false); </script>
</head>

<body onload="deftaskname(true, true);">
<div id="main">
	<?php
	    include("head.php")
	?>
    <div id="content">
	<div id="leftColumn">
		<?php include("menu.php");?>
		<?php include("user.php");?>
	</div>
	<div id="middleColumn">
	    <div class="textcontent">

		<div class="indexTitle"> Submit a task </div>

		<div class="submitform" id="subqueryform">
		    <form name="querysub" enctype="multipart/form-data" action="upload.php" method="POST" onSubmit="return deftaskname(true,false);">
			<div class=subformblock>
			    <label for="taskname" class="formLabel" >1. Choose a name for your search:</label>
			    <input type=text name="taskname" id="taskname" class="subtext" maxlength=255 style="width:50%;" value="" /><br>
			    <span class=info>Provide a descriptive task name for your reference.<br><br>
			    The name must not be empty or consist of blanks. Otherwise, there are no restrictions:<br>
			    task name may contain any text and any symbols and needs not be specially formatted or even unique.</span>
			</div>
			<div class=subformblock>
			<label for="query" class=formLabel>2. Upload the query substructure:</label><img src="style/img/wait24trans.gif" class=formLabel id="uploadIndicator" style="visibility:hidden;">
			<input type=file name="filename" id="filename" class="subfile" style="margin-bottom:0;" accept="chemical/x-pdb" onchange="onsubquerychange(this);" /> <br>
			<span class=error id="subformerrorline">
		<?php
		if ($_SESSION['query_error'])
		    echo $_SESSION['query_error'];
		    $_SESSION['query_error']='';
		?></span><br>
			<textarea rows=6 cols=90 name="query" id="querytext" class="subtext" style="width:99%" wrap="off" onchange="onsubquerychange(this);"></textarea><br>
			<span class=info>Select a file to upload or paste the query structure as text in PDB format.<br><br>
			Note: your structure must not exceed <?php echo $max_query_atoms ?> atoms. </span>
			</div>
			<div class=subformblock>
			    <label class="formLabel" >3. Adjust parameters:</label>
			    <table class="hiddentab" id="subTable">
			    <thead>
				<tr class=subTitle>
				<th class=subTitle style="">Het/Atom<span class=info><h1>Het/Atom</h1>Shows type of atom record in your query structure. <br> Not changeable.</span></th>
				<th class=subTitle style="">Atom Id<span class=info><h1>Atom Id</h1>Shows atom index in your query structure. <br> Not changeable.</span></th>
				<th class=subTitle style="">Atom Name<span class=info><h1>Atom Name</h1>Shows atom name in your query structure. <br> Not changeable.</span></th>
				<th class=subTitle style="">Residue Id<span class=info><h1>Residue Id</h1>Shows residue index in your query structure. <br> Not changeable.</span></th>
				<th class=subTitle style="">Residue Name<span class=info><h1>Residue Id</h1>Shows residue name in your query structure. <br> Can be changed to one of the 20 natural aminoacids or to the special name <strong>ANY</strong>. See <a href=help.ph>Help</a> for more details on its meaning.</span></th>
				<th class=subTitle style="border-right:16px solid #e6e6e6;">Weight<span class=info><h1>Weight</h1>Shows relative weight of an atom in the query structure.<br>It is taken from the <em>Occupancy</em> column of PDB file. See <a href=help.ph>Help</a> for more details on its meaning.</span></th>
				</tr>
			    </thead> <tbody>
				<tr><td colspan=6>
				<div class="subScroll">
				    <table class="subTable subScroll"><thead class="subScroll"><tr> 
				    <th class="subTitle subScroll" >Het/Atom</th> 
				    <th class="subTitle subScroll" >Atom Id</th>
				    <th class="subTitle subScroll" >Atom Name</th> 
				    <th class="subTitle subScroll" >Residue Id</th> 
				    <th class="subTitle subScroll" >Residue Name</th>
				    <th class="subTitle subScroll" >Weight</th>
				    </tr></thead><tbody class=subScroll id="subInnerTableBody">
<!-- php include("table.php");-->
				    </tbody></table>
				</div>
				</td></tr></tbody>
			    </table>
			    <table class="subparamtable"><tbody>
			    <tr>
			    <td><label for="qwidth" class="formLabel" >Matching precision:</label><span class=info><?php  echo $docstrwidth; ?></span></td>
			    <td><input type=text name="qwidth" id="qwidth" class="subtext" style="width:5em;" <?php formval("qwidth") ?> /></td>

			    </tr><tr>

			    <td><label for="qminweight" class="formLabel">Minimum weight:</label><span class=info><?php  echo $docstrweight; ?></span></td>
			    <td><input type=text name="qminweight" id="qminweight" class="subtext" style="width:5em;" <?php formval("qminweight") ?> /></td>

			    </tr><tr>

			    <td><label for="symatoms" class="formLabel">Match symmetric atoms:</label><span class=info><?php  echo $docstrsymatoms; ?></span></td>
			    <td><input type="checkbox" name="symatoms" id="symatoms" class="subtext" value="1" <?php myformbtn("symatoms")?> /></td>
			    </tr><tr>
			    <td><label for="notifyCompleted" class="formLabel">Email notification:</label><span class=info><h1>Notification</h1>When enabled, Erabus will notify you by email about the task completion.</span></td>
			    <td><input type="checkbox" name="notifyCompleted" id="notifyCompleted" class="subtext" value="1" <?php myformbtn("notifyCompleted")?> /></td>
			    </tr></tbody></table>
			</div>
			<div class=subformblock>
			    <input type=hidden name="queryver" value="" id="queryver" />
			    <input type=hidden name="querymod" value="querymod" id="querymod" />
			    <input type=submit class="subbtn" onclick="queryformsubmit(this);" style="margin-bottom:0.5em;"/>
			</div>
			<iframe id="sub_upload_target" name="sub_upload_target" src="" style="width:0;height:0;border:0 solid #ff;visibility:hidden;" onload="javascript:uploadcomplete(this);"></iframe>
		    </form>
		</div>

	    </div>
	</div>

	<div id="rightColumn">
		<?php include("info.php");?>
	</div>
    </div>
</div>
</body>
</html>
