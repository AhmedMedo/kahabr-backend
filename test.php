<?php
$db = mysql_connect("localhost", "fekracom_khabar", "Fekra@2016");
mysql_select_db("fekracom_khabar");
$result = mysql_query("SELECT DISTINCT category, subcategory, type FROM finalfeeds WHERE language = 'ar' AND country = 'eg';");
while($row = mysql_fetch_row($result))
echo "<p>".$row[0].",".$row[1].",".$row[2];
?>