      //For Rows Update When Clicked.
      function updateRow(denrtransactionno){
        location.href = "msdform.php?denrtransactionno=" + denrtransactionno;
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
        
    