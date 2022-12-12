<?php
ob_start();
include "connection.php";
error_reporting(E_ERROR | E_PARSE);
$url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $client = $params['client'];
    // echo $client;
    $autofcat="";
  $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $charCount = strlen($characters);
  for($i=0;$i<6;$i++){
    $autofcat.= substr($characters,rand(0,$charCount),1);
  }
  
  $sqlfcat = "SELECT DISTINCT fcat FROM $client";
  $resultfcat = mysqli_query($conn,$sqlfcat);
  while($row = mysqli_fetch_array($resultfcat))
        {
           if($row['fcat'] === $autofcat){
              echo "fcat is their";
              header("Refresh:0");
            }}
?>
<!DOCTYPE html>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles.css" />
</head>  
<style>
body{
font-family: 'Times New Roman', Times, serif;
user-select: none;
margin-left:1%;
}
.table1,th,td{
width: auto;
border: 1px solid black;
padding: 10px;
text-align: center;
border-collapse: collapse;
}

input{
outline: none;
border: 0px;
text-align: center;
background-color: white;
}
select,option{
width:10%;
text-align:center;
height:4%;
border:1px solid gray;
border-radius:10px;
font-size:18px;
-webkit-appearance:none;
outline:none;
}
.dropdown-menu{
max-height:250px;
overflow:auto;
background-color:#A9A9A9;
position: absolute;
min-width:135px;
left:0px;
}
.multiselect{
   width:135px;
}
.val{
  font-size:20px;
}
li{
        font-size:18px;
    }
.input-group-addon{
        display:none;
    }
.checkbox{
  color:black;
  font-family: 'Times New Roman', Times, serif;
}
.multiselect-selected-text{
  font-size:17px;
  font-weight:bold;
  font-family: 'Times New Roman', Times, serif;
}

</style>
<script>
  $(document).ready(function() {
    var now = new Date();
    if (now.getDate()<10){
      date1="0"+now.getDate();
    }
    else{
      date1=now.getDate();
    }
    var today = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + date1;
    $('.autodate').val(today);
  });
</script>
<body>
  <div class="container-fluid">
  <br /><br />
  <ul class="list-unstyled multi-steps">
    <li>Login</li>
    <li>Select Template</li>
    <li>Upload Assets</li>
    <li class="is-active">Create Creative</li>
    <li>Creative Preview</li>
    <li>Add Animation</li>
    <li>Create Previews/Adtags</li>
  </ul>
