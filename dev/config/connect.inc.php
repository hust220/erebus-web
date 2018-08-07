<?php
function sql_connect()
{
global $dbusername,$dbpassword,$database;
mysql_connect(localhost,$dbusername,$dbpassword);
mysql_select_db($database) or die( "Unable to select database " . $database);
}

$docstrwidth='<h1>Matching precision</h1>When <strong>Erebus</strong> finds that two atoms in a protein are separated by a ' .
		'distance that is different from the corresponding distance in the query, <strong>Erebus</strong> assigns weight W<sub>i</sub> &lt; 1.0 to such a match. ' .
		'The weight of such a match is computed as <br><br> W<sub>i</sub> = exp[-(&Delta; r / &sigma;)<sup>2</sup>]<br><br> where &Delta; r is ' .
		'the difference between matching atom pair separations in a PDB structure and in the query structure. ' .
		'<br>Thus, the smaller is &sigma;, the higher is matching precision.';

$docstrweight='<h1>Weight threshold</h1>This is the minimum weight of the matching protein substructure ' .
	    'accepted by <strong>Erebus</strong>. <br> The weight of the substructure consisting of <em>N</em> pairs is defined as <br><br>' .
	    ' W = <big>&Sigma;</big><sub>i=1,<em>N</em></sub> W<sub>i</sub> <br><br> where W<sub>i</sub> is weight of a matching atom pair.';

$docstrsymatoms='<h1>Symmetric atoms are equivalent</h1>When this parameter is enabled, <strong>Erebus</strong> '.
	    'will treat certain groups of symmetric atoms as equivalent atoms. Examples include: <br><br> CG1/CG2 in Valin <br><br>'.
	    'OD1/OD2 in Aspartic acid <br><br> NH1/NH2 in Arginine.';

$docstrtaskctrl='<table border=0><tr><td valign=top><img src="style/img/delete.png"></td><td style="padding:0 0 1em 0.7em;">Click this cross to permanently delete your task.'.
	    '<p><strong>Note:</strong> for performance reasons no warning will be issued before deleting data.</td></tr>' .
	    '<tr><td valign=top><img src="style/img/wait16trans.gif"></td><td style="padding:0 0 1em 0.7em;">This task is currently being processed. The matching structures discovered so far are available for viewing.</td></tr></table>';

function table_header($idx)
{
    global $docstrwidth, $docstrweight, $docstrsymatoms, $docstrtaskctrl;
    return '<tr class="queryTitle">
	<th class="queryTitle">Name<span class=info><h1>Task Name</h1>This column shows names of your search tasks. <br class=space>These names were provided by you when submitting the task.</span></th>
	<th class="queryTitle">' . (($idx == 0) ? "Submitted" : "Completed" ) . '<span class=info><h1>' . (($idx == 0) ? "Submission" : "Completion" ) . ' time</h1>This column shows the time when' . (($idx == 0) ? "you submitted the search task." : "this search task has finished.") . '.</span></th>
	<th class="queryTitle">Atoms<span class=info><h1>Number of atoms</h1>This is the total number of ATOM and HETATM records in your query structure.</span></th>
	<th class="queryTitle">&nbsp;&sigma;&nbsp;<span class=info>' . $docstrwidth .'</span></th> 
	<th class="queryTitle">W<sub>min</sub><span class=info>' . $docstrweight . '</span></th> 
	<th class="queryTitle">&nbsp;S.A.&nbsp;<span class=info>' . $docstrsymatoms . '</span></th>' .

	(($idx == 0) ? '<th class="queryTitle">Queue<span class=info><h1>Queue rank</h1>This column shows the position of this task in the queue. Rank <strong>1</strong> means '.
	    'that this task is scheduled to be run next.</span></th>' : 
		    '<th class="queryTitle">Results<span class=info><h1>Search results</h1>' .
		    'This column shows the overall number of matches found for your query. Click <a href="query.php">Results</a> in the menu on the left to see ' .
	    'the detailed list of matches and to download the results.</span></th>') .

	'<th class="queryTitle unsortable">Control<span class=info><h1>Task control</h1>' . $docstrtaskctrl . '</span></th>
	</tr>';
}

