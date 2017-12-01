<?php
    
    $category_id = $_POST['id'];
    isset($_POST['recursive']);

    function delete($id, $is_recursive) {
        $con = mysqli_connect('localhost', 'root', '', 'dagr');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        if ($is_recursive){
            $result = mysqli_query($con,"SELECT * FROM ancestors a WHERE a.parent_id = '$id'");
            while($row = mysqli_fetch_array($result)) {                
                delete($row['Child_ID'], true);
            }
        }
        $result = mysqli_query($con,"DELETE FROM categories WHERE category_id = '$id'");
        $result = mysqli_query($con,"DELETE FROM document_category WHERE category_id = '$id'");
        $result = mysqli_query($con,"DELETE FROM documents WHERE id NOT IN (SELECT document_id FROM document_category)");        
        $result = mysqli_query($con,"DELETE FROM ancestors WHERE child_id = '$id' OR parent_id = '$id'");        
        
        mysqli_close($con);        
    }

    // delete the children of this node too

    delete($category_id, isset($_POST['recursive']));

    echo "SUCCESS";

?>