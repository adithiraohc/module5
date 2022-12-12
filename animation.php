<?php
ob_start();
session_start();
include "connection.php";
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/TweenMax.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    li{
        font-size:18px;
    }
</style>
<body>
    <div class="container-fluid">
  <br /><br />
  <ul class="list-unstyled multi-steps">
    <li>Login</li>
    <li>Select Template</li>
    <li>Upload Assets</li>
    <li>Create Creative</li>
    <li>Preview Creative</li>
    <li class="is-active">Add Animation</li>
    <li>Create Previews/Adtags</li>
  </ul>
</div>
</body>

<!-- <?php
        echo '<pre>';
        var_dump($_GET);
        echo '</pre>';
        ?> -->

<?php
$fdate = $_GET['date'];
$fcat = $_GET['fcat'];
$dim = $_GET['dim'];
$client = $_GET['client'];
$id = $_GET['id'];

$_SESSION['animationID'] = $id;
$_SESSION['tableName'] = $client;
// $name = explode(",", $_GET['update']);
// $_SESSION['animationID'] = $name[0];
// $_SESSION['tableName'] = $name[1];
$query = "SELECT * from `" . $client . "` WHERE id = '" . $id . "' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

//  $jsid = $_GET['hidden1'];
//  echo $_GET['hidden1'];
echo "<button style='border:1px solid black;font-size: 15px;
font-weight:bold;margin-right:10px;margin-bottom:10px;'><a style='text-decoration: none;color:black;'href='./'>Home</a></button>";
echo "<button style='border:1px solid black;font-size: 15px;
font-weight:bold;margin-bottom:10px;'><a style='text-decoration: none;color:black;' href='./update.php?client=".$client."'>Update</a></button>";

echo "<form method='POST'><table class='table1' id='table1'>
            <thead>
            <tr>
                <td>Assets</td>
                <td>Select Animation</td>
                <td>Opacity</td>
                <td>Duration</td>
                <td>Delay</td>
                <td>Repeat Delay</td>
                <td>Animation Repeat Count</td>

            </tr></thead><tbody>";
$tab1 = "SELECT * from `" . $row['client'] . "` WHERE id = " . $row['id'] . " ";
$result2 = mysqli_query($conn, $tab1);
while ($row1 = mysqli_fetch_assoc($result2)) {
    $json[] = $row1;
}
echo "<tr>";
foreach ($json[0] as $key => $x_value) {
    if ($key != 'impression' && $key != 'click' && $key != 'animation' && $key != 'testanim' && $key != 'dim' && $key != 'id' && $key != 'date' && $key != 'client' && $key != 'campaign' && $key != 'fcat' && $x_value != null) {
        $items[] = $key;
        echo "<td>$key</td>";
        echo '<td><select style="width: 100%" name="' . $key . '" id = "' . $key . '1">';
        $sql = "select * from anim";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $aname = $row['name'];
            $anim = $row['anim'];
            echo "<option value ='" . $anim . "'>" . $aname . "</option>";
        }

        echo '</select></td>';
        echo "<td><input type='text' value='0'  id='" . $key . "opc' name='" . $key . "opc' placeholder='Opacity' class='ropc'></td>";
        echo "<td><input type='text' value='1' id='" . $key . "durn' name='" . $key . "durn' placeholder='Duration' class='rdurn'></td>";
        echo "<td><input type='text' value='1' id='" . $key . "delay' name='" . $key . "delay' placeholder='Delay' class='rdelay'></td>";
        echo "<td><input type='text'value='1' id='" . $key . "repeat_delay' name='" . $key . "repeat_delay' placeholder='repeat delay' class='rclass'></td>";
        echo "<td><input type='number' value='1' id='" . $key . "repeat' name='" . $key . "repeat' placeholder='No.of repeats' class='rnumber'></td></td></tr>";

       
    }
   
}
echo "</tbody>";

$ta10 = "SELECT * from $client WHERE id = $id ";
// $ta = "SELECT testanim from `".$row['client']."` WHERE id = ".$row['id']." ";
$result30 = mysqli_query($conn, $ta10);
$row30 = mysqli_fetch_assoc($result30);
$tsan10 = $row30['testanim'];
    $updateQuery3 = "SELECT * FROM $client where id = $id";
$executeQuery3 = mysqli_query($conn, $updateQuery3);

