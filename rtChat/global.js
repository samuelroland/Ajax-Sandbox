/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */
let lastConvClicked = null  //global var

$(document).ready(function () {
    $(".oneConv").on("click", function (event) { //on event click with objects with class .oneConv
        lastConvClicked = event.target  //save the last conv clicked for apply a darker background if request was successful
        if (event.target.getAttribute("data-id") != null) {
            getConversation(event.target.getAttribute("data-id"))
            removeBG()
        }
        event.stopPropagation()
    })
    console.log("DOM chargé")
    user = JSON.parse(userJson.value)
    console.log(user)
})

$(document).ready(function () {
    btnSend.addEventListener("click", sendMsg)
    btnEmpty.addEventListener("click", function () {
        txtMsg.value = ""
    })
})

async function getConversation(id) {
    console.log("getConversation de la conv: " + id)
    url = "?action=getMessages&id=" + id
    Promise.all([reqGET(url)])

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
            displayConversation(response)
        }
    }
}

function displayConversation(res) {
    if (res.hasOwnProperty("error") == false) {
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
                divSmall.innerHTML = "De: <strong>" + msg.sender.firstname + " " + msg.sender.lastname + "</strong><br><em>" + msg.text + "</em><br><div class='alignright fullwidth'>" + msg.time + "</div>"
                divSmall.classList.add("OneMsg")
                divMsgsDetails.appendChild(divBig)
            })

            lastConvClicked.classList.add("convSelect") //mark the last conv clicked as selected
        } else {
            divMsgsDetails.innerHTML = "Conversation non trouvée à l'id: " + id
        }
    } else {
        divMsgsDetails.innerHTML = res.error.text
    }
}

function addMsgSent(msgSent) {
    console.log("in adding")
    if (msgSent.hasOwnProperty("error") == false) {

        divBig = document.createElement("div")
        divSmall = document.createElement("div")
        divBig.appendChild(divSmall)
        if (user.id == msgSent.sender.id) {
            divBig.classList.add("box-alignright")
        }
        divSmall.innerHTML = "De: <strong>" + msgSent.sender.firstname + " " + msgSent.sender.lastname + "</strong><br><em>" + msgSent.text + "</em><br><div class='alignright fullwidth'>" + msgSent.time + "</div>"
        divSmall.classList.add("OneMsg")
        divMsgsDetails.appendChild(divBig)
    } else {
        divMsgsDetails.innerHTML = msgSent.error.text
    }
}

function removeBG() {
    var els = document.getElementsByClassName("oneConv");
    Array.prototype.forEach.call(els, function (el) {
        el.classList.remove("convSelect")
    })
}

function sendMsg() {
    if (txtMsg.value != "" && lastConvClicked != null) {
        req = newReq()
        req.onreadystatechange = function () {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                const response = JSON.parse(this.responseText)
                addMsgSent(response)
                txtMsg.value = ""   //empty the txtMsg because message has been sent!
            }
        }
        req.open("POST", "?action=sendMsg")
        req.setRequestHeader("Content-Type", "application/json")
        body = {
            text: txtMsg.value,
            conversation_id: lastConvClicked.getAttribute("data-id")
        }
        req.send(JSON.stringify(body))
    }
}

function newReq() {
    return new XMLHttpRequest()
}