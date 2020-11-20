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
                try{
                    json = JSON.parse(data);
                }catch(e){
                    json = "no errors";
                }    

                if(json != "no errors"){
                    let result_div = document.querySelector("#result");
                    result_div.classList.add("noresults");
                    result_div.innerHTML = "SOMETHING WENT WRONG. SERVER ERROR";
                }else{
                    let result_div = document.querySelector("#result");
                    if(data.trim() == "NO SEARCH RESULTS FOUND"){
                        result_div.classList.add("noresults");
                        result_div.innerHTML = data.trim();
                    }else{
                        result_div.classList.remove("noresults");
                        result_div.innerHTML = data.trim();
                    }
                }
            })
            .catch(error => {
                console.log(error);
            });
    }

    button.addEventListener('click', e => {search(e, "country");});
    citybutton.addEventListener('click', e => {search(e, "city");});


};