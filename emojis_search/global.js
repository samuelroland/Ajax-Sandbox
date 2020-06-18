/*
*
*
* */

emojis = ["salut", "col"]
document.addEventListener("DOMContentLoaded", function () {
    btnGetEmojis.addEventListener("click", getEmojis)
    inpSearch.addEventListener("keyup", search)
})

function getEmojis() {
    fetch("https://api.github.com/emojis")
        .then(function (response) {
            return response.json()
        })
        .then(function (values) {
            emojis = values
            btnGetEmojis.innerText = "Emojis trouvés!";
            btnGetEmojis.disabled = true
        })
}

function search() {
    ulEmojis.innerHTML = ""
    console.log("search in run")

    Object.keys(emojis).forEach(function (key) {
        console.log(key + ' - ' + emojis[key]);
        if (key.search(inpSearch.value) !== -1) {
            li = document.createElement("li")
            img = document.createElement("img")
            img.src = emojis[key]
            li.innerText = key
            li.appendChild(img)
            ulEmojis.appendChild(li)
        }
    });


}