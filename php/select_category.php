<h1>Heirarchical View</h1>

<?php
    $name = $_POST['name'];
    echo "<h2>" . $name . "</h2>";
?>
<?php if($_POST['category_id'] != -1) : ?>
    <form action="http://localhost/xampp_dagr_database/php/delete_category.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $_POST['category_id'];?>">
        <input type="checkbox" checked="checked" name="recursive">Recursive Delete</input><br>
        <input type="submit" value="Delete">
    </form>
<?php endif; ?>

<h3>Parent Categories</h3>
<table>
    <?php
        $con = mysqli_connect('localhost', 'root', '', 'dagr');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $category_id = $_POST['category_id'];

        if ($category_id == -1){
            $category_id = null;
        }

        $result = null;
        if ($category_id != null){
            $result = mysqli_query($con,"SELECT * FROM ancestors a, categories c WHERE a.child_id = '$category_id' AND c.category_id = a.parent_id");
        
            $flag = false;
            while($row = mysqli_fetch_array($result)) {   
                $flag = true;     
                echo "<tr class=heir-row><td id=" .$row["Category_ID"] . ">" . $row["Name"] . "</td></tr>";  
            }
            if (!$flag){
                echo "<tr class=heir-row><td id=-1>Home</td></tr>"; 
            }
        }

        mysqli_close($con);
    ?>
</table>

<h3>Child Categories</h3>
<table>
    <?php
        $con = mysqli_connect('localhost', 'root', '', 'dagr');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $category_id = $_POST['category_id'];

        if ($category_id == -1){
            $category_id = null;
        }

        $result = null;
        if ($category_id == null){
            $result = mysqli_query($con,"SELECT * FROM ancestors a, categories c WHERE a.parent_id IS NULL AND c.category_id = a.child_id");
        }
        else {
            $result = mysqli_query($con,"SELECT * FROM ancestors a, categories c WHERE a.parent_id = '$category_id' AND c.category_id = a.child_id");        
        }

        while($row = mysqli_fetch_array($result)) {        
            echo "<tr class=heir-row><td id=" .$row["Category_ID"] . ">" . $row["Name"] . "</td></tr>";  
        }

        mysqli_close($con);

    ?>
</table>

<h3>Documents</h3>
<table border=1>
    <tr>
        <td>Name</td>
        <td>Path</td>
        <td>Owner</td>
        <td>Last Modified</td>
        <td>Added to Database</td>
        <td>Source</td>
    </tr>
    <?php
        $con = mysqli_connect('localhost', 'root', '', 'dagr');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $category_id = $_POST['category_id'];

        if ($category_id == -1){
            $category_id = null;
        }

        $result = mysqli_query($con,"SELECT d.name, d.path, d.owner, d.mod_time, d.time_added, d.source FROM categories c, document_category dc, documents d WHERE c.category_id = '$category_id' AND c.category_id = dc.category_id AND dc.document_id = d.id");        

        while($row = mysqli_fetch_array($result)) {        
            echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["path"] . "</td>
                <td>" . $row["owner"] . "</td>
                <td>" . $row["mod_time"] . "</td>
                <td>" . $row["time_added"] . "</td>
                <td>" . $row["source"] . "</td>            
            </tr>";  
        }

        mysqli_close($con);

    ?>
</table>

<script src="../heirarchy_post.js"></script>
    