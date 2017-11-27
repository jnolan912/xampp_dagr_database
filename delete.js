function addRowHandlers() {
    var table = document.getElementById("results");
    var rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() { 
                    var cell = row.getElementsByTagName("td")[0];
                    var guid = cell.innerHTML;
                    if(confirm("Are you sure you want to delete " + guid + " from the database")) {
                        alert("DELETED")   // make a call to some php that deletes the element guid 
                    }
                    else {
                        alert("NOT DELETED")
                    }
                };
            };
        currentRow.querySelector(".delete").onclick = createClickHandler(currentRow);
    }
}

// This could be easy, not sure
function deleteAllRows() {
    var table = document.getElementById("results");
    var rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length; i++) {
        //delete document
    }
}

window.onload = addRowHandlers();


