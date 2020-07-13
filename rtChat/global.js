/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */

$(document).ready(function () {
    $(".oneConv").on("click", function (event) { //on event click with objects with class .oneConv
        getConversation(event.target.getAttribute("data-id"))
        event.stopPropagation()
    })
    console.log("DOM chargé")
    user = JSON.parse(userJson.value)
    console.log(user)
})

async function getConversation(id) {
    console.log("getConversation de la conv: " + id)
    url = "?action=getMessages&id=" + id
    Promise.all([reqGET(url)])
        .then(function (test) {
            Promise.all([test])
            return test
        })
        .then(function (res) {
            divMsgsDetails.innerHTML = ""   //make the content empty to remove messages
            if (res !== false) {    //if request was successful
                //Display the messages of the conversation:
                Array.prototype.forEach.call(res, function (msg) {
                    divBig = document.createElement("div")
                    divSmall = document.createElement("div")
                    divBig.appendChild(divSmall)
                    if (user.id == msg.sender.id) {
                        divBig.classList.add("box-alignright")
                    }
                    divSmall.innerHTML = "De:<strong>" + msg.sender.firstname + " " + msg.sender.lastname + "</strong<br><em>" + msg.text + "</em>"
                    divMsgsDetails.appendChild(divBig)
                })


            } else {
                divMsgsDetails.innerHTML = "Conversation non trouvée à l'id: " + id
            }
            console.log("fin arrivée")
            console.log(res)
        })

}

async function reqGET(url) {
    req = new XMLHttpRequest()

    req.open("GET", url)
    req.send()
    req.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            const response = JSON.parse(this.responseText)
            console.log("ready!")
            console.log(response)
            if (response.hasOwnProperty("error") == false) {
                return response
            } else {
                return false
            }

        }
    };
}