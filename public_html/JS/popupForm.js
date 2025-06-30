function submitFormPopup(event, responseId, phpFile) {
    event.preventDefault();

    var formData = new FormData(event.target);
    var xhr = new XMLHttpRequest();

    xhr.open("POST", phpFile, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            var responseDiv = document.getElementById(responseId);
            responseDiv.querySelector('.response-message').innerHTML = response;
            responseDiv.style.display = 'block';

            setTimeout(function() {
                responseDiv.style.display = 'none';
                location.reload();
            }, 1500);
        } else {
            var responseDiv = document.getElementById(responseId);
            responseDiv.querySelector('.response-message').innerHTML = "Error: " + xhr.status;
            responseDiv.style.display = 'block';

            setTimeout(function() {
                responseDiv.style.display = 'none';
                location.reload();
            }, 1500);
        }
    };

    xhr.send(formData);
}
