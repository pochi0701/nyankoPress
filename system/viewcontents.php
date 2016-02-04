<table class="table table-striped">
<thead><tr><th>Page</th><th>Mode</th><th>Title</th><th>EyeCatch</th><th>登録日</th><th>変更日</th><th>Native</th></tr></thead>
<tbody>
<?php
global $_contents;
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
?>
</tbody>
</table>
