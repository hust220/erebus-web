<?php
require('config/config.inc.php');
pagesetup(true);
	if (empty($_SESSION['username'])){
		header("Location: login.php");
	}

$userid = $_SESSION['userid'];

#$sql="DELETE FROM completed WHERE taskid LIKE \"$taskid%\" AND userid='$userid';";
#$result = mysql_query($sql) or die("");
#$sql="DELETE FROM submitted WHERE taskid LIKE \"$taskid%\" AND userid='$userid';";
#$result = mysql_query($sql) or die("");

$request=$_GET['resid'];
$format=$_GET['fmt'];
if (empty($format)) $format='pml';

$params=explode("@", $request);
$taskid=$params[0];
$pdbid=$params[1];
$resid=$params[2];
if (empty($resid)) $resid = 0;

$ent="pdb" . strtolower($pdbid) . ".ent.gz";

$sql="SELECT completed.query as query,ct,cq,cm,cla,clr,cne,cna,cwt,crmsd,clq,results.taskid,resid FROM results JOIN completed " .
    "ON (results.taskid=completed.taskid AND completed.userid=$userid AND results.taskid=\"$taskid\" AND SUBSTR(results.ct FROM -14)=\"$ent\" AND results.resid=\"$resid\") LIMIT 1";

$result = sql_submit_task($sql, $row);
if (!$result) die("");

$pdbid = $row['ct'];
$pdbid = substr(basename($pdbid), 0, 7);
$pdbid = substr($pdbid, 3, 4);
$resid = $row['resid'] + 1;
$clr = $row['clr'];
$cla = $row['cla'];

$res=$row['clr'];
$query = $row['query'];
$coords = $row['clq'];

$acoords = explode("\n", $coords);

$size = sizeof($acoords);
$lcoords = array();
foreach ($acoords as $s)
{
    $tmp=explode(",", $s);
    $key=$tmp[0];
    $s=sprintf("%8.3f%8.3f%8.3f", (float)$tmp[1], (float)$tmp[2], (float)$tmp[3]);
    $lcoords[$key] = $s;
}

$pdbin=explode("\n", $query);
$npdbs=sizeof($pdbin);
$pdbout=array();
$j=0;
for ($i = 0; $i < $npdbs; $i++)
{
    $s = $lcoords[$i];
    if (!empty($s)) {
	$pdbout[$j++] = substr_replace($pdbin[$i], $s, 30, 24);
    }
}
$pdblines=implode("\\n", $pdbout);

if ($format == 'pml') {
$pml="fetch $pdbid, async=0
select erebusres, resi $clr
select erebusatm, id $cla and resi $clr
show sticks, resi $clr
show dots, id $cla and resi $clr
cmd.read_pdbstr(\"$pdblines\", \"query\", 1);
show mesh, query
orient query
";
#set dot_density,3

header('Content-type: chemical/x-pml');
header('Content-Disposition: attachment; filename="' . $pdbid . '_' . $resid . '.pml"');
echo $pml;

} elseif ($format == 'txt') {
$txt = "
PDB ID:
$pdbid

Atoms:
$cla

Residues:
$clr

Query:
" . stripcslashes($pdblines) . "
";

header('Content-type: text/ascii');
header('Content-Disposition: attachment; filename="' . $pdbid . '_' . $resid . '.txt"');
echo $txt;
}

?>
