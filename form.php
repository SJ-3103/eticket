<?php
error_reporting(0);
$data = array();
try{
  if($_POST){
  
    foreach($_POST as $key=>$value) {
      $data[$key] = htmlspecialchars($value);
    }
  
    if(isset($_FILES["image"])) {  
      $image_name = $_FILES["image"]["name"];
      $image_tmp = $_FILES['image']['tmp_name'];
      $image_size_in_kb = $_FILES["image"]["size"]/1024 ;
      $image_error = $_FILES["image"]['error'];
      if($image_error){
        $error_msg = $image_error;
        exit;
      } 
    }else{
      $error_msg =  "Please upload photos<br>";
    }
  
    $keys = implode(", ",array_keys($data));
  
    if(
      !isset($data["student_name"]) ||
      !isset($data["father_name"]) ||
      !isset($data["roll_number"]) ||
      !isset($data["emailid"]) ||
      !isset($data["contact"]) ||
      !isset($data["department"]) ||
      !isset($data["graduation"]) ||
      !isset($data["course_duration"]) ||
      !isset($data["course_type"]) ||
      !isset($data["paddress"]) ||
      !isset($image_name)
    ){
      $error_msg ="Some feilds are empty";
    }else{
      $name = $data["student_name"];
      $father_name = $data["father_name"];
      $roll_number = $data["roll_number"];
      $emailid = $data["emailid"];
      $contact = $data["contact"];
      $department = $data["department"];
      $graduation = $data["graduation"];
      $course_duration = $data["course_duration"];
      $course_type = $data["course_type"];
      $paddress = $data["paddress"];
      $image_name = $image_name;
    }
    
    $db_name = "./db/formdata.db";
    $table_name = "formdata";
  
    $sql_insert = "INSERT INTO $table_name ($keys,image_name) 
    VALUES (
      '$name',
      '$father_name',
      $roll_number,
      '$emailid',
      $contact,
      '$department',
      '$graduation',
      $course_duration,
      '$course_type',
      '$paddress',
      '$image_name'
    )";
    
    $conn = new SQLite3($db_name);
    try{
      
      $conn->enableExceptions(true);
  
      $conn->exec($sql_insert);
      move_uploaded_file($image_tmp,"photos/".$image_name);
      
      header("Location: ./eticket.php");
      
      $conn->close();
      
    }catch(Exception $e){
      if(strpos($e->getMessage(),'UNIQUE') !== false){
        $error_msg = "Sorry, the student with this roll number is already registered.";
        $data["roll_number"] = "";
      }
    } 
  }
}catch(Exception $e){
  echo "w";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DCRUST E-Library</title>
    <link rel="stylesheet" type="text/css" href="./css/form.css" />
  </head>

  <body>
  <?php require_once('./header.php');?>

    <div class="main">
      <form class="box" action="./form.php" method="POST" enctype="multipart/form-data">
        <div class="error"><?php echo isset($error_msg) ? $error_msg : "";?></div>
        <h3>Library e-Membership Form:</h3>
        <label>Name: </label>
        <input type="text" name="student_name" value="<?php echo isset($data['student_name']) ? $data['student_name'] : "";?>" required />

        <label>Father's Name:</label>
        <input type="text" name="father_name" value="<?php echo isset($data['father_name']) ? $data['father_name'] : "";?>" required />

        <label>Roll No:</label>
        <input type="number" name="roll_number" value="<?php echo isset($data['roll_number']) ? $data['roll_number'] : "";?>" required />

        <label>E-Mail ID:</label>
        <input type="email" name="emailid" value="<?php echo isset($data['emailid']) ? $data['emailid'] : "";?>"required />

        <label>Contact NO.:</label>
        <input type="tel" name="contact" value="<?php echo isset($data['contact']) ? $data['contact'] : "";?>"required/>

        <label>Department: </label>
        <input type="text" name="department" value="<?php echo isset($data['department']) ? $data['department'] : "";?>"required />

        <div>
          <input type="radio" name="graduation" value="UG" id="UG" required/>
          <label for="UG">UG</label>

          <input type="radio" name="graduation" value="PG" id="PG" required/>
          <label for="PG">PG</label>

          <input type="radio" name="graduation" value="ResearchScholar" id="research_scholar" required/>
          <label for="research_scholar">Reasearch Scholar</label>
        </div>

        <label>Duration Of Course: </label>
        <input type="number" name="course_duration" min="1" value="<?php echo isset($data['course_duration']) ? $data['course_duration'] : "";?>" required />

        <div>
          <input type="radio" name="course_type" value="Regular" id="regular" required/>
          <label for="regular">Regular</label>

          <input type="radio" name="course_type" value="Weekend" id="weekend" required/>
          <label for="weekend">Weekend </label>
        </div>

        <label>Permanent Address: </label>
        <input type="text number" name="paddress" value="<?php echo isset($data['paddress']) ? $data['paddress'] : "";?>"required />

        <div>
          <label>Upload Photogarph: </label>
          <input type="file" accept="image/*" name="image" value="<?php echo isset($_FILES["image"]) ? $_FILES["image"]["name"] : "";?>" required/>
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>

    <?php require_once('./footer.php');?>
  </body>
</html>