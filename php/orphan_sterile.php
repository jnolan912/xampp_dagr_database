<table id="results" border=1>
  <tr>
    <th>ID</th>
    <th>Name</th>
  </tr>

<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con,"SELECT * FROM categories c WHERE NOT EXISTS (SELECT Child_ID FROM ancestors WHERE Child_ID = c.Category_ID)");  
    


    while($row = mysqli_fetch_array($result))
    {
        $id = $row['Category_ID'];
        echo "<tr>";
        echo '<td>' . $row['Category_ID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<tr>";   
        if (isset($_POST['move'])) {
            mysqli_query($con,"INSERT INTO ancestors (parent_id, child_id) VALUES (NULL, '$id')");
        }     
    }



    mysqli_close($con);
?>

</table>