</div>
    

    <a href="./" style="font-size:28px;color:black;position:absolute;top:0px"><i class="fa fa-home"></i></a>
    <form id="formId" method="post" style="margin-top:10px;">
    
    <button type="button" onclick="addrow()">Add New Size</button>  
    <button type="button" onclick="addcolumn()">Add New Assets</button><br><br>
    <?php  
    if(!empty($client))
      {
        echo '<table class="table1" id="table1">
        <thead>
        <tr id="addrow">'; 
        $sql = "SHOW COLUMNS FROM $client";
        $result = mysqli_query($conn,$sql);
        $rowcount = mysqli_num_rows( $result );
        while($row = mysqli_fetch_array($result))
        {
            $name[] = $row['Field'];  
        }
        for($k=2;$k<=8;$k++){  
          if($name[$k]=="animation"||$name[$k]=="fcat"||$name[$k]=="client"||$name[$k]=="click"||$name[$k]=="impression"){
            echo '<th style="display:none" name='.$name[$k].'>'.$name[$k].'</th>'; 
          }
          elseif($name[$k]=="campaign"){
               echo '<th name='.$name[$k].'>Write Campaign Name</th>'; 
          }
          elseif($name[$k]=="dim"){
               echo '<th name='.$name[$k].'>Input Ad Size</th>'; 
          }
          else{
          echo '<th name='.$name[$k].'>'.$name[$k].'</th>'; 
          }
        }
        $name[9] = "Select Assets";
        echo '<th>Select Assets</th>';
       echo '</tr>
            </thead>
            <tbody>';
            for($k=1;$k<=1;$k++)
            {
              echo '<tr>';
                        for ($i=1;$i<=$rowcount-1;$i++)
                        {                   
                          if ($name[$i] == "date"){
                            echo ' <td style="display:none"><input class="autodate" type="date"  name=' . $name[$i] . $k . '></td> ';
                          }elseif($name[$i] == "fcat" ) {
                            echo ' <td style="display:none"><input  type="text" value="' . $autofcat . '" readonly="true"  name=' . $name[$i] . $k . ' id=' . $name[$i] . $k . '></td> ';
                          } elseif ( $name[$i] == "dim" || $name[$i] == "campaign") {
                            echo ' <td><input type="text"  name=' . $name[$i] . $k . ' id=' . $name[$i] . $k . '></td> ';
                          } elseif ($name[$i] == "client") {
                            echo ' <td style="display:none"><input  readonly type="text" value = ' . $client . '  name=' . $name[$i] . $k . ' id=' . $name[$i] . $k . '></td> ';
                          } 
                          elseif($name[$i] == "animation") {
                            echo ' <td style="display:none"><input value="function bg_ZoomInAndOut() { var tl =new TimelineMax({repeat:0,repeatDelay:0,delay:0});tl.to(`#bg`,(  5/2),{opacity:1,scale:1.1,ease:Power1.easeNone});tl.to(`#bg`,(5/2),{opacity:1,scale:1,ease:Power1.easeNone});}bg_ZoomInAndOut();function cta_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:-0.6});gsap.from(`#cta`,(  1/1),{x:-50,opacity:0,ease:Power1.easeOut});}cta_Left();function copy_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0.7});gsap.from(`#copy`,(  1.1/1),{x:-50,opacity:0,ease:Power1.easeOut});}copy_Left();function logo_Right() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0});gsap.from(`#logo`,(  1/1),{x:300,opacity:0,ease:Power1.easeOut});}logo_Right();function title_SelectAnimation(){var gsap = new TimelineMax({repeat:0,repeatDelay:0,delay:0});gsap.from(`#title`,(  1/1),{y:0,opacity:1,ease: Power1.easeOut});}title_SelectAnimation();
                            " type="text"  name=' . $name[$i] . $k . ' id=' . $name[$i] . $k . '></td> ';
                          }
                          elseif($name[$i]=="Select Assets"){                            
                            echo '<td>';                                                                          
                            $sql = "SELECT REPLACE(GROUP_CONCAT(COLUMN_NAME),'id,date,fcat,client,campaign,dim,click,impression,animation,testanim','')
                            FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$client'
                            AND TABLE_SCHEMA = 'test'";                                                    
                            $replaced = $conn->query($sql);
                            $row = $replaced->fetch_assoc();            
                            echo '<select class="template" multiple="multiple" name="select'.$k.'[]">';
                            foreach($row as $x => $x_value){                        
                            {                              
                            $arr=explode(",",$x_value);                          
                            for($j=1;$j<sizeof($arr);$j++){                            
                            echo '<option class="val" value.="'.$arr[$j].'">'.$arr[$j].'</option>';                                            
                            }
                           }
                          }
                           echo'</select></td>';  
                          }                                                                        
                    }                        
                echo '</tr>';
               }    
            echo '</tbody>  
            </table><br><br>';  
        }      
    ?>
    <input type="hidden" id="rowc" name="rowc" value="" >
    <input type="hidden" id="colc" name="colc" value="">
    <button type="submit" name="saver" value="Save Feed" onclick="addrow()">Save and Preview</button>  
    <button style="position: absolute;top: 125px;left: 233px;"type="submit" name="savec" value="Save Column">Save New Assets</button>
    <!--<button type="submit" name="saver" value="Save Row">-->
    <!--<input type="submit" name="savec" value="Save Column">-->
    </form>
    <!--<input style="border:1px solid black" type="date"  name="from_date">-->
</body>

</html>
<script>

var column = [<?php echo '"'.implode('","', $name).'"' ?>];
var table = document.getElementById("table1");
var rowc = table.rows.length;
document.getElementById("rowc").value = rowc;
var columnc = table.getElementsByTagName('th').length;
document.getElementById("colc").value = columnc;

