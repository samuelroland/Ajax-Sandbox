/*
*
*
* */


document.addEventListener("DOMContentLoaded", function () {
    cmdSearch.addEventListener("click", searchNotes)
})

function searchNotes() {
    //Ajax call:
    request = new XMLHttpRequest()
    request.onreadystatechange = function () {
        if (this.readyState < XMLHttpRequest.DONE) {
            tbody.innerHTML = ""    //clear content to be able to reload
            tbody.innerText = "Chargement des notes...";    //wait message
        }
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            values = JSON.parse(this.response)  //get response as object

            if (values.hasOwnProperty("error") == false) {
                //Title and preparation of table
                tbody.innerHTML = ""    //clear wait message
                pResult.innerText = "Notes de " + values[0].firstname + " " + values[0].lastname + ":"

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
            } else {
                tbody.innerText = "Error: " + values.error
            }

        }
    }
    bodyPOST = {initials: txtInitials.value}
    request.open("POST", "?action=getGrades")
    //request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    request.setRequestHeader("Content-Type", "application/json")
    request.send(JSON.stringify(bodyPOST))

}