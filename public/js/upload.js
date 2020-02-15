function sendFile(file) {
    var uri = "index.php?action=import";
    var xhr = new XMLHttpRequest()
    xhr.open("PUT", uri, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
           
            document.querySelector('#message').innerHTML = xhr.responseText;
        }
    };
    xhr.send(file);
}
function sendAction ()
{
    document.querySelector('#message').innerHTML = "Merci de patienter, upload en cours....";
    var filesArray = document.querySelector('#csv').files
    for (var i = 0; i < filesArray.length; i++) {
        sendFile(filesArray[i]);
    }
}

function report (action)
{
    document.querySelector('#report').innerHTML = "Merci de patienter, calcul en cours....";
    var uri = "index.php?action="+action;
    var xhr = new XMLHttpRequest()
    xhr.open("GET", uri, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector('#report').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}