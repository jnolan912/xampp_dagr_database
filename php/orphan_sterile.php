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

    $result = mysqli_query($con,"SELECT * FROM categories c WHERE NOT EXISTS (SELECT parent_id FROM ancestors WHERE Parent_ID = c.Category_ID) AND NOT EXISTS (SELECT Child_ID FROM ancestors WHERE Child_ID = c.Category_ID)");        

    while($row = mysqli_fetch_array($result))
    {
        echo "<tr>";
        echo '<td>' . $row['Category_ID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<tr>";        
    }
    mysqli_close($con);
?>

</table>
