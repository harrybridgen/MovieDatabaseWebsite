function search(query, inputId, suggestionsDivId, table, feature) {
    var suggestionsDiv = document.getElementById(suggestionsDivId);

    if (query.length == 0) {
        suggestionsDiv.innerHTML = "";
        suggestionsDiv.style.display = 'none';
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                suggestionsDiv.innerHTML = this.responseText;
                if (this.responseText.trim().length > 0) {
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            } else {
                console.error("Error: ", this.status, this.statusText);
            }
        }
    };

    xhr.open("GET", "PHP/search.php?t=" + table + "&q=" + query + "&d=" + suggestionsDivId + "&i=" + inputId + "&f=" + feature, true);
    xhr.send();
}

function selectSuggestion(element, inputId, suggestionsDivId) {
    document.getElementById(inputId).value = element.innerHTML;
    document.getElementById(suggestionsDivId).innerHTML = "";
}

function submitForm(event, inputId, resultsDivId, phpFile) {
    event.preventDefault();
    var inputValue = document.getElementById(inputId).value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(resultsDivId).innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "PHP/" + phpFile + ".php?id=" + inputId + "&value=" + inputValue, true);
    xhr.send();
}

function hideSuggestions(suggestionsDivId) {
    setTimeout(function () {
        document.getElementById(suggestionsDivId).style.display = 'none';
    }, 100);
}

