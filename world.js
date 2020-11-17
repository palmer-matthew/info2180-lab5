window.onload = function(event){
    let button = document.querySelector("#lookup");
    let citybutton = document.querySelector("#cities");

    function search(event, context){
        event.preventDefault();
        let user_input = document.querySelector("#country").value;
        user_input = user_input.trim();
        fetch(`world.php?country=${user_input}&context=${context}`)
            .then(response => response.text())
            .then(data => {
                let result_div = document.querySelector("#result");
                result_div.innerHTML = data.trim();
            })
            .catch(error => {
                console.log(error);
            });
    }

    button.addEventListener('click', e => {search(e, "country");});
    citybutton.addEventListener('click', e => {search(e, "city");});


};