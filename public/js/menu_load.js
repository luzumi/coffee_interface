function load() {
    console.log('load');
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/webhook_data");
    xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
    xhr.onreadystatechange = function () {
        console.log('onreadystatechange');
        if (xhr.readyState === XMLHttpRequest.DONE) {
            console.log('readyState');
            let responseText = xhr.responseText;
            console.log("if " + responseText);
            if (responseText.startsWith("data")) {
                responseText = responseText.substring(5);
                console.log("if " + responseText);
            }
            try {
                let data = JSON.parse(this.responseText);

                const userId = data.data;

                if (userId == null || userId < 1) {
                    console.log('kein Benutzer gefunden');
                } else {
                    console.log('Benutzer gefunden' + userId);
                    window.location.href = '/menu';
                }

            } catch (error) {
                console.error("Fehler beim Parsen des JSON:", error);
            }
        }
    };
    xhr.send();
}

setInterval(load, 1000);
