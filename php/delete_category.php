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
        $result = mysqli_query($con,"DELETE FROM categories c WHERE c.category_id = '$category_id')");
        $result = mysqli_query($con,"DELETE FROM document_category dc WHERE dc.category_id = '$category_id')");
        $result = mysqli_query($con,"DELETE FROM documents d WHERE d.id NOT IN (SELECT document_id FROM document_category)");        
        $result = mysqli_query($con,"DELETE FROM ancestors a WHERE a.child_id = '$category_id' OR a.parent_id = '$category_id'");
    }

    mysqli_close($con);
?>