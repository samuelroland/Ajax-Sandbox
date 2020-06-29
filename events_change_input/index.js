/*
 * CodePen Source: https://codepen.io/nicolaspatschkowski/pen/MWwQoQZ
 * Author: Samuel Roland
 */


document.getElementById("name").addEventListener("input", loadText)
document.getElementById("gender").addEventListener("change", loadGender)
result.addEventListener("mousemove", loadMousePosition)

function loadText(event) {
    resText = document.getElementById("res-name")
    resText.innerText = event.target.value
}

function loadGender(event) {
    resgender = document.getElementById("res-gender")
    resgender.innerText = event.target.options[event.target.selectedIndex].innerText
}

function loadMousePosition(event) {
    mouseX = document.getElementById("mouse-x")
    mouseY = document.getElementById("mouse-y")
    mouseX.innerText = event.offsetX
    mouseY.innerText = event.offsetY
}

loadText()
loadGender()
loadMousePosition()