$row4 = mysqli_fetch_assoc($executeQuery3);
$tsan2 = $row4['testanim'];
if($tsan10 != null){


    $assetnum=explode('function',$tsan2);
    for ($sal=1;$sal<count($assetnum);$sal++){

        $thodo=explode('_',$assetnum[$sal]);

        $thodojyada=explode('()',$thodo[1]);
    
        $peev = explode('repeat:',$assetnum[$sal]);
        $pv=explode(',',$peev[1]);

        $peev2 = explode('repeatDelay:',$assetnum[$sal]);  
        $pv2=explode(',',$peev2[1]);



        $peev3 = explode('opacity:',$assetnum[$sal]);
        $pv3=explode(',',$peev3[1]);


        $peev4 = explode('  ',$assetnum[$sal]);
        $pv4=explode('/',$peev4[1]);

        $peev5 = explode('delay:',$assetnum[$sal]);
        $pv5=explode('}',$peev5[1]);
        // $lpv = count($pv);
    
       
       $rp = $pv[0];
       $rp2 = $pv2[0];
       $rp3 = $pv3[0];
       $rp4 = $pv4[0];
       $rp5 = $pv5[0];
    //    echo $rp3;
    //   echo $rp4;
    //    echo $rp5;
    //    echo $rp2;
    //    echo $rp;
    //    echo $thodojyada[0];
       ?>
      <script>
        var smn = document.querySelector("tbody").children;
        console.log(smn);
        
            var alltd = smn[ <?php echo ($sal-1) ?> ].querySelectorAll("td");
            
            for (let in2 = 0; in2 < alltd.length; in2++) {
                if(in2 == 1){
                    alltd[in2].querySelectorAll("option").forEach((el)=>{
                        if(el.innerText.toString() == "<?php echo $thodojyada[0]; ?>"){
                            el.setAttribute('selected','true');
                            console.log(el.innerText)
                        }
                    })
                }
                if(in2 == 2){
                    var intd = alltd[in2].querySelector("input").value = "<?php echo $rp3; ?>";
                }
                if(in2 == 3){
                    var intd = alltd[in2].querySelector("input").value = "<?php echo $rp4; ?>";
                }
                if(in2 == 4){
                    var intd = alltd[in2].querySelector("input").value = "<?php echo $rp5; ?>";
                }
                if(in2 == 5){
                    var intd = alltd[in2].querySelector("input").value = "<?php echo $rp2; ?>";
                }
                if(in2 == 6){
                    var intd = alltd[in2].querySelector("input").value = "<?php echo $rp; ?>";
                }
               
            
            // console.log(smn[index].querySelectorAll("td"))
           
        }

       
      </script>
   <?php
    }
    

   
   

} else {
    $row5 = mysqli_fetch_assoc($executeQuery3);
$tsan3 = $row4['animation'];
// $pv = explode('();',$tsan3);
$pv = explode('repeat:',$tsan3);
    // $lpv = count($pv);
   
   echo $pv[1][0];
}



$col = implode(",", $items);
echo "<input type='hidden' id='hidden1' name='hidden1' value='" . $col . "'>";

echo "</tbody></table><br>";
echo "<button name='preview' id='preview1'    style='border:1px solid black;font-size:15px;cursor:pointer;'>Preview</button>";
echo "<button name='save' id='save1' type='submit' style='border:1px solid black;font-size:15px;cursor:pointer;margin:0 10px;'>Save</button>";
echo "<button name='cancel' id='cancel1'  style='border:1px solid black;font-size:15px;cursor:pointer;'>Cancel</button> </form>";

$ta = "SELECT * from $client WHERE id = $id ";
// $ta = "SELECT testanim from `".$row['client']."` WHERE id = ".$row['id']." ";
$result3 = mysqli_query($conn, $ta);
$row3 = mysqli_fetch_assoc($result3);
$tsan = $row3['testanim'];

if (isset($_POST['save'])) {

    if ($tsan != null && $tsan != "") {
        $updateQuery = "UPDATE $client SET animation = '$tsan' where id = $id";
        $executeQuery = mysqli_query($conn, $updateQuery);
    } else {
        $updatedAnimation = null;
        $animationID = $_SESSION['animationID'];
        $tableName = $_SESSION['tableName'];

        $ids[] = explode(",", $_POST['hidden1']);
        foreach ($ids[0] as $colname) {

            $ee = $colname . "delay";
            $rdelay = $colname . "repeat_delay";
            $repeat = $colname . "repeat";

            $animvalue = str_replace(array("durn","opc","idd", "edelay", "erdelay", "erepeat"), array($_POST[$colname . "durn"],$_POST[$colname . "opc"],$colname, $_POST[$colname . "delay"], $_POST[$colname . "repeat_delay"], $_POST[$colname . "repeat"]), $_POST[$colname]);
            $updatedAnimation = $updatedAnimation . $animvalue;
        }

        $updateQuery = "UPDATE $tableName SET animation = '$updatedAnimation' where id = $animationID";
        $executeQuery = mysqli_query($conn, $updateQuery);
    }
    if($executeQuery){
        header("location:animation.php?id=".$id."&date=".$fdate."&client=".$client."&fcat=".$fcat."&dim=".$dim."&update=".$val."%2C".$client);
        ob_end_flush();
    }
}

