<?php

$db = mysqli_connect("localhost", "root", "", "calculator"); // connect to database

$result = "";
$error = "";
$history = "";

if(isset($_POST['subm'])){  // if subm is clicked 
  if(empty($_POST['number1']) || empty($_POST['number2'])){  // checks if number1 or number2 is empty
       $error = "Enter numbers"; 
     }else{

      $fNum = $_POST['number1'];
      $sNum = $_POST['number2'];
      $subm = $_POST['subm'];
      
      switch($_POST['subm']){
              case '+':
                $result = $fNum + $sNum; 
                break;
              case '-':
                $result = $fNum - $sNum;
                break;
              case '*':
                $result = $fNum * $sNum;
                break;
              case '/':
                $result = $fNum / $sNum;
                break; 
      } 

      $sql = "INSERT INTO calc_history (num1,num2,subm,result) VALUES ('$fNum','$sNum','$subm','$result')";  // insert into db 
      mysqli_query($db, $sql);  // make query to db
  }  
}

if(isset($_POST['clear'])){    // if clear button is clicked
    $fNum  = "";
    $sNum = "";
    $result = "";
}


if (isset($_POST['del_history'])) {   // if del_history button is clicked

  mysqli_query($db, "DELETE FROM calc_history");   // delete all rows in table

}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Calculator PHP</title>
    </head>

     <body>
         
        <div class = "box">
             <div class = "header">
             <p>Calculator PHP</p>
             </div>

          <form method = "post" action = "index.php" >

          <div class = "err">
	           <p><?php echo $error; ?></p>
          </div>

           <div class = "inputN">
           <p>Enter first number :<input type = "number" class = "inputN"  name="number1" value="<?php echo $fNum ?>"></p>
           <p>Enter second number :<input type = "number" class = "inputN" name="number2" value="<?php echo $sNum ?>"></p>
           <p>Result :<input type ="text" class = "inputN" name="answ" value="<?php echo $result ?>"></p> 
        
       
          <input class = "submS" type="submit" name = "subm" value="+">
          <input class = "submS" type="submit" name = "subm" value="-">
          <input class = "submS" type="submit" name = "subm" value="*">
          <input class = "submS" type="submit" name = "subm" value="/">  
          <button type = "clear" name = "clear" id = "clear_btn" class="clear_btn">Clear All</button>
           <p></p>
            <button type = "history" name = "history" class="btn_history">History</button>
            <button type = "history" name = "del_history" class="btn_delete">Delete History</button>
          </form>

          </div>

          <div class = "history">
            <!-- show history -->
            <?php
          if(isset($_POST['history'])) // if history button is clicked
          {
          $sql = "SELECT * FROM calc_history";
          $result = $db->query($sql);
        
            echo "<br><left><b>History:<b></left><br>";
            echo "<left><table style='none'>";
            echo "<tr>";
            echo "<th></th>";
            echo "<th></th>";
            echo "<th></th>";
            echo "<th></th>";
            echo "</tr>";
          
          if(mysqli_num_rows($result) > 0){  // checks if number of rows are not 0
            while($row = mysqli_fetch_array($result)){  // fetching records from the database
                echo "<tr>";
                echo "<td>" . $row['num1'] . "</td>";
                echo "<td>" . $row['subm'] . "</td>";
                echo "<td>" . $row['num2'] . "</td>";
                echo "<td> = </td>";
                echo "<td>" . $row['result'] . "</td>";
                echo "</tr>";
              }
        } else{
            echo "There's no history yet";
         }
      }
      ?>
          </div>
        
        
          </div>
    </body>
</html>