function post(path, id, name) {
    method = "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);
    form.setAttribute("target", "_blank");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "category_id");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);
    
    var hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("type", "hidden");
    hiddenField2.setAttribute("name", "name");
    hiddenField2.setAttribute("value", name);
    form.appendChild(hiddenField2);

    document.body.appendChild(form);
    form.submit();
}
var button = document.getElementById("open-heirarchical-view");
if (button) {
    button.onclick = function() {post("http://localhost/xampp_dagr_database/php/select_category.php", -1, "Home")};
}

var rows = document.getElementsByClassName("heir-row");
for (i = 0; i < rows.length; i++){
    var currentRow = rows[i];
    var createClickHandler = 
        function(row) 
        {
            return function() { 
                post("http://localhost/xampp_dagr_database/php/select_category.php", row.id, row.innerHTML);
            };
        };
    currentRow.onclick = createClickHandler(currentRow.getElementsByTagName('td')[0]);


   // rows[i].onclick = function(row) {
        
   //     post("http://localhost/xampp_dagr_database/php/select_category.php", 108, "Home")
    //};
}