if (isset($_POST['preview'])) {
    $updatedAnimation = null;
    $animationID = $_SESSION['animationID'];
    $tableName = $_SESSION['tableName'];

    $ids[] = explode(",", $_POST['hidden1']);
    // print_r($_GET['hidden1']);
    foreach ($ids[0] as $colname) {

        // echo $colname."<br>";
        $ee = $colname . "delay";
        $rdelay = $colname . "repeat_delay";
        $repeat = $colname . "repeat";

        // echo "delay".$_GET['bgdelay']."<br>";
        // echo "ee".$_GET[$colname]."<br>";
        $animvalue = str_replace(array("durn","opc","idd", "edelay", "erdelay", "erepeat"), array($_POST[$colname . "durn"],$_POST[$colname . "opc"],$colname, $_POST[$colname . "delay"], $_POST[$colname . "repeat_delay"], $_POST[$colname . "repeat"]), $_POST[$colname]);
            $updatedAnimation = $updatedAnimation . $animvalue;

        // echo $executeQuery;

    }

    $updateQuery = "UPDATE $tableName SET testanim = '$updatedAnimation' where id = $animationID";
    // echo $updateQuery;
    $executeQuery = mysqli_query($conn, $updateQuery);
    if ($executeQuery) {
        header("location:animation.php?id=" . $id . "&date=" . $fdate . "&client=" . $client . "&fcat=" . $fcat . "&dim=" . $dim . "&update=" . $val . "%2C" . $client);
        ob_end_flush();
    }
}
if (isset($_POST['cancel'])) {
    $updateQuery2 = "UPDATE $client SET testanim = '' where id = $id";
        $executeQuery2 = mysqli_query($conn, $updateQuery2);
        header("location:animation.php?id=".$id."&date=".$fdate."&client=".$client."&fcat=".$fcat."&dim=".$dim."&update=".$val."%2C".$client);
        ob_end_flush();
}




?>


<div id="dyn" style="position:relative;display: flex;flex-wrap: wrap;width:100%"></div>

<script>
    var static;
    var myScript;
    var inlineScript;


    function demo() {

        var creative = <?php echo json_encode($json) ?>;




        for (var i = 0; i < creative.length; i++) {
            var newDiv = document.createElement("div");
            newDiv.id = "box" + i;
            newDiv.setAttribute('style', 'position:relative;border:1px solid black;margin:5px 0;overflow: hidden;width:' + creative[i]['dim'].split('x')[0] + 'px;height:' + creative[i]['dim'].split('x')[1] + 'px')
            document.getElementById("dyn").appendChild(newDiv)

            if (creative[i]['testanim'] != "" && creative[i]['testanim'] != null) {

                static = new Array(creative[i]);
                var width = creative[i]['dim'].split('x')[0] + "px";
                var html = "";
                static.forEach(function(val) {
                    var keys = Object.keys(val);
                    keys.forEach(function(key) {

                        if (key != 'impression' && key != 'click' && key != 'testanim' && key != 'dim' && val[key] != "" && key != 'id' && key != 'date' && key != 'client' && key != 'campaign' && key != 'fcat' && val[key] != null) {
                            var idd = key;
                            html += "<img id = '" + idd + "' style='position:absolute;top:0px;left:0px;width:" + width + "' src='" + val[key] + "'>";
                        }
                    });
                });
                var keyss = Object.keys(creative[i]);

                document.getElementById('box' + i).innerHTML = html;


                if (creative[i]['testanim'] != "" && creative[i]['testanim'] != null) {
                    myScript = document.createElement("script");
                    inlineScript = document.createTextNode(creative[i]['testanim']);
                    myScript.appendChild(inlineScript);
                    document.head.appendChild(myScript);
                }
            } else {
                static = new Array(creative[i]);
                var width = creative[i]['dim'].split('x')[0] + "px";
                var html = "";
                static.forEach(function(val) {
                    var keys = Object.keys(val);
                    keys.forEach(function(key) {

                        if (key != 'impression' && key != 'click' && key != 'animation' && key != 'dim' && val[key] != "" && key != 'id' && key != 'date' && key != 'client' && key != 'campaign' && key != 'fcat' && val[key] != null) {
                            var idd = key;
                            html += "<img id = '" + idd + "' style='position:absolute;top:0px;left:0px;width:" + width + "' src='" + val[key] + "'>";
                        }
                    });
                });
                var keyss = Object.keys(creative[i]);

                document.getElementById('box' + i).innerHTML = html;


                if (creative[i]['animation'] != null) {
                    myScript = document.createElement("script");
                    inlineScript = document.createTextNode(creative[i]['animation']);
                    myScript.appendChild(inlineScript);
                    document.head.appendChild(myScript);
                }

            }


        }
        var idcheck = [];
        var t = document.getElementById('dyn').getElementsByTagName('img');
        for (i = 0; i < t.length; i++) {
            idcheck.push(t[i].id);
        }
    }
    demo();
</script>