//DROPDOWN SEARCH FORM
document.getElementById('searchDropDown').addEventListener('click', function () {
    //if(document.getElementById('searchDropDown').innerText == "►"){
    if(document.getElementById('iconPath').getAttribute('d') == 'M8 16.881V7.119a1 1 0 0 1 1.636-.772l5.927 4.881a1 1 0 0 1 0 1.544l-5.927 4.88A1 1 0 0 1 8 16.882Z'){
        document.getElementById('iconPath').setAttribute('d', 'M7.119 8h9.762a1 1 0 0 1 .772 1.636l-4.881 5.927a1 1 0 0 1-1.544 0l-4.88-5.927A1 1 0 0 1 7.118 8Z');
        //document.getElementById('searchDropDown').innerText = "▼";
        document.getElementById('busquedaForm').style.display = "inline";
    }
    else{
        //document.getElementById('searchDropDown').innerText = "►";
        document.getElementById('iconPath').setAttribute('d', 'M8 16.881V7.119a1 1 0 0 1 1.636-.772l5.927 4.881a1 1 0 0 1 0 1.544l-5.927 4.88A1 1 0 0 1 8 16.882Z');
        document.getElementById('busquedaForm').style.display = 'none';
    }
});

//SHOW SEARCH FORM IF THERE IS PARAMS FILTERING
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    
    // Check if there are any query parameters before proceeding
    if (!params.toString()) {
        return; // Exit script if no filters are present
    }

    //document.getElementById('searchDropDown').innerText = "▼";
    document.getElementById('iconPath').setAttribute('d', 'M7.119 8h9.762a1 1 0 0 1 .772 1.636l-4.881 5.927a1 1 0 0 1-1.544 0l-4.88-5.927A1 1 0 0 1 7.118 8Z');
    document.getElementById('busquedaForm').style.display = "inline";
});