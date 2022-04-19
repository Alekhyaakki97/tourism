<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
	{	
header('location:index.php');
}
else{
$fid=intval($_GET['fid']);
if(isset($_POST['submit5']))
	{
$useremail=$_POST['useremail'];
$pid=$_POST['pid'];
$drating=$_POST['driverrating'];
$feedback=$_POST['feedback'];	
$sql="INSERT INTO feedback(BookingId,PackageId,UserEmail,DriverRating,Feedback) VALUES(:fid,:pid,:useremail,:drating,:feedback)";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':fid',$fid,PDO::PARAM_STR);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':drating',$drating,PDO::PARAM_STR);
$query->bindParam(':feedback',$feedback,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$error="Something went wrong. Please try again";
}
else 
{
$msg="feedback Submitted Successfully";
}
}
}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Users Feedback</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Tourism Management System In PHP" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>
</head>
<body>
<!-- top-header -->
<div class="top-header">
<?php include('includes/header.php');?>
<div class="banner-1 ">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Efficient Tour Planning System</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Feedback</h3>
		<form name="chngpwd" method="post">
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<?php
$fid=intval($_GET['fid']);
$sql ="SELECT * FROM tblbooking WHERE BookingId=:fid";
$query= $dbh -> prepare($sql);
$query-> bindParam(':fid', $fid, PDO::PARAM_STR);	
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>

<p style="width: 350px;">
<b>Booking Id</b> 
<input type="text" name="fid" class="form-control" placeholder="Booking Id" value="<?php echo htmlentities($result->BookingId);?>" readonly="">
			</p> 

<p style="width: 350px;">
<b>Package Id</b>
<input type="text" class="form-control" name="pid" placeholder="package Id" value="<?php echo htmlentities($result->PackageId);?>" readonly="">
			</p>

<?php $useremail=$_SESSION['login']; ?>
<p style="width: 350px;">
<b>Email</b> 
<input type="email" name="useremail" class="form-control" value="<?php echo htmlentities($useremail);?>" readonly="">
			</p>

<p style="width: 350px;">
<b>Driver Rating</b>
	<input type="text" class="form-control" name="driverrating" placeholder="Driver rating (1-5)" required="">
			</p>

<p style="width: 350px;">
<b>Feedback</b>
	<input type="text" class="form-control" name="feedback" placeholder="Give your feedback" required="">
			</p>

<?php } ?>

			<p style="width: 350px;">
<button type="submit" name="submit5" class="btn-primary btn">Submit</button>
			</p>
			</form>

		
	</div>
</div>
<!--- /privacy ---->
<!--- footer-top ---->
<!--- /footer-top ---->
<!--?php include('includes/footer.php');?-->
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>
</body>
</html>
<?php } ?>