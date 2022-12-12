<?php
ob_start();
include "connection.php";

$sqli1="SELECT table_name
    FROM information_schema.tables
    WHERE table_schema = 'test'";
    $result=mysqli_query($conn,$sqli1);
if (isset($_POST['submit'])) {
    $client = $_POST['client'];
    
    
    while($row=mysqli_fetch_assoc($result)){
        if($row['table_name']!=$client){
            $noresult = "no client available please check";
        }
        else{
        header("Location: add.php?client=" . $client);
    }
    
}
echo $noresult;

} else if (isset($_POST['update'])) {
    $client = $_POST['client'];
    while($row=mysqli_fetch_assoc($result)){
        if($row['table_name']!=$client){
            $noresult = "no client available please check";
        }
        else{
            header("Location: update.php?client=" . $client);
    }
}
// echo $noresult;
} else if (isset($_POST['addt'])) {
    $tablename = $_POST['addta'];
    $tablename2 =  strlen($tablename);
    if ($tablename2 >= 4) {
        $tnm = "SHOW TABLES LIKE '$tablename'";
        $result = mysqli_query($conn, $tnm);
        if (mysqli_num_rows($result) > 0) {
            ?> <h4 style="position: absolute;top:100px;color:red">"Table name already exists!"</h4><?php
        } else {
            $sql = "CREATE TABLE `$tablename` ( `id` INT NOT NULL AUTO_INCREMENT , `date` VARCHAR(100) NULL DEFAULT NULL , `fcat` VARCHAR(100) NULL DEFAULT NULL , `client` VARCHAR(100) NULL DEFAULT NULL , `campaign` VARCHAR(100) NULL DEFAULT NULL , `dim` VARCHAR(100) NULL DEFAULT NULL , `click` VARCHAR(500) NULL DEFAULT NULL , `impression` VARCHAR(500) NULL DEFAULT NULL ,`animation` longtext NULL DEFAULT NULL,`testanim` longtext NULL DEFAULT NULL  ,PRIMARY KEY (`id`))";
            if ($conn->query($sql) === TRUE) {
?> <h4 style="position: absolute;top:100px;color:green">"Table created successfully!"</h4><?php
            }
             else {

             echo "Error creating table: " . $conn->error;
                                                                                       
            }
                                                                                   
        }
                                                                               
    } else {
                                                                                           
        ?> <h4 style="position: absolute;top:100px;color:red">"Table name must be 4 or greater than 4 characters!"</h4><?php
                                                                                                                                                                                                                       
    }
                                                                                                                                                                                                                   
}?>

                                                                                                                                                                                                                           
                                                                                                                                                                                                                           
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="typeahead.js"></script>
  <link rel="stylesheet" href="styles.css" />

</head>
<style>
    body {
        font-family: 'Times New Roman', Times, serif;
        user-select: none;
        margin-left: 1%;
    }

    .table1,
    th,
    td {
        width: auto;
        border: 1px solid black;
        padding: 10px;
        text-align: center;
        border-collapse: collapse;
    }

    input {
        outline: none;
        border: 0px;
        text-align: center;
        background-color: white;
    }

    select,
    option {
        width: 10%;
        text-align: center;
        height: 4%;
        border: 1px solid gray;
        border-radius: 10px;
        font-size: 18px;
        -webkit-appearance: none;
        outline: none;

    }
    .open>.dropdown-menu {
        top:auto;
    }
    .multiselect{
        width:180px;
        font-size:20px;
    }
    .dropdown-menu{
        max-height:230px;
        overflow-y:auto;
    }
    .input-group-addon{
        display:none;
    }
    li{
        font-size:18px;
    }
    input[type="radio"]{
        display:none;
    }
    .typeahead { border: 1px solid #000;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;font-size:20px }
	.tt-menu { width:300px; }
	ul.typeahead{margin:0px;padding:10px 0px;}
	ul.typeahead.dropdown-menu li a {padding: 10px !important;	border-bottom:#CCC 1px solid;}
	ul.typeahead.dropdown-menu li:last-child a { border-bottom:0px !important; }
	.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
		text-decoration: none;
		background-color: #eee;
        color:#000;
		outline: 0;
	}
</style>

<body>
     <div class="container-fluid">
  <br /><br />
  <ul class="list-unstyled multi-steps">
    <li>Login</li>
    <li>Select Template</li>
    <li>Upload Assets</li>
    <li class="is-active">Create Creative</li>
    <li>Preview Creative</li>
    <li>Add Animation</li>
    <li>Create Previews/Adtags</li>
  </ul>
</div>
    <h3>Select Client</h3>
    <form id="formId" method="post">

		<input type="text" name="client" id="txtCountry" class="typeahead" autocomplete="off" placeholder="Search client"/>

<br><br>
        <button name="submit" type="submit" style="border:1px solid black;font-size:15px;">Create New Campaign</button>
        <button name="update" type="submit" style="border:1px solid black;font-size:15px;">Update Existing Campaign</button><br><br>
        <h3>Create New Client</h3>
        <input name="addta" type="text" placeholder="Enter New Client" style="border: 1px solid #000;border-radius: 4px;padding: 8px 12px;max-width: 300px;min-width: 290px;font-size:20px "><br><br>
        <button name="addt" type="submit" style="border:1px solid black;font-size:15px;">Create Client</button><br><br>
    </form>

    <script>
    
    
    
$(document).ready(function () {
        $('#txtCountry').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "server.php",
					data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    });
    
    </script>
</body>

</html>