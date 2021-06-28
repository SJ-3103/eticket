<?php
error_reporting(0);
if($_POST){

  $db_name = "./db/formdata.db";
  $table_name = "formdata";

  $roll_number = htmlspecialchars($_POST["roll_number"]);

  $sql = "SELECT student_name,emailid,department,image_name FROM formdata WHERE roll_number = $roll_number";  
  
  $conn = new SQLite3($db_name);
  $result = $conn->query($sql);
  $data = array();
  while($row = $result->fetchArray(SQLITE3_ASSOC)){
    $data = $row;
  }
  if(!$data){
    $error_msg = "Roll Number not found.";
  }
  $conn->close();
  
} 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DCRUST E-Library</title>
    <link rel="stylesheet" type="text/css" href="./css/eticket.css" />
  </head>

  <body>
    
    <?php require_once('./header.php');?>

    <h3 id="main-title">Generate E-Ticket:</h3>
    <div class="main">

      <form class="box" action="./eticket.php" method="POST" enctype="multipart/form-data">
        <label>Roll No:</label>
        <input type="number" name="roll_number" value="<?php echo isset($_POST['roll_number']) ? $_POST['roll_number'] : "";?>" required />
        <div class="error"><?php echo isset($error_msg) ? $error_msg : "";?></div>
      
        <button type="submit">Submit</button>
      </form>
      
      <div class="details box">
        <?php
          if(isset($data['image_name'])){
            $image = $data["image_name"];
            echo "<img src='./photos/$image'>";
          }else{
            echo "";
          }
        ?>
        <label>Name: </label>
        <input type="text" name="student_name" value="<?php echo isset($data['student_name']) ? $data['student_name'] : "";?>" disabled />

        <label>E-Mail ID:</label>
        <input type="email" name="emailid" value="<?php echo isset($data['emailid']) ? $data['emailid'] : "";?>" disabled />

        <label>Department: </label>
        <input type="text" name="department" value="<?php echo isset($data['department']) ? $data['department'] : "";?>" disabled />
      </div>
    </div>

    <?php require_once('./footer.php');?>
  </body>
</html>