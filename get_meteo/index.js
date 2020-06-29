/*
 * CodePen Source: https://codepen.io/nicolaspatschkowski/pen/QWbQMOe
 * Author: Samuel Roland
 */

document.getElementById("ask-weather").addEventListener("click", askWeather)

function askWeather() {
    request = new XMLHttpRequest()  //create the request object
    //Set attribute "onreadystatechange" with the function to execute. "onreadystatechange" is an event like "click" called "onclick" if set as attribute.
    /*
    * Example for a better understanding:
    * request.addEventListener("readystatechange", function() {...})
    *
    * is equal to:
    * request.onreadystatechange = function() {...}
    *
    * and in HTML for a button for ex, that execute the function "test()" when the event click start:
    * <button id="btnTest" onclick="test()" />
    * */

    request.onreadystatechange = function () {
        //write "this" is equal to write "event.target"
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) { //if the request is DONE so the state is 4. and if the request is success.
            var response = JSON.parse(this.responseText);   //parse in JSOn the response of the request
            console.log(response.current_condition.condition);  //display one field of the data received
        }
    };
    request.open("GET", "https://www.prevision-meteo.ch/services/json/paris")   //prepare the request with method and url
    request.send()
}