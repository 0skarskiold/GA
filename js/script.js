let buttonright = document.getElementById("arrow_right")
let buttonleft = document.getElementById("arrow_left")

function scrollright(){
    document.documentElement.scrollTop = 0;
}

function scrolleft(){
    document.documentElement.scrollTop = 0;
}

buttonright.addEventListener('click', scrollright)
buttonleft.addEventListener('click', scrolleft)
