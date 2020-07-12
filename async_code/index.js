/*
 * CodePen Source: https://codepen.io/nicolaspatschkowski/pen/NWqyaKP
 * Author: Samuel Roland
 */

async function getNumber1() {
    return 10;
}

async function getNumber2() {
    return 4;
}

//Function to create: compute()
async function compute() {
    val1 = await getNumber1()
    val2 = await getNumber2()
    return val1 + val2
}

compute()
    .then(function (total) {
        result.innerText = total
    })