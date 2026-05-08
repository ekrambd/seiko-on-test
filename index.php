<?php session_start();
if(!isset($_SESSION['usr_ids']) && !isset($_SESSION['usr_pass']))
{
header("location: login.php");
}
include 'connect.php';
include 'function.php';
date_default_timezone_set("Asia/Dhaka");
ini_set('max_execution_time', 32400);
$ownid = $_SESSION['m_ids'];
$iniusercheks = mysql_query("SELECT * FROM `admin_login` WHERE `user_name`='$_SESSION[usr_ids]' AND `user_pass`='$_SESSION[usr_pass]'");
$iniuserchek = mysql_fetch_array($iniusercheks);
if($iniuserchek['user_name']!=$_SESSION['usr_ids'] && $iniuserchek['user_pass']!=$_SESSION['usr_pass'])
{
session_destroy();
header("location: login.php");
}

$date = date('d M Y');
list($d,$m,$y)= explode(' ', $date);
if(isset($_GET['yy'])){
$upday= strip_tags($_GET['dd']);
$upmonth= strip_tags($_GET['mm']);
$upyear= strip_tags($_GET['yy']);
if($upday==0)
{
$titles=" `month`='$upmonth' AND `year`='$upyear'";
}
else{
$titles=" `day`='$upday' AND `month`='$upmonth' AND `year`='$upyear'";
}
}
else{
$upday= date("d");
$upmonth= date("M");
$upyear= date("Y");
$titles=" `month`='$upmonth' AND `year`='$upyear'";
}


$memlist=0;
$allpv=0;
$SiteTiles=mysql_query("SELECT * FROM `title` WHERE `titles`='title'");
$SiteTile = mysql_fetch_array($SiteTiles);
$SiteTils2=mysql_query("SELECT * FROM `title` WHERE `titles`='contact'");
$SiteTil2 = mysql_fetch_array($SiteTils2);
$companyname = $SiteTile['url'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
body
{
  background: rgb(204,204,204); 
}
page[size="A4"] {
  background: white;
  width: 29.7cm;
  height: 21cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.1cm rgba(0,0,0,0.5);
  -o-box-shadow: 0 0 0.1cm rgba(0,0,0,0.5);
  -webkit-box-shadow: 0 0 0.1cm rgba(0,0,0,0.5);
  -moz-box-shadow: 0 0 0.1cm rgba(0,0,0,0.5);
}
.third
{
width:90%;
height:940px; padding-top:5px;
margin:10px auto; 
}
tr{}
tr:hover{background-color:#A3DDF0;}
th{
text-align:center;
font-size:12px;	
}
td{
text-align:center;
font-size:13px;		
}
#footer
{
width:400px;  
margin:auto;
background-color:#FFF;
}
#footer a
{
text-decoration:none;
text-align:center;
font-size:10px;
}

@page {
    size: A4;
    margin: 0;
}
@media print {
  body, page[size="A4"] {
	margin: 0;
	box-shadow: 0;
  }
}
@media print{
	#print{
	display:none;
	}
	.print{
	display:none;
	}
}
.upon{
width:400px;
height:auto;
margin:auto;
}
#site_header_logo{
position: relative;
width:105px;
height:100px;
float:left;
margin-top:-10px;
margin-left:10px;
}
a{
text-decoration:none;
}

.boxfirst{width:100%; text-align:center;}
.boxfirst h1{font-size:20px; text-transform: uppercase; margin:0px; padding-bottom:10px}
.boxtd{font-size:11px;}
.boxfirst h4{font-size:13px; text-transform: uppercase; margin:0px; padding-bottom:0px}
.boxtd{font-size:11px;}
.inbox{width:40%; margin:auto;}
@media print{.inbox{display:none;}}
</style>
<title>Member Accounts Info</title>
</head>
<div class="inbox">
<form>
<select name="yy" style="width:132px">
<?php
$sel="";
for($i=2021;$i<=2028;$i++){	
	if($i==$y){
	$sel="selected='selected'";}
	else
	$sel="";
	echo"<option value='$i' $sel>$i </option>";
	}						
	?>
	</select>

