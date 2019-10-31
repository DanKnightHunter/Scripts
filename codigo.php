<?php 
//http://simplehtmldom.sourceforge.net/ 
require("simplehtmldom/simple_html_dom.php"); 

$url="tablaejemplo.php"; 
$html=file_get_contents($url); 

 /*** a new dom object ***/ 
    $dom = new domDocument; 

    /*** load the html into the object ***/ 
    $dom->loadHTML($html); 

    /*** discard white space ***/ 
    $dom->preserveWhiteSpace = false; 

    /*** the table by its tag name ***/ 
    $tables = $dom->getElementsByTagName('table'); 

    /*** get all rows from the table ***/ 
    $rows = $tables->item(0)->getElementsByTagName('tr'); 

    /*** loop over the table rows ***/ 
    foreach ($rows as $row) 
    { 
        /*** get each column by tag name ***/ 
        $cols = $row->getElementsByTagName('td'); 
        /*** echo the values ***/ 
        echo $cols->item(0)->nodeValue.','; 
        echo $cols->item(1)->nodeValue.','; 
        echo $cols->item(2)->nodeValue.','; 
        echo $cols->item(3)->nodeValue.','; 
        echo $cols->item(4)->nodeValue; 
        //echo $cols->item(5)->nodeValue.'<br />'; 
        //echo $cols->item(6)->nodeValue.'<br />'; 
        //echo $cols->item(7)->nodeValue.'<br />'; 
        //echo $cols->item(8)->nodeValue.'<br />'; 
        //echo $cols->item(9)->nodeValue.'<br />'; 
        //echo $cols->item(10)->nodeValue.'<br />'; 
        echo '<br />'; 
    } 
?>