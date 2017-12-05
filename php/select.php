<?php
  $con=mysqli_connect("localhost","root","","dagr");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $result = mysqli_query($con,"SELECT * FROM Documents");

?>

<style type="text/css">

  img { visibility: hidden; }
  tr:hover img { visibility: visible; }

</style>

<table id="results" border=1>
  <tr>
    <th>GUID</th>
    <th>Name</th>
    <th>Path</th>
    <th>Owner</th>
    <th>Last Modified</th>
    <th>Time Added to Database</th>
    <th>File Source</th>
  </tr>

  <?php
    while($row = mysqli_fetch_array($result))
     {        
      echo '<tr id=' . $row["ID"] . '>
          <td class="guid">' . $row['GUID'] . "</td>
          <td>" . $row["Name"] . "</td>
          <td>" . $row["Path"] . "</td>
          <td>" . $row["Owner"] . "</td>
          <td>" . $row["Mod_Time"] . "</td>
          <td>" . $row["Time_Added"] . "</td>
          <td>" . $row["Source"] . '</td>
          <td class="edit"><img src="../icons/edit.png" alt="edit" id="edit"></td>
      </tr>';  
    }
    mysqli_close($con);

  ?>

</table>

<script src=../edit.js></script>
