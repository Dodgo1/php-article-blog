

let pass1 = document.querySelector("#register_password")
let pass2 = document.querySelector("#register_password2")

function compare(){
    let pass1 = document.querySelector("#register_password")
    let pass2 = document.querySelector("#register_password2")

    if (pass1.value === pass2.value){
        let button = document.querySelector("#register_submit")
        button.setAttribute("type","submit")
    }else{
        let button = document.querySelector("#register_submit")
        button.removeAttribute("type")
    }
}


pass1.addEventListener("input",compare)
pass2.addEventListener("input",compare)