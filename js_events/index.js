parent.addEventListener("click", loadParentCount)
child.addEventListener("click", loadChildCount)

function loadParentCount() {
    //load the counter
    parentcount = document.getElementById("parent-count")
    parentcount.innerText = parseInt(parentcount.innerText, 10) + 1
}

function loadChildCount(event) {
    //load the counter
    childcount = document.getElementById("child-count")
    childcount.innerText = (parseInt(childcount.innerText, 10) + 1).toString()

    event.preventDefault()  //Cancel default behavior for markup <a>: change website location cancelled. The click on the link will only execute the content if loadChildCount()

    event.stopPropagation() //Stop propagation of the event to parents of the element in the same zone of the event location. --> The click on the child, doesn't create an event click on its parent.
}

parent.addEventListener('mousemove', function (event) {
    child = document.getElementById("child")
    if (clicked === true) {
        child.style.top = event.offsetY + "px"
        child.style.left = event.offsetX + "px"
    }

});
var clicked = true
parent.addEventListener('mousedown', function (event) {
    clicked = true
    console.log("clicked true")
});

parent.addEventListener('mouseup', function (event) {
    clicked = false
    console.log("clicked false")
});


