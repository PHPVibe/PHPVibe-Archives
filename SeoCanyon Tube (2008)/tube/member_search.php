<?php require_once("mainfile.php");
require_once("includes/functions.php");
// DEAFAULT QUERY STRING
$queryString = "WHERE email_activated='1' ORDER BY id ASC";
// DEFAULT MESSAGE ON TOP OF RESULT DISPLAY
$queryMsg = "Showing Senior to Newest members by Default";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* ///////////////////// SET UP FOR SEARCH CRITERIA QUERY SWITCH MECHANISMS
if (($_POST['listByq'] == "newest_members")) {
	
    $queryString = "WHERE email_activated='1' ORDER BY id DESC";
	$queryMsg = "Showing Newest to Oldest Members";
	
} else if ($_POST['listByq'] == "yt_members") {

    $queryString = "WHERE youtube !='' AND email_activated='1' ORDER BY id DESC";
    $queryMsg = "Showing Members with embedded YouTube Channels";

} else if ($_POST['listByq'] == "by_firstname") {
	
	
    $fname = $_POST['fname'];
	$fname = stripslashes($fname); 
    $fname = strip_tags($fname);
	$fname = eregi_replace("`", "", $fname);
	$fname = mysql_real_escape_string($fname);
    $queryString = "WHERE firstname LIKE '%$fname%' AND email_activated='1'";
    $queryMsg = "Showing Members with the name you searched for";
	 
} 	
/////////////// END SET UP FOR SEARCH CRITERIA QUERY SWITCH MECHANISMS */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////  QUERY THE MEMBER DATA USING THE $queryString variable's value
$sql = dbquery("SELECT id, username, firstname, country, website FROM myMembers WHERE email_activated='1' ORDER BY id ASC"); 
//////////////////////////////////// Adam's Pagination Logic ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$nr = mysql_num_rows($sql); // Get total of Num rows from the database query
if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
} 
//This is where we set how many database items to show on each page 
$itemsPerPage = 10; 
// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
// This creates the numbers to click in between the next and back buttons
$centerPages = ""; // Initialize this variable
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
	$centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
	$centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage; 
// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
// $sql2 is what we will use to fuel our while loop statement below
$sql2 = dbquery("SELECT * FROM myMembers WHERE email_activated='1' ORDER BY id ASC $limit"); 
//////////////////////////////// END Adam's Pagination Logic ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Adam's Pagination Display Setup ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '<img src="images/clearImage.gif" width="48" height="1" alt="Spacer" />';
	// If we are not on page 1 we can place the Back button
    if ($pn != 1) {
	    $previous = $pn - 1;
		$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '"> Back</a> ';
    } 
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
		$paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '"> Next</a> ';
    } 
}
// Show Template

if($template != "") {

	if(is_file('templates/'.$template.'/member_search.tpl.php')) {

		include('templates/'.$template.'/member_search.tpl.php');

	} else {

		die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template);

	}

} else {

	die("Your default template doesn't appear to be set.");

}
ob_end_flush();
?>