<?php
    
    $con=mysqli_connect("localhost","root","","dagr");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
  


    $category_id = $_POST['id'];
    $steps_up = $_POST['up'];
    $steps_down = $_POST['down'];

    $reached_ids = [];
    if ($category_id != -1) {
        $reached_ids = [$category_id];        
    }
    $just_added = [$category_id]; 
    $adding = [];


    for ($i = 0; $i < $steps_up; $i++) {
        for ($j = 0; $j < sizeof($just_added); $j++) {
            $result = mysqli_query($con,"SELECT * FROM ancestors WHERE child_id = '" . $just_added[$j] . "' AND parent_id IS NOT NULL");
            while($row = mysqli_fetch_array($result)) {
                $reached_ids[] = $row['Parent_ID'];
                $adding[] = $row['Parent_ID'];
            }            
        }
        $just_added = $adding;
        $adding = [];
    }

    $just_added = [$category_id]; 
    $adding = [];
    for ($i = 0; $i < $steps_down; $i++) {
        for ($j = 0; $j < sizeof($just_added); $j++) {
            if ($just_added[$j] == -1) {
                $result = mysqli_query($con,"SELECT * FROM ancestors WHERE parent_id IS NULL");                
            }
            else {
                $result = mysqli_query($con,"SELECT * FROM ancestors WHERE parent_id = '" . $just_added[$j] . "'");
            }
            while($row = mysqli_fetch_array($result)) {
                $reached_ids[] = $row['Child_ID'];
                $adding[] = $row['Child_ID'];
            }            
        }
        $just_added = $adding;
        $adding = [];
    }

    for ($j = 0; $j < sizeof($reached_ids); $j++) {
        $result = mysqli_query($con,"SELECT * FROM categories WHERE category_id = '" . $reached_ids[$j] . "'");
        while($row = mysqli_fetch_array($result)) {
            echo $row['Name'] . "<br>";            
        }            
    }    


?>