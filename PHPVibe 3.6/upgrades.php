<?php include_once "header.php";
if($user->isAuthorized()) 	{
$tqry = mysql_query("SELECT * from users_transactions where userID = '".$user->getId()."' and itemID = '22'");
$has_brought = mysql_num_rows($tqry);
} else {
$has_brought = 0;
}
if($user->isAuthorized()) 	{
$past = mysql_query("SELECT * from users_transactions where userID = '".$user->getId()."' and itemID = '14' and price > 24");
$past_b = mysql_num_rows($past);
} else {
$past_b = 0;
}
if(isset($_GET['pay'])) {
if($sumamea > 29) {
$i = mysql_query("INSERT INTO users_transactions (userID, itemID, date, price ) VALUES ('".$user->getId()."', '22', ' ".date('l jS \of F Y h:i:s A')." ', '30')") or die (mysql_error());
mysql_query("UPDATE balance SET suma=suma-30 WHERE uid='".$user->getId()."'");
echo '<div class="nNote nSuccess"><p>Purchase completed! Download from "My Downloads" or product\'s page.</p></div>';
$has_brought = 10;
} else {
echo '<div class="nNote nFailure"><p>Error: you don\'t have the 30 &euro; needed</p></div>';
}

}
?>    

    
    <!-- Main content -->
    <div class="wrapper">
	<div class="fluid">
      
	
<div class="widget first">
<div class="whead"><h6>Available upgrades </h6><div class="clear"></div></div>
<div class="body">


	<?php if( $has_brought ) { 
echo "<strong>You already own PHPVibe 3.5! Download it from <a href=\"http://store.phprevolution.com/buy?id=22\">here</a></strong>";
}elseif($past_b > 0) {
$det = mysql_fetch_row($past);
echo '<strong>You have brought PHPVibe on '.$det[3].'. Your free upgrades period has ended. PHPVibe 3.5 upgrade costs 30 &euro;';
if($sumamea > 29) {
echo '<a href="upgrades?pay=v35" class="btn_blue grid4">Upgrade now [30 &euro;]</a>';
} else {
$sr = 30 - $sumanea;
echo '<br /> <br /><strong>Please deposit '.$sr.' &euro; before coming back to this page. <a href="payment?pay='.$sr.'">Make payment</a>';

}

} else {
echo "<strong>Please contact support for your personalized offer of update <a href=\"http://www.phprevolution.com/contact-us/\">here</a>. Note: Provide your client e-mail.</strong>";

}
?>
<p style="clear:both">
If you belive there is an issue with the upgrade, or if you have brought PHPVibe after 1 January 2013 but you do not have it in your account, please <a href="http://www.phprevolution.com/contact-us/">contact us</a>.
</p>
<br style="clear:both">   
</div>
</div>
        
    </div>
	  </div>
    <!-- Main content ends -->
    
</div>
<!-- Content ends -->

</body>
</html>
