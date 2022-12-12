<?php
ob_start();
error_reporting(E_ERROR | E_PARSE);
include "connection.php";
$url = $_SERVER['REQUEST_URI'];

    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);
    $client = $params['client'];
    // echo $client;
    $sql = "SHOW COLUMNS FROM $client";
        $result = mysqli_query($conn,$sql);
        $rowcount = mysqli_num_rows( $result );
        while($row = mysqli_fetch_array($result))
        {
            $name[] = $row['Field'];
        }
  if(isset($_POST['update']))
  {
      $id = $_POST['update'];
    for ($i=2;$i<=$rowcount-1;$i++)
    {
        $value = $name[$i].$_POST['update'];
        $_POST[$value];
        $sql1 = "UPDATE $client SET `$name[$i]`='$_POST[$value]' WHERE id = '$id'";
        
        // $sql1 = "UPDATE $client SET `$name[$i]`=IF(LENGTH(RTRIM('$_POST[$value]'))=0, `$name[$i]`, '$_POST[$value]') WHERE id = '$id'";
        
        if ($conn->query($sql1) === TRUE) {
            echo "updated";
            header("Location:".$url);                    // header("location: demo.php" );  exit;
        }
        else{
            echo "ERROR: Hush! Sorry $sql. " 
                . mysqli_error($conn);
            }
    }
    //   echo $_POST['update'];
  }
  
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/TweenMax.min.js"></script>-->
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
       height:auto;
       border: 1px solid black;
       padding: 10px;
       text-align: center;
       border-collapse: collapse; 
    }
    .table2{
        /* border: none; */
        
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
    .section1 { 
                width: auto;
                height:auto; 
                margin-top: auto;
                left:0px;
                top:0px;
                overflow-wrap: anywhere;
                text-align:center; 
                /*border:1px solid red;*/
                
            } 
    textarea {
    border: none;
    background-color: transparent;
    resize: none;
    outline: none;
}        
.multiselect{
        width:180px;
        font-size:20px;
    }
    .input-group-addon{
        display:none;
    }
    .dropdown-menu{
        max-height:230px;
        overflow-y:auto;
    }
    li{
        font-size:18px;
    }
        input[type="radio"]{
        display:none;
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
    <li class="is-active">Preview Creative</li>
    <li>Add Animation</li>
    <li>Create Previews/Adtags</li>
  </ul>
</div>
    <a href="./" style="font-size:28px;color:black;position:absolute;top:0px"><i class="fa fa-home"></i></a>
    <form id="formId" method="post">
    <select id="campaigns" name="campaign">
            <?php
                $sql = "select campaign from $client group by campaign";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result))
                { 
                    $campaign = $row['campaign'];
                echo '<option value ='.$campaign.'>'.$campaign.'</option>';
                }
            ?>
        </select> <button name="submit" type="submit" style="border:1px solid black;font-size:15px;">Submit</button>
        <script>
            let $select = $('#campaigns').multiselect({
  enableFiltering: true,
  includeFilterClearBtn: true,
  enableCaseInsensitiveFiltering: true
});

        </script>
    <?php
      
      if(!empty($client))
      {
        echo '<br><br><table class="table1" id="table1">
        <thead>
        <tr id="addrow">';  
        $sql = "SHOW COLUMNS FROM $client";
        $result = mysqli_query($conn,$sql);
        $rowcount = mysqli_num_rows( $result );
        $name[] = $rowcount['Field'];
        echo '<th></th>';
        while($row = mysqli_fetch_array($result))
        {
           if ($row['Field']=="testanim" ||$row['Field']=="id"||$row['Field']=="date" ||$row['Field']=="fcat"||$row['Field']=="client"){
               echo '<th style="display:none;" name='.$row['Field'].'>'.$row['Field'].'</th>';
           }
           elseif($row['Field']=="campaign" ) {
                echo '<th name='.$row['Field'].'>Campaign Name</th>';
           }
           elseif($row['Field']=="dim" ) {
                echo '<th name='.$row['Field'].'>Ad Size</th>';
           }
           elseif($row['Field']=="animation" ) {
                echo '<th name='.$row['Field'].'>Animation</th>';
           }
           elseif($row['Field']=="previews" ) {
            echo '<th name='.$row['Field'].'>previews</th>';
       }
           else{
            // echo '<th name='.$row['Field'].'>'.$row['Field'].'</th>'; 
           }
        }
       
            echo '</tr>
            </thead>
            <tbody>';
            $datee = date("Y-m-d");
            if(isset($_POST['submit']))
            {
                $campaign = $_POST['campaign'];
                $sql = "select * FROM $client where campaign = '$campaign' ";
            }
            else{
                $sql = "select * FROM $client where date = '$datee' ";
            }
           
            $rowcount = mysqli_num_rows( $result );
            $result = mysqli_query($conn,$sql);
            $result1 = mysqli_query($conn,$sql);
            while($row1 = mysqli_fetch_assoc($result1)){
             $json[] = $row1;
            }
            while($row = mysqli_fetch_array($result))
            {
                echo '<tr>';
                 echo '<td><button type="submit" name="update" value="'.$row['id'].'">Update</button> </td>';
                for ($i=2;$i<=$rowcount-1;$i++)
                    { 
                        if($name[$i]=="dim" ||$name[$i]=="campaign" ||$name[$i]=="date"||$name[$i]=="top"||$name[$i]=="width"||$name[$i]=="left"||$name[$i]=="height")
                        {
                            echo '<td ><input  type="text" name="'.$name[$i].$row['id'].'"value="'.$row[$i].'"></td> ';
                        }
                     if($name[$i]=="animation"){
                            echo '<td ><a href="./animation.php?id='.$row['id'].'&date='.$row['date'].'&client='.$row['client'].'&fcat='.$row['fcat'].'&dim='.$row['dim'].'">Update Animation</a></td> ';
                        }else if($name[$i]=="fcat"||$name[$i]=="client" ){
                            echo '<td style="display:none;" ><input  type="text" name="'.$name[$i].$row['id'].'"value="'.$row[$i].'"></td> ';
                        }
                        else if($name[$i]=="testanim"){
                            echo '<td style="display:none;"></td> ';
                        }
                        else if($name[$i]=="previews"){
                            echo '<td style=""></td> ';
                        }
                        else{
                 
                            // echo '<td ><a href='.$row[$i].' target = "_blank"><input class="section1" type="text" name="'.$name[$i].$row['id'].'"value="'.$row[$i].'"></a></td> ';
                            // echo "<td ><textarea class='section1' type='text' name='".$name[$i].$row['id']."'value='".$row[$i]."'>".$row[$i]."</textarea></td>";
                        }
                        
                    }
                   
                    // echo '<td><input type="submit" name="update" onclick="idd(this.parentElement.id-1)" value="Update">';
                    echo '</tr>'; 
                    
            }
            
            echo '</tbody>  
            </table><br><br>'; 

        }    
    
    ?> 
  
     <button type="submit" name="runs" value="runc">Create Ad</button> 
     <input type="hidden" id="colc" name="colc" value="">
    </form> <br>
    <div id="dyn" style="position:relative;display: flex;flex-wrap: wrap;width:100%"></div>