function addrow() {
var row = table.insertRow(rowc);
    for (var i = 0 ; i<=columnc+1;i++)
    {

      var cell1 = row.insertCell(i);
      
    cell1.id = rowc+column[i]+i;
    if (column[i]=="id"||column[i]=="date"||column[i]=="animation"||column[i]=="fcat"||column[i]=="client"){
      document.getElementById(rowc+column[i]+i).style.display="none";
    }
    
    if(column[i]!= "id")
    {
    var el = document.createElement('input');
    if (column[i] == "client") {
          var client2 = <?php echo json_encode($client) ?>;
          el.type = "text";
          // el.value = client2;
          el.readOnly=true;
          el.setAttribute("value",client2 );
          el.setAttribute("name","client"+rowc );
          cell1.appendChild(el);   
        }  
        else if (column[i] == "fcat") {
          var atft = <?php echo json_encode($autofcat) ?>;
          el.type = "text";
          // el.value = client2;
          el.readOnly=true;
          el.setAttribute("id","fcats"+rowc);
          el.setAttribute("value",atft );
          el.setAttribute("name","fcat"+rowc );
          cell1.appendChild(el);   
        }    
        else if (column[i] == "animation") {
          el.type = "text";
          el.readOnly=true;
          el.setAttribute("value",'function bg_ZoomInAndOut() { var tl =new TimelineMax({repeat:0,repeatDelay:0,delay:0});tl.to(`#bg`,(  5/2),{opacity:1,scale:1.1,ease:Power1.easeNone});tl.to(`#bg`,(5/2),{opacity:1,scale:1,ease:Power1.easeNone});}bg_ZoomInAndOut();function cta_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:-0.6});gsap.from(`#cta`,(  1/1),{x:-50,opacity:0,ease:Power1.easeOut});}cta_Left();function copy_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0.7});gsap.from(`#copy`,  1.1,{x:-50,opacity:0,ease:Power1.easeOut});}copy_Left();function logo_Right() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0});gsap.from(`#logo`,(  1/1),{x:300,opacity:0,ease:Power1.easeOut});}logo_Right();function title_SelectAnimation(){var gsap = new TimelineMax({repeat:0,repeatDelay:0,delay:0});gsap.from(`#title`,(  1/1),{y:0,opacity:1,ease: Power1.easeOut});}title_SelectAnimation();' );
          el.setAttribute("id","animation"+rowc);
          el.setAttribute("name","animation"+rowc );
          cell1.appendChild(el);   
        }    
         else if(column[i] == "date")
            {
              el.type = "date";
          el.classList.add("autodate");
          el.setAttribute("style","display:none")
          $(document).ready(function() {
            var now = new Date();
            if (now.getDate()<10){
          date1="0"+now.getDate();
    }
    else{
      date1=now.getDate();
    }
            var today = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + date1;
            $('.autodate').val(today);

          });
          
               
             el.name = column[i]+rowc;
          el.id = column[i]+rowc;
        //   el.value = 'ee';
        el.setAttribute("onclick","test(this.id)" );
          cell1.appendChild(el);    
            }
            else if(column[i] == "Select Assets")
           {
            var dc=document.createElement('select');
            dc.setAttribute("multiple","multiple" );
            dc.setAttribute("class","template" );
            dc.setAttribute("name","select"+rowc+"[]" );
            cell1.appendChild(dc);
            <?php
                                                                                     
            $sql = "SELECT REPLACE(GROUP_CONCAT(COLUMN_NAME),'id,date,fcat,client,campaign,dim,animation,previews,testanim','')
            FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$client'
            AND TABLE_SCHEMA = 'publishe_testing'";                                                    
            $replaced = $conn->query($sql);
            $row = $replaced->fetch_assoc();    
            foreach($row as $x => $x_value){                        
            {                              
            $arr=explode(",",$x_value);  
            // echo $arr[0];                        
            // for($j=1;$j<sizeof($arr);$j++){                            
            // echo '<option value.="'.$arr[$j].'">'.$arr[$j].'</option>';                                            
            // }
            }
            }  
            for ($i = 1; $i < count($arr); $i++) {
        //       ?>
              var option = document.createElement("option");
             
              option.value = '<?php echo $arr[$i] ?>';
              option.text = '<?php echo $arr[$i] ?>';
              dc.appendChild(option);
         <?php } ?>
         let $select = $('.template').multiselect({
enableFiltering: true,
includeFilterClearBtn: true,
enableCaseInsensitiveFiltering: true  
});
            }              
        else{
             el.type="text";
             el.name = column[i]+rowc;
          el.id = column[i]+rowc;
        //   el.value = 'ee';
        el.setAttribute("onclick","test(this.id)" );
          cell1.appendChild(el);
           }
         
        }  
    }
    rowc++;
    document.getElementById("rowc").value = rowc;
    var alldim=[];
    var lastdim="";
    for(jas=2;jas<rowc-1;jas++){
        var lastdim=document.getElementById("dim"+jas).value;
      }
    for(sal=1;sal<rowc-2;sal++){
        alldim.push(document.getElementById("dim"+sal).value);
        
      }
      
      console.log(lastdim);
    console.log(alldim);
    if(alldim.includes(lastdim)){
function auto() {
    var result           = '';
    var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < 6; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
      document.getElementById("fcats"+(rowc-2)).setAttribute("value",auto());
    }
  }

// function myFunction(id) {
// alert("I am an alert box!"+id);
// }

function addcolumn()
       {
        columnc++;
        var tblHeadObj = document.getElementById("table1").tHead;
        // alert(tblHeadObj.rows.length);
        for (var h=0; h<tblHeadObj.rows.length; h++) {
            var newTH = document.createElement('th');
            tblHeadObj.rows[h].appendChild(newTH);
            var el = document.createElement('input');
            el.type = 'text';
            el.name = "col"+columnc;
            el.id = "col"+columnc;
            newTH.appendChild(el);
            document.getElementById("colc").value = columnc;
            // alert( columnc)
            // newTH.innerHTML = "<input type='text'>";
        }
        var tblBodyObj = document.getElementById("table1").tBodies[0];
        // alert(tblBodyObj.rows.length)
        console.log(tblBodyObj)
        for (var i=0; i<rowc; i++) {
        var newCell = tblBodyObj.rows[i].insertCell(-1);
        console.log(newCell)
        newCell.innerHTML ='<input type="text" onclick="test(this.id)">';
        }  
    }

function test(id)
    {
      var name = (document.getElementById(id).parentElement.headers);
      if(name != "fcat" && name != "dim" && name != "campaign" && name != "client" && name != "animation" && name != "click" && name != "impression" && name != "video" && name != "Select Assets"  )
     {
          var idn = id.replace(name,'');
          console.log(idn);
            var test = document.getElementById("client"+idn).value+"/"+document.getElementById("campaign"+idn).value+"/"+document.getElementById("dim"+idn).value+"/"+document.getElementById(id).parentElement.headers;
             console.log(test);
            //  document.getElementById(id).style.visibility = "visible"
            document.getElementById(id).value ="https://s.hcurvecdn.com/"+test+".png"
     }
     else if(name == "video")
     {
      var idn = id.replace(name,'');
          console.log(idn);
            var test = document.getElementById("client"+idn).value+"/"+document.getElementById("campaign"+idn).value+"/"+document.getElementById("dim"+idn).value+"/"+document.getElementById(id).parentElement.headers;
             console.log(test);
            //  document.getElementById(id).style.visibility = "visible"
            document.getElementById(id).value ="https://do.hockeycurve.com/"+test+".png"  
       }  
  }

let $select = $('.template').multiselect({
enableFiltering: true,
includeFilterClearBtn: true,
enableCaseInsensitiveFiltering: true  
});



</script>
<?php
$value1 = [];
$empty = 0;
$rowct = $_POST['rowc'];

for ($js=1;$js<$rowct;$js++){
  if(isset($_POST['saver']))
 {
  ${"save".$js} = $_POST['select'.$js];
  ${"temp" . $js} = "";
  foreach(${"save" . $js} as $tem1)  
    {  
      ${"temp" . $js}.=$tem1.",";
    }
$campaign=$_POST[$name[4].$js];
$dim=$_POST[$name[5].$js];

 if($campaign!="" && $dim!=""){
  $asset=explode(",",${"temp" . $js});


  for($p=0;$p<count($asset)-1;$p++){
    ${"test".$js} = "https://s.hcurvecdn.com/".$client."/".$campaign."/".$dim."/".$asset[$p].".png";
${"ps".$js}.="`".$asset[$p]."`,";
${"link".$js}.="'".${"test".$js}."',";

  }
  for ($msi=1;$msi<=8;$msi++){
    ${"msi".$js}.="`".$name[$msi]."`,";
    ${"msi2".$js}.="'".$_POST[$name[$msi].$js]."',";
  }
 

  $enter= rtrim(${"ps".$js}, ",");
   $finalcol=${"msi".$js}.$enter;
  $enter2= rtrim(${"link".$js}, ",");
$finallink=${"msi2".$js}.$enter2;
  $sqlin="INSERT INTO $client ($finalcol,`testanim`) VALUES ($finallink,'function bg_ZoomInAndOut() { var tl =new TimelineMax({repeat:0,repeatDelay:0,delay:0});tl.to(`#bg`,(  5/2),{opacity:1,scale:1.1,ease:Power1.easeNone});tl.to(`#bg`,(5/2),{opacity:1,scale:1,ease:Power1.easeNone});}bg_ZoomInAndOut();function cta_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:-0.6});gsap.from(`#cta`,(  1/1),{x:-50,opacity:0,ease:Power1.easeOut});}cta_Left();function copy_Left() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0.7});gsap.from(`#copy`,(  1.1/1),{x:-50,opacity:0,ease:Power1.easeOut});}copy_Left();function logo_Right() {var gsap =new TimelineMax({repeat:4,repeatDelay:2.5,delay:0});gsap.from(`#logo`,(  1/1),{x:300,opacity:0,ease:Power1.easeOut});}logo_Right();function title_SelectAnimation(){var gsap = new TimelineMax({repeat:0,repeatDelay:0,delay:0});gsap.from(`#title`,(  1/1),{y:0,opacity:1,ease: Power1.easeOut});}title_SelectAnimation();')";

  
  $result=mysqli_query($conn,$sqlin);
  if($result){
    header("Location:update.php?client=".$client);
  }else{
    echo "ERROR: Hush! Sorry $sql. "
    . mysqli_error($conn);
  }
 }
}
}

 if(isset($_POST['savec']))
 {
  $countt = $_POST['colc'];
  for($i = 1; $i <= $countt ; $i++)
       {
           $col = "col".$i;
           echo $col;
           echo $_POST[$col];
           if(!empty($_POST[$col]))
           {
               if($_POST[$col] == "animation")
               {
                   $sql = "ALTER TABLE $client ADD `$_POST[$col]` longtext null";
               }
               else{
                   $sql = "ALTER TABLE $client ADD `$_POST[$col]` varchar(500) null";                                                                
               }    
               
      if(mysqli_query($conn, $sql)){    
      echo "<h3>column added</h3>";
      header("Location:".$url);
      }
      else{
      echo "ERROR: Hush! Sorry $sql. "
      .mysqli_error($conn);
      }
    }
    else{
    echo "fail";
    }
   }    
}
?>
<script>
      var temp = <?php echo json_encode($temp) ?>;
      var client = <?php echo json_encode($client) ?>;
      console.log(temp);
      // var campaign = document.getElementById("campaign").value;
      // var dim = document.getElementById("dim").value;
      // var change = "https://do.hockeycurve.com/" + client +"/"+ campaign +"/"+ dim + "/" + temp + ".png";
      var test = client +"/"+document.getElementById("campaign1").value+"/"+document.getElementById("dim1").value+"/"+ temp + ".png";
      console.log(test);

</script>