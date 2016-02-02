<?php
global $syshdr;
global $sysftr;
global $_contents;
$syshdr($title,$bland,$menu,'');
echo "<table>\n";
foreach( $_contents as $value){
    echo "<tr>";
    echo "<td>{$value['page']}</td>";
    echo "<td>{$value['mode']}</td>";
    echo "<td>{$value['title']}</td>";
    echo "<td>{$value['eyecatch']}</td>";
    echo "<td>{$value['regdate']}</td>";
    echo "<td>{$value['moddate']}</td>";
    echo "<td>{$value['native']}</td>";
    echo "</tr>\n";
}
echo "</table>\n";
$sysftr();
