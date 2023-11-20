<?php

if($_POST['id'])
{
$id=mysql_escape_string($_POST['id']);
$name=mysql_escape_string($_POST['name']);
// Vote update  
mysql_query("update messages set $name=$name+1 where id='$id'");
// Getting latest vote results
$result=mysql_query("select up,down from messages where id='$id'");
$row=mysql_fetch_array($result);
$up_value=$row['up'];
$down_value=$row['down'];
$total=$up_value+$down_value; // Total votes 
$up_per=($up_value*100)/$total; // Up percentage 
$down_per=($down_value*100)/$total; // Down percentage
//HTML output
echo '<b>Ratings for this blog</b> ( '.$total.' total)
Like :'.$up_value.'
<div id="greebar" style="width:'.$up_per.'%"></div>
Dislike:'.$down_value.'
<div id="redbar" style="width:'.$down_per.'%"></div>';
}
?>