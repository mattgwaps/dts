//
document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        // Remove the success message after 5 seconds
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000); // 5 seconds

        // Remove the success parameter from the URL
        const url = new URL(window.location);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url.toString());
    }
});
document.getElementById("denrformdepartment").addEventListener("change", function() {
    var selectedDepartment = this.value;
    
    if(selectedDepartment === "admin") {
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = false;
    }else if (selectedDepartment === "DIVISION UNIT") {
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("departmentunit").hidden = false;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = true;
    }else if (selectedDepartment === "TSD") {
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = false;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = true;
    } else if(selectedDepartment === "MSD") {
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("denrformworkgroupMSD").hidden = false;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = true;
    }
    else if(selectedDepartment === "PENRO") {
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = false;
        document.getElementById("denrformworkgroupadmin").hidden = true;
    }else if(selectedDepartment === "Frontdesk") {
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = false;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = true;
    }else{
        document.getElementById("departmentunit").hidden = true;
        document.getElementById("denrformworkgroupTSD").hidden = true;
        document.getElementById("denrformworkgroupMSD").hidden = true;
        document.getElementById("denrformworkgroupfrontdesk").hidden = true;
        document.getElementById("denrformworkgroupPENRO").hidden = true;
        document.getElementById("denrformworkgroupadmin").hidden = true;
        
    }
});

document.getElementById("denrformdepartment").dispatchEvent(new Event('change'));
//
function formValidation() {
var errorText = document.getElementById("errorText");

// Validation for Full Name field
if (document.querySelector("#denrformfullname").value === "") {
    alert("Please enter your Full Name.");
    document.querySelector("#denrformfullname").focus();
    document.querySelector("#denrformfullname").style.outline = '2px solid red';
    document.querySelector("#fullnametext").innerHTML = "Please enter your Full Name.";
    return false;
} else {
    document.querySelector("#denrformfullname").style.outline = 'none'; 
    document.querySelector("#fullnametext").innerHTML = "";
}

// Validation for Username field
if (document.querySelector("#denrformusername").value === "") {
    alert("Please enter your Username.");
    document.querySelector("#denrformusername").focus();
    document.querySelector("#denrformusername").style.outline = '2px solid red';
    document.querySelector("#usernametext").innerHTML = "Please enter your Username.";
    return false;
} else {
    document.querySelector("#denrformusername").style.outline = 'none'; 
    document.querySelector("#usernametext").innerHTML = "";
}

// Validation for Password field
if (document.querySelector("#denrformpassword").value === "") {
    alert("Please enter your Username.");
    document.querySelector("#denrformpassword").focus();
    document.querySelector("#denrformpassword").style.outline = '2px solid red';
    document.querySelector("#passwordtext").innerHTML = "Please enter your Password.";
    return false;
} else {
    document.querySelector("#denrformpassword").style.outline = 'none'; 
    document.querySelector("#passwordtext").innerHTML = "";
}

// Validation for Password field
if (document.querySelector("#denrformdepartment").value === "") {
    alert("Please enter your Username.");
    document.querySelector("#denrformdepartment").focus();
    document.querySelector("#denrformdepartment").style.outline = '2px solid red';
    document.querySelector("#departmenttext").innerHTML = "Select Department.";
    return false;
} else {
    document.querySelector("#denrformdepartment").style.outline = 'none'; 
    document.querySelector("#departmenttext").innerHTML = "";
}
return true;
}