</body>
<script>
     
    function demo()
    {
        var creative = <?php echo json_encode($json) ?>;
       for(var i=0;i<creative.length;i++)
       {
           var newDiv = document.createElement("div"); 
           newDiv.id = "box"+i;
           newDiv.setAttribute('style','position:relative;border:1px solid black;margin:5px 5px;overflow: hidden;width:'+creative[i]['dim'].split('x')[0]+'px;height:'+creative[i]['dim'].split('x')[1]+'px')
           document.getElementById("dyn").appendChild(newDiv)
           
            static = new Array(creative[i]);
            var width = creative[i]['dim'].split('x')[0]+"px";
            var html = "";
            static.forEach(function(val) {
              var keys = Object.keys(val);
              keys.forEach(function(key) {
                  
            if(key!='impression' && key!='click' && key!='animation'&& key!='dim'&&val[key]!=""&&key!='id' && key!='date' && key!='client'&& key!='campaign'&& key!='fcat' && val[key]!=null){
                var idd = key+"box"+i;
                html += "<img id = '" + idd + "' style='position:absolute;top:0px;left:0px;width:" +width+  "' src='"+val[key]+"'>" ;}
                
              });
           
            });
            var keyss = Object.keys(creative[i]);

            document.getElementById('box'+i).innerHTML = html;
            for (let x in keyss) 
            {
                
                if(creative[i]['animation'].includes(keyss[x]))
                {
                    var check = keyss[x]
                    const match_re = new RegExp(`(\\b${check}\\b)`, 'gi')
                    var repl = check+"box"+i
                    creative[i]['animation'] = creative[i]['animation'].replaceAll(match_re, repl);
                             
                }
            }
   
            if (creative[i]['animation']!= null)
            {
                let myScript = document.createElement("script");
                var inlineScript = document.createTextNode(creative[i]['animation']);
                myScript.appendChild(inlineScript);
                document.head.appendChild(myScript);
            }   
        }
        
    }
  
    demo();

    
</script> 
</html>