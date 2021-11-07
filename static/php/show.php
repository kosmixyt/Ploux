<?php

if(!empty($_GET["type"]) && $_GET["type"] == "show_global"){ 
require("bdd.php");
$sql = "SELECT * FROM media";
$result = $conn->query($sql);
if ($result->num_rows > 0) {}else{ echo "No média found !"; }

?>
<div class="container">
<table>
    <tbody>
        <tr>
            <?php  $count = 0; while($row = $result->fetch_assoc()) {
                
                if($count > 3){
                    echo "</tr><tr>";
                    $count = 0;
                }
                
                ?>
            <td><center><p class="media_name"><a onClick="verify(this.innerHTML);       document.title='Details from : ' + this.innerHTML; " href="#details:<?php echo $row["proxy_id"]; ?>"><?php echo $row["name"]; ?></p><br><img title="A Rubik’s Cube" onmouseover="select()" style="  width: 296px; height: 400px;" src="/static/php/pngproxy.php?proxy_id=<?php echo $row["proxy_id"]; ?>"></a></center></td>
<?php $count = $count + 1; } ?>
        </tr>
    </tbody>
</table>
            </div>






<?php } ?>