function myshowsubmitted($query,$page,$nlimit,$url){

	$result = mysql_query($query);
	$nrow = mysql_num_rows($result);

	$offset = $page*$nlimit;
#	$query.="LIMIT $offset,$nlimit";
#	$result = mysql_query($query);
	$tableheader = '<table class="queryTable sortable" id="tsub"><tbody id="tbodytag">' . table_header(0);
	echo "$tableheader";
	while ( $row = mysql_fetch_array($result)){

		$taskid	  = $row['taskid'];
		$taskname = $row['taskname'];
		$tasktime = $row['tsubmit'];
		$qsize = preg_match_all( "/^(ATOM  |HETATM)/m", $row['query'], $out);// + preg_match_all( "/^HETATM/m", $row['query'], $out);
#		$params = preg_replace(array('/-w/', '/-z/', '/-y/'), array('<br>Dev. weight', '<br>Min. weight', '<br>symmetric atoms'), $row['options']);
#		$params = preg_replace('/^<br>/', ' ', $params);
		$w = $row['w'];
		$z = $row['z'];
		if (is_null($z)) ($qsize == 0) ? 0 : $z = 1.0 / ($qsize * ($qsize - 1));
		$sa = $row['symatoms'];
		if ($sa == 0) $sa = 'No'; else $sa = 'Yes';
		$qrank = $row['qrank'];
		if ($qrank <= 0) { $qrank = 'Running'; }

#		$message = $row['message'];
		$href = "javascript:delentry(\"$taskid\")";
		$str = "<a href='$href'> <img src='style/img/delete.png' title='delete this entry' border='0px'> </a>";
		$zstr = sprintf("%.3g", $z);
		
		echo "<tr id='entrytag$taskid'>";
		echo "<td class=queryBody>$taskname</td>";
		echo "<td class=queryBody>$tasktime</td>";
		echo "<td class=queryBody>$qsize</td>";
		echo "<td class=queryBody>$w</td>";
		echo "<td class=queryBody>$zstr</td>";
		echo "<td class=queryBody>$sa</td>";
		echo "<td class=queryBody> $qrank </td>";
		echo "<td class=queryBody> $str </td>";
		echo "</tr>";
	}

	echo "</tbody></table>";
	return $nrow;
}

function myshowcompleted($query,$page,$nlimit,$url){

	$result = mysql_query($query);
	$nrow = mysql_num_rows($result);

	$offset = $page*$nlimit;
	$query.="LIMIT $offset,$nlimit";
#	$result = mysql_query($query);
	$tableheader = '<table class="queryTable sortable" id="tsub"><tbody id="tbodytag">' . table_header(1);
	
	echo "$tableheader";
	$nrunning=0;
	$progupdstr="";
	while ( $row = mysql_fetch_array($result)){

		$taskid	  = $row['taskid'];
		$taskname = $row['taskname'];
		$tcomplete = $row['tcomplete'];
		$tsubmit = $row['tsubmit'];
		$qsize = preg_match_all( "/^(ATOM  |HETATM)/m", $row['query'], $out);// + preg_match_all( "/^HETATM/m", $row['query'], $out);
		$w = $row['w'];
		$z = $row['z'];
		if (is_null($z)) $z = 1.0 / ($qsize * ($qsize - 1));
		$sa = $row['symatoms'];
		if ($sa == 0) $sa = 'No'; else $sa = 'Yes';
		$stats = $row['stats'];
		$brief = $row['brief'];

		if (is_null($stats)) { // still running
		    $brief = $brief . "% complete";
		    $tcomplete = "<em>" . $tcomplete . "</em>";
		    $str="";
		    $str = "<img src='style/img/wait16trans.gif' title='this task is running now' border='0px'>";
		    $nrunning+=1;
		    $progupdstr = $progupdstr . "updateprogress(\\\"$taskid\\\"); ";
		    $briefid="id=\"bid$taskid\"";
		} else {
		    $brief = $brief . " matches";
		    $href = "javascript:delentry(\"$taskid\")";
		    $str = "<a href='$href'> <img src='style/img/delete.png' title='delete this entry' border='0px'> </a>";
		    $briefid="";
		}

#		$message = $row['message'];
		$str2 =  "onClick=\"javascript:location.href='query.php?taskid=$taskid';\"";
		$zstr = sprintf("%.3g", $z);

		echo "<tr class=\"qCompleted\" id='entrytag$taskid'>";
		echo "<td class=\"queryBody\"><a href=\"javascript:location.href='query.php?taskid=$taskid';\">$taskname</a></td>";
#		echo "<td class=\"queryBody qCompleted\">$tsubmit</td>";
		echo "<td class=\"queryBody\" $str2>$tcomplete</td>";
		echo "<td class=\"queryBody\" $str2>$qsize</td>";
		echo "<td class=\"queryBody\" $str2>$w</td>";
		echo "<td class=\"queryBody\" $str2>$zstr</td>";
		echo "<td class=\"queryBody\" $str2>$sa</td>";
		echo "<td class=\"queryBody\" $str2$briefid>$brief</td>";
		echo "<td class=\"queryBody qActionCol\"> $str </td>";
		echo "</tr>\n";
	}

	echo "</tbody></table>";
	if ($nrunning > 0) {
	    echo "\n<script type=\"text/javascript\">setInterval(\"". $progupdstr . "\",60000);</script>\n";
	}
	return $nrow - $nrunning;
}

