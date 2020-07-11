/*
 * CodePen Source: https://codepen.io/nicolaspatschkowski/pen/OJVQjBq
 * Author: Samuel Roland
 */

form.addEventListener("submit", sendForm)   //at submit of the form, send the form in ajax

function sendForm(event) {
    request = new XMLHttpRequest()  //create the request object
    request.open("POST", "https://mockbin.com/request") //open request with verb + host
    request.setRequestHeader("Content-Type", "application/json")
    bodyPOST = {value: document.getElementById("value").value}
    request.send(JSON.stringify(bodyPOST))
    request.onreadystatechange = function () {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            result.innerText = JSON.parse(JSON.parse(request.response).postData.text).value
        }
    }


    event.preventDefault()  //cancel the default action of the submit of a form (to not reload the page)
}