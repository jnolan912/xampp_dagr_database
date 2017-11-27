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

<button>DELETE ALL RECORDS SHOWN</button>

<table id="results" border=1>
  <tr>
    <th>GUID</th>
    <th>Name</th>
    <th>Owner</th>
    <th>Timestamp</th>
  </tr>

  <?php
    while($row = mysqli_fetch_array($result))
    {
      echo "<tr>";
      echo '<td class="guid">' . $row['GUID'] . "</td>";
      echo "<td>" . $row['Name'] . "</td>";
      echo "<td>" . $row['Owner'] . "</td>";
      echo "<td>" . $row['Timestamp'] . "</td>";
      echo '<td class="edit"><img src="../icons/edit.png" alt="edit" id="edit"></td>';
      echo '<td class="delete"><img src="../icons/trash.png" alt="X" id="delete"></td>';
      echo "</tr>";
    }
    mysqli_close($con);

  ?>

</table>

<script src=../delete.js></script>
<script src=../edit.js></script>