function myshowresults($query,$page,$nlimit,$url)
{
    $result = mysql_query($query);
    $nrow = mysql_num_rows($result);
    $offset = $page*$nlimit;
    $query.="LIMIT $offset,$nlimit";
#	$result = mysql_query($query);


    $tableheaderfmt = '<table class="%1$s">
    <thead class="%2$s">
	
    <tr class="%3$s">
    <th class="%3$s">PDB Id</th>
    <th class="%3$s">MDL</th>
    <th class="%3$s">Atoms</th>
    <th class="%3$s">Residues</th>
    <th class="%3$s">&nbsp;&nbsp;&nbsp;Weight&nbsp;&nbsp;&nbsp;</th>
    <th class="%3$s">&nbsp;&nbsp;&nbsp;RMSD&nbsp;&nbsp;&nbsp;</th>
    <th class="%3$s"%4$s>Download&nbsp;&nbsp;&nbsp;&nbsp;</th>
    </tr></thead><tbody>';

    if ($nrow > 20) $astyle = "style=\"border-right:16px solid #e6e6e6;\"";

    $tableheader = sprintf($tableheaderfmt, "reslistTable", "queryTitle", "queryTitle", $astyle);

    echo "$tableheader";
    if ($nrow > 20) {
	echo "<tr><td colspan=7><div class=subscrollbig>";
	echo sprintf($tableheaderfmt, "reslistTable subScroll", "subScroll", "queryTitle subScroll", "");
    }
    while ( $row = mysql_fetch_array($result)){

	$taskid	  = $row['taskid'];
	$pdbid = $row['ct'];
	$pdbid = basename($pdbid);
	$pdbid = strtoupper(substr($pdbid, 3, 4));
	$mdl = $row['cm'];
	$nr = preg_match_all( "/\d+/", $row['clr'], $out);
	$na = preg_match_all( "/\d+/", $row['cla'], $out);
	$wt = $row['cwt'];
	$rmsd = $row['crmsd'];
	$resid = $row['resid'];
	$wtstr = sprintf("%.3g", $wt);
	$rmsdstr = sprintf("%.3g", $rmsd);

	echo "<tr>";
	echo "<td class=queryBody><a href=\"http://www.pdb.org/pdb/explore/explore.do?structureId=$pdbid\">$pdbid</a></td>";
	echo "<td class=queryBody>$mdl</td>";
	echo "<td class=queryBody>$na</td>";
	echo "<td class=queryBody>$nr</td>";
	echo "<td class=queryBody style=\"text-align:left;\">$wtstr</td>";
	echo "<td class=queryBody style=\"text-align:left;\">$rmsdstr</td>";
	$href1 = "download.php?resid=$taskid@$pdbid@$resid&fmt=pml";
	$href2 = "download.php?resid=$taskid@$pdbid@$resid&fmt=txt";
#	$str = "<a href=\"$href\"> <img src='style/img/download.gif' title='download this entry' border='0px'> </a>";
	$pymolstr="<span class=pm1>Py</span><span class=pm2>MOL</span>";
	$str1 = "<a href=\"$href1\" title=\"PyMOL format\">$pymolstr<span class=info>#pymolstr</span></a>";
	$str2 = "<a href=\"$href2\" title=\"Text format\">TXT<span class=info>#pltextstr</span></a>";
	echo "<td class=queryBody>$str1 $str2</td>";
	echo "</tr>\n";

    }
    echo "</tbody></table>\n";
    if ($nrow > 20) {
	echo "</div></td></tr></tbody></table>\n";
    }
    echo "<span class=hidden id=pymolstr>Click to download results as a $pymolstr script.</span>" . 
	"<span class=hidden id=pltextstr>Click to download results in plain text format.</span>";
    return $nrow;
}

function prepare_pdb($query, $maxatoms, &$result)
{

    $qsize = preg_match_all( "/^(ATOM  |HETATM).*/m", $query, $out1);
#     + preg_match_all( "/^HETATM.*/m", $query, $out2);
    if ($qsize > $maxatoms) {
	$result = sprintf("Too many atoms. Limit is %d atoms.", $maxatoms);
	return 0;
    } 
    if ($qsize < 3) {
	$result = sprintf("At least 3 atoms are required, %d atoms provided (%d).", $qsize, strlen($query));
	return 0;
    }

    $result = implode("\n", $out1[0]);//array_merge($out1[0], $out2[0]));

    return 1;
}

function parse_pdb($pdb, &$result)
{
    $pdba = explode("\n", $pdb);
    $result = array();

    foreach ($pdba as $line) {
	$astr = trim(substr($line, 0, 6));
	$aid = trim(substr($line, 6, 5));
	$aname = trim(substr($line, 12, 4));
	$rid = trim(substr($line, 22, 5));
	$rname = trim(substr($line, 17, 3));
	$awt = trim(substr($line, 54, 3));
	$result[] = array($astr, $aid, $aname, $rid, $rname, $awt);
    }

    return sizeof($result);
}

function sql_submit_task($sql, &$out)
{
    $result = mysql_query($sql);
    if ($result) {
	$nrow = mysql_num_rows($result);
	if ($nrow) $out = mysql_fetch_array($result);
    } else {
	$out = mysql_error();
    }
    return $result;
}

?>
