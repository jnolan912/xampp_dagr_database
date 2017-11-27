function addRowHandlers() {
    var table = document.getElementById("results");
    var rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() { 
                    var guid = row.getElementsByTagName("td")[0].innerHTML;
                    var w = window.open("../edit.html")
                    w.guid = guid
                };
            };
        currentRow.querySelector(".edit").onclick = createClickHandler(currentRow);
    }
}
window.onload = addRowHandlers();
