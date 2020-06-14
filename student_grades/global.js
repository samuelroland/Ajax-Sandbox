/*
*
*
* */


document.addEventListener("DOMContentLoaded", function () {
    cmdSearch.addEventListener("click", searchNotes)
})

function searchNotes() {
    tbody.innerHTML = ""    //clear content to be able to reload
    tbody.innerText = "Chargement des notes...";    //wait message

    //Ajax call:
    fetch("?action=getGrades")
        .then(function (response) {
            return response.json()
        })
        .then(function (values) {
            tbody.innerHTML = ""    //clear wait message
            pResult.innerText ="Notes de "+ values[0].firstname + " " + values[0].lastname + ":"

            //Foreach element of the array:
            Array.prototype.forEach.call(values, function (el) {
                //Create the line in the table
                tr = document.createElement("tr")
                tbody.appendChild(tr)

                //Create 3 cells for each line and add it to tr as child
                tdModule = document.createElement("td")
                tdDate = document.createElement("td")
                tdValue = document.createElement("td")
                tr.appendChild(tdModule)
                tr.appendChild(tdDate)
                tr.appendChild(tdValue)

                //Initialize values of the 3 cells:
                tdModule.innerText = el.modulename
                tdDate.innerText = el.date
                tdValue.innerText = el.value
            })
        })
}