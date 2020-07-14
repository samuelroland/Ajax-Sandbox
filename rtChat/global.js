/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */
let lastConvClicked = null  //global var

$(document).ready(function () {
    EventListenersDeclare()
})

function EventListenersDeclare() {
    btnSend.addEventListener("click", sendMsg)
    btnEmpty.addEventListener("click", function () {
        txtMsg.value = ""
    })
    imgIcon.addEventListener("click", getNewMessages)
    chkRT.addEventListener("change", periodicSearchMessages)
    btnNewConv.addEventListener("click", displayFormNewConv)
    btnCreateNewConv.addEventListener("click", createNewConv)
    type2.addEventListener("RadioStateChange", manageInputGroupName)

    $(".oneConv").on("click", function (event) { //on event click with objects with class .oneConv
        lastConvClicked = event.target  //save the last conv clicked for apply a darker background if request was successful
        if (event.target.getAttribute("data-id") != null) {
            getConversation(event.target.getAttribute("data-id"))
            removeBG()
        }
        event.stopPropagation()
    })
    //Load the informations of the user logged:
    user = JSON.parse(userJson.value)
}

async function getConversation(id) {
    console.log("getConversation de la conv: " + id)
    url = "?action=getMessages&id=" + id
    Promise.all([reqGET(url)])
    divMsgsDetails.innerHTML = ""   //make the content empty to remove messages
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

var lastMsgId = null

function displayConversation(res) {
    if (res.hasOwnProperty("error") == false) {

        //Display the messages of the conversation:
        Array.prototype.forEach.call(res, function (msg) {
            divBig = document.createElement("div")
            divSmall = document.createElement("div")
            divBig.appendChild(divSmall)
            if (user.id == msg.sender.id) {
                divBig.classList.add("box-alignright")
            }
            divSmall.innerHTML = "De: <strong>" + msg.sender.firstname + " " + msg.sender.lastname + "</strong><br><em>" + msg.text + "</em><br><div class='alignright fullwidth'>" + msg.time + "</div>"
            divSmall.classList.add("oneMsg")
            divMsgsDetails.appendChild(divBig)
            lastMsgId = msg.id
        })

        lastConvClicked.classList.add("convSelect") //mark the last conv clicked as selected
    } else {

    }
}

function addMsgSent(msgSent) {
    if (msgSent.hasOwnProperty("error") == false) {

        divBig = document.createElement("div")
        divSmall = document.createElement("div")
        divBig.appendChild(divSmall)
        if (user.id == msgSent.sender.id) {
            divBig.classList.add("box-alignright")
        }
        divSmall.innerHTML = "De: <strong>" + msgSent.sender.firstname + " " + msgSent.sender.lastname + "</strong><br><em>" + msgSent.text + "</em><br><div class='alignright fullwidth'>" + msgSent.time + "</div>"
        divSmall.classList.add("oneMsg")
        divMsgsDetails.appendChild(divBig)
        lastMsgId = msgSent.id
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
        if (lastConvClicked.getAttribute("data-id") != null) {
            req = newReq()
            req.onreadystatechange = function () {
                if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                    const response = JSON.parse(this.responseText)
                    addMsgSent(response)
                    console.log("ajouté à la covn...")
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
}

function newReq() {
    return new XMLHttpRequest()
}

function getNewMessages() {
    idmsg = lastMsgId
    idconv = lastConvClicked.getAttribute("data-id");
    url = "?action=getMessagesAfterId&idmsg=" + idmsg + "&idconv=" + idconv
    reqGET(url)
}

idSetInterval = null

function periodicSearchMessages() {
    if (chkRT.checked == true) {
        idSetInterval = setInterval(getNewMessages, 500)
    } else {
        clearInterval(idSetInterval)
    }
}

async function GETUsersList() {
    req = new XMLHttpRequest()
    url = "?action=getUsers"
    req.open("GET", url)
    req.send()
    req.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            const response = JSON.parse(this.responseText)
            listUsers(response)
        }
    }
}

function listUsers(users) {
    Array.prototype.forEach.call(users, function (user) {
        option = document.createElement("option")
        option.value = user.id
        option.innerText = user.firstname + " " + user.lastname
        sltUser.appendChild(option)
    })
}

function displayFormNewConv() {
    frmNewConv.classList.remove("invisible")
    GETUsersList()
}

function createNewConv() {
    if (type1.checked == true || type2.checked == true && sltUser.options.length != 0) {
        req = newReq()
        req.onreadystatechange = function () {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                const response = JSON.parse(this.responseText)
                addNewConv(response)
                console.log("ajouté new conv ...")
                frmNewConv.classList.add("invisible")
            }
        }
        req.open("POST", "?action=createConv")
        req.setRequestHeader("Content-Type", "application/json")

        if (type1.checked) {
            type = 1
        } else {
            type = 2
        }
        body = {
            user: sltUser.options[sltUser.options.selectedIndex].value,
            type: type
        }
        if (inpGroupName.value != "") {
            body.groupname = inpGroupName.value
        }
        req.send(JSON.stringify(body))
    }
}

//Add new conversation to the list of conversations
function addNewConv(conv) {
    divConv = document.createElement("div")
    divConv.classList.add("oneConv")
    divConv.setAttribute("data-id", conv.id)

    //Create the text displayed depending on the conversation type (private or group):
    if (conv.type == 1) {
        //Search the other member:
        if (conv.members[0].id == user.id) {
            othermember = conv.members[1]
        } else {
            othermember = conv.members[0]
        }

        divConv.innerHTML = "<h4>" + othermember.firstname + " " + othermember.lastname + "</h4>depuis le " + conv.simpledatetime
    } else {
        divConv.innerHTML = "<h4>Groupe: " + conv.name + "</h4>depuis le " + conv.simpledatetime
    }

    counter = 0
    listOfConvs = {}
    //Count the number of conversations loaded and make an array with:
    var els = document.getElementsByClassName("oneConv");
    Array.prototype.forEach.call(els, function (el) {
        listOfConvs[counter].id = el.getAttribute("data-id")
WIP
        counter++
    })

    listConv.insertBefore(divConv, listConv.children[counter])  //insert before the div after the last .oneConv (so after the last .oneConv...)
    EventListenersDeclare() //for add eventlistener on new .oneConv
}

function manageInputGroupName() {
    console.log("manageInputGroupName")
    if (type2.checked == true) {
        divGroupName.classList.remove("invisible")
    } else {
        divGroupName.classList.add("invisible")
    }
}