<select name="mm" style="width:132px">
<?php 
$sel = "";
$monthg = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$vx=0;
foreach($monthg as $mo){
	$vx++;
	if($mo==$m)
	{
		$sel="selected='selected'";
	}
	else {$sel="";}

echo "<option value='$mo' $sel>$mo</option>";	
}
?>
</select>



<select name="dd" style="width:132px">
<option value="0">None</option>
<?php
$sel="";
for($b=1;$b<=31;$b++){
if($b<10){$dbs= "0".$b;}
else{$dbs= $b;}
if($dbs==$d){$sel="selected='selected'";}
else{$sel="";}
?>
<option value="<?php echo $dbs ;?>" <?php echo $sel?>>
<?php echo $dbs; ?>
</option>	
<?php } ?>
</select>

</select>
<input type="submit" value="Submit"/>
</form>
</div>

<body>
<div style="width:100%; height:15px; clear:both"></div>
<?php
$sendmals = mysql_query("SELECT id FROM `tree` WHERE $titles ORDER BY `start` ASC");
$sendmal = mysql_num_rows($sendmals);
if($sendmal==0)
{
echo "<center>Have not enough data.</center>";
exit();
}
$parpage = 31;
$page = ceil($sendmal/$parpage);
for($x=1; $x<=$page; $x++)
{
$v = $x-1;
$qroop = $v*$parpage;
?>
<page size="A4">
<div style="clear:both; width:100%; height:1px;"></div>
<div class="third">
<div class="boxfirst">
<h1><?php echo $companyname; ?></h1>
<h4>Member Accounts Info</h4>
</div>
<hr>


<div style="clear:both; width:100%; height:20px"></div>
<table style="width:100%; margin:0px auto; border-collapse: collapse;" border="1" id="testTable">
<tr bgcolor="#E3E3E3">
<th>ID</th>
<th>Rank</th>
<th>User</th>
<th>Name</th>
<th>Mobile</th>
<th>Join</th>
<th>Refer</th>
<th>Team</th>
<th>Team Sale</th>
<th>My Unit</th>

</tr>
<?php
$turn=0+$qroop;
$pinueds = mysql_query("SELECT id, rank, lefts, refer, lpoint, mypv FROM `tree` WHERE $titles ORDER BY `start` ASC LIMIT $qroop,$parpage");
while($pinued = mysql_fetch_array($pinueds))
{
$refques2=mysql_query("SELECT user, name, mobile, joint FROM `profile` WHERE `id`='$pinued[id]'");
$refque2 = mysql_fetch_array($refques2);

$AccQues=mysql_query("SELECT balance2 FROM `myacc` WHERE `id`='$pinued[id]'");
$AccQue= mysql_fetch_array($AccQues);

$RFNames=mysql_query("SELECT user, name FROM `profile` WHERE `id`='$pinued[id]'");
$RFName= mysql_fetch_array($RFNames);

$turn++;
if($turn%2==0)
{
echo "<tr bgcolor='#E8ECED'>";
}else{
echo "<tr>";
}
$Mypv=round($AccQue['balance2'],2);
$memlist+=1;
$allpv+=$Mypv;
?>

<td><?php echo $pinued['id']; ?></td>
<td><?php if($pinued['rank']!=""){$mrank=explode(" ", $pinued['rank']); $mranks=null; foreach($mrank as $w){$mranks .= $w[0];} 
echo $mranks;}
?></td>
<td><?php echo $refque2['user']; ?></td>
<td title="<?php echo $refque2['name']; ?>"><?php echo limits($refque2['name'],2); ?></td>
<td><a href="sms2.php?mm=<?php echo $refque2['mobile']; ?>"><?php echo $refque2['mobile']; ?></a></td>
<td><?php echo date("d M, Y", $refque2['joint']); ?></td>
<td><?php echo $RFName['user']; ?></td>

<td><?php echo $pinued['lefts']; ?></td>
<td><?php echo $pinued['lpoint']; ?></td>
<td><?php echo $Mypv; ?></td>

</tr>
<?php }
if($x==$page)
{
echo "<tr><td colspan='9'><b>Total Member: $memlist </b></td><td><b> $allpv </b></td></tr>";
}
?>
</table>

<div style="clear:both; width:100%; height:5px;"></div>
</div>
</page>
<?php } ?>

</body>
</html>