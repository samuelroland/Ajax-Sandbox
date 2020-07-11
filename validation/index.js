/*
 * CodePen Source: https://codepen.io/nicolaspatschkowski/pen/GRJQvGY
 * Author: Samuel Roland
 */

//Variables and events declarations
codeValid = document.getElementById("code-validation")
code.addEventListener("input", checkCode)
btnSubmit = document.getElementById("submit-btn")

//INFO: regex in js start and finish with "/" but not in HTML in the attribut pattern !
//Ex: in JS--> /^CODE-/test(code.value) and in HTML--> pattern="^CODE-"

//Check validity of the code value
function checkCode() {
    if (/^CODE-/.test(code.value) == true) {    //regex: if start with "CODE-" value it's valid
        codeValid.innerText = "Code valide"
        btnSubmit.removeAttribute("disabled")
    } else {    //else display invalid and disable the submit button
        codeValid.innerText = "Code invalide"
        btnSubmit.setAttribute("disabled", true)
    }
}

checkCode()