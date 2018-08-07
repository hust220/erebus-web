<?php
require('config/config.inc.php');
pagesetup(false);
#	if (empty( $_SESSION['username']) ){
#		header("Location: login.php");
#	}
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
    <script language="javascript" type="text/javascript">function onwload() { setbwidth(); } window.addEventListener("load", onwload, false); </script>
</head>

<body>
<div id="main">
	<?php include("head.php"); ?>
	<div id="leftColumn">
	<?php include("menu.php"); ?>
	<?php include("user.php"); ?>
	</div>

	<div id="middleColumn" class="loginpage" >
		<div class="textcontent">

		<div class="indexTitle"> The Erebus server. </div>

		<h2>Introduction</h2>
		<strong>Erebus</strong>, which takes the name of omnipresent Greek god of darkness and shadow, is a protein substructure search server.
		<strong>Erebus</strong> server searches the entire PDB database for a match to a query structure, defined by a small group of atoms
		(current limit for query structure is <?php echo $max_query_atoms ?> atoms). The distinct features of <strong>Erebus</strong> are:
		<ul>
		<li> Speed. <br> Scanning of the entire PDB dataset takes about 1 hour and only weakly varies with query structure size.
		<li> Versatility. <br> Query structure may include any atoms in any sequence, and atoms do not have to make up complete residues.
		</ul>
		
		<h2>Usage</h2>
		<h3>Preparing query structure</h3>
		<strong>Erebus</strong> accepts as input list of atomic coordinates in standard format of Protein Data Bank.
		<strong>Erebus</strong> will read the following fields from the supplied PDB input:
		<ul>
		<li><var>Record type.</var><br>
		    <strong>Erebus</strong> reads <dfn>ATOM</dfn> and <dfn>HETATM</dfn> records for atom coordinates.
		    Additionally (and only in the target PDB entries) <strong>Erebus</strong> recognizes <dfn>MODEL</dfn> and <dfn>ENDMDL</dfn>
		    records used to indicate the presence of multiple models for a given PDB entry. Every model
		    is matched independently and model number will be shown later in the list of matches.
		<li><var>Atom index.</var><br>
		    <strong>Erebus</strong> reads atom index and stores it for future output to maintain atom order.
		    Otherwise, atom index is not used during the search.
		<li><var>Atom name.</var><br>
		<strong>Erebus</strong> uses atom names to search a matching substructure in a target protein.
		<strong>Erebus</strong> requires that atoms in a target substructure have
		names exactly matching atom names in the query structure. Note, that comparison is <em>case-sensitive</em>
		and atom names in PDB entries are given in capital case. There are two exceptions to the
		exact matching rule:
		<ol style="padding-left:2em;">
		<li>Atoms having names that begin with "<dfn>H</dfn>" (hydrogen atoms) are ignored during the search. 
		<li>Atoms that are chemically equivalent, but have different names according to standard nomenclature
		    (<dfn>symmetric atoms</dfn>) can be treated by <strong>Erebus</strong> as equivalent atoms, if requested.
		</ol>
		<li><var>Residue name.</var><br>
		<strong>Erebus</strong> reads and matches residue names similarly to atom names.
		Additionally, <strong>Erebus</strong> allows a special residue name - "<dfn>ANY</dfn>",
		which matches any other residue. This residue wild-card must be used with care, as
		it makes search less specific, and may increase number of matches beyond the current limit of 400.
		<li><var>Residue index.</var><br>
		<strong>Erebus</strong> uses residue index to distinguish atoms belonging to different residues,
		even when these residues are chemically identical aminoacids. Otherwise, <strong>Erebus</strong>
		does not impose any other residue-index-based constraints during the search.
		<li><var>Atomic coordinates.</var><br>
		<strong>Erebus</strong> uses atomic coordinates to compute pairwise distances between the atoms.
		Only these pairwise distances are used in the following search process. The angular component of
		atom positions is thus discarded, and <strong>Erebus</strong> will find a substructure matching the
		query even if the former is rotated relative to the latter in absolute Carthesian coordinates.
		<li><var>Occupancy</var><br>
		<strong>Erebus</strong> uses occupancy column to read assign relative weights to atoms.
		These weights are used when atoms are missing from the matched structure in order to
		adjust weight of the match. If the relative weight of atom is 0 it is effectively excluded
		from consideration.
		</ul>

		<h3>Submitting search tasks</h3>
		To begin a search <strong>Erebus</strong> needs the following information:
		<ol>
		<li><var>Task name.</var><br>
		Task name can be any text that may help you identify this particular search.
		It will be used to display your task in the queue or results tables.<br>
		Task name can not be left empty. By default, it will be composed from the current date and time.
		<li><var>Query structure</var><br>
		You may upload a file or copy and paste a text in PDB format, as described in the previous section.
		After preliminary parsing atoms will be listed in the table below.
		<li><var>Adjust parameters</var><br>
		The atoms from your query structure will be shown here, giving you
		an opportunity to adjust residue names and/or atom weights.<br>
		Additional parameters include:
		<ul style="padding-left:2em;">
		<li>Matching precision &sigma;.<br>
		This parameter determines how closely should a protein substructure
		match a query structure. When <strong>Erebus</strong> finds that two atoms in a protein are separated by a
		distance that is different from the corresponding distance in the query, <strong>Erebus</strong> assigns weight W<sub>i</sub> &lt; 1.0 to such a match.
		The weight of such a match is computed as <br><br> W<sub>i</sub> = exp[-(&Delta; r / &sigma;)<sup>2</sup>]<br><br> where &Delta; r is
		the difference between matching atom pair separations in a PDB structure and in the query structure.
		<br>Thus, the smaller is &sigma;, the higher is matching precision.
		<li>Weight threshold <em>W</em><br>
		This is the minimum weight of the matching protein substructure
		accepted by <strong>Erebus</strong>. <br> The weight of the substructure consisting of <em>N</em> pairs is defined as <br><br>
		W = <big>&Sigma;</big><sub>i=1,<em>N</em></sub> W<sub>i</sub> <br><br> where W<sub>i</sub> is weight of a matching atom pair.
		Matching substructures having weight below <em>W</em> are not reported in the results table.
		</ul>
		</ol>
		<h3>Results</h3>
		For every found matching substructure <strong>Erebus</strong> reports
		list of atoms along with their corresponding residues. Matching accuracy is
		expressed both as a match weight <em>W</em> and as a root-mean-square distance
		between substructure atoms and corresponding query atoms. Currently,
		<strong>Erebus</strong> can export results in the following formats:
		<ul>
		<li>PyMOL script.<br>
		This script can be used as input to th PyMOL visualization software.
		The generated commands will load the corresponding target protein and query structure,
		visibly mark matched atoms and residues and zoom onto the found substructure.
		<li>Ascii text.<br>
		This plain text file lists indexes of atoms and residues of matching substructure along
		with the coordinates of query structure atoms spatially fitted to the atoms of matched substructure.
		</ul>
		<h3>Erebus algorithm</h3>
		</div>
	</div>
	
	<div id="rightColumn">
		<?php include("info.php");?>
	</div>
</div>
</body>
</html>
