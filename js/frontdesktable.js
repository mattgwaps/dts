function updateRow(id){
    location.href = "frontdesktableupdate.php?id=" + id;
    }
    //-------------------------------
    function hoverEffect(row) {
    row.style.backgroundColor = "#2D7227";
    row.style.cursor = "pointer";
    row.style.transition = ".4s";
    }
    function removeHoverEffect(row) {
    row.style.backgroundColor = "";
    }
