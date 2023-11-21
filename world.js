window.addEventListener('load', (event) => {

    const countryBtn = document.getElementById("lookupCountry")
    const cityBtn = document.querySelector("#lookupCity")
    const resultDiv = document.querySelector("#result")
    const inputField = document.querySelector("#country")

    console.log(countryBtn)

    countryBtn.addEventListener("click", (e) => {
        e.preventDefault()

        let userInput = inputField.value
        userInput.trim()

        let url = `world.php?country=${userInput}&lookup=country`

        fetch(url)
        .then(response => {
            if(response.ok){return response.text()}
            else{return Promise.reject('Something was wrong with fetch request!')}
        })
        .then(data => {
            resultDiv.innerHTML = data
        })
        .catch(error => console.log(`ERROR HAS OCCURRED: ${error}`))
    })

    cityBtn.addEventListener("click", (e) => {
        e.preventDefault()

        let userInput = inputField.value;
        userInput.trim()

        let url = `world.php?country=${userInput}&lookup=city`

        fetch(url)
        .then(response => {
            if(response.ok){return response.text()}
            else{return Promise.reject('Something was wrong with fetch request!')}
        })
        .then(data => {
            resultDiv.innerHTML = data
        })
        .catch(error => console.log(`ERROR HAS OCCURRED: ${error}`))
    })
})