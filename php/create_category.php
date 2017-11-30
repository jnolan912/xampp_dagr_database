<?php
    $con = mysqli_connect('localhost', 'root', '', 'dagr');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $categoryPath = mysqli_real_escape_string($con, $_POST['categoryPath']);
    $categoryArray = explode('/', $categoryPath);
    $parent_id = null;
    foreach($categoryArray as $category) {
        // Insert if the category does not exist
        if ($parent_id != null) {
            $r1 = $con->query("INSERT INTO categories (name) 
            SELECT '$category' FROM DUAL
            WHERE NOT EXISTS (SELECT c.name 
                FROM categories c, ancestors a
                WHERE c.name='$category'
                AND a.child_id = c.category_id
                AND a.parent_id = '$parent_id')
            LIMIT 1");
        }
        else {
            $r1 = $con->query("INSERT INTO categories (name) 
            SELECT '$category' FROM DUAL
            WHERE NOT EXISTS (SELECT c.name 
                FROM categories c, ancestors a
                WHERE c.name='$category'
                AND a.child_id = c.category_id
                AND a.parent_id IS NULL) 
            LIMIT 1");
        }

        // If the category was created, insert it into ancestors
        if(mysqli_affected_rows($con) > 0) {
            if ($parent_id == null){
                $r2 = $con->query("INSERT INTO ancestors (parent_id, child_id) VALUES (NULL, last_insert_id())");                                
            }
            else {
                $r2 = $con->query("INSERT INTO ancestors (parent_id, child_id) VALUES ('$parent_id', last_insert_id())");                
            }
        }

        $result = null;
        
        if ($parent_id == null) {
            $result = $con->query("SELECT category_id 
            FROM categories c, ancestors a
            WHERE c.name='$category'
            AND a.child_id = c.category_id
            AND a.parent_id IS NULL");
        }
        else {
            $result = $con->query("SELECT category_id 
            FROM categories c, ancestors a
            WHERE c.name='$category'
            AND a.child_id = c.category_id
            AND a.parent_id = '$parent_id'");
        }

        $row = mysqli_fetch_array($result);
        $parent_id = $row['category_id'];
        
    }

    echo $parent_id;

?>