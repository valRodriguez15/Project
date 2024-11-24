let $btnRed = document.getElementById('fechaProgramado').value;
let $btnOrange = document.getElementById('fechaDisenio').value;
let $btnYellow = document.getElementById('fechaCorte').value;
let $btnGreen = document.getElementById('fechaRevfinal').value;
let $btnBlue = document.getElementById('fechaConfeccon').value;
let $btnDefault = document.getElementById('btnDefault');
let box1 = document.querySelector(".box1"),
box2 = document.querySelector(".box2"),
box3 = document.querySelector(".box3"),
box4 = document.querySelector(".box4"),
box5 = document.querySelector(".box5");

function changeEstado1(){
    if ($btnRed.value != ""){
        box1.style.background = "red";
        console.log($btnRed);
    }
}

function changeEstado2(){
    if ($btnOrange.value != ""){
        box2.style.background = "orange";
        console.log($btnRed);
    }
}

function changeEstado3(){
    if ($btnYellow.value != ""){
        box3.style.background = "yellow";
        console.log($btnYellow);
    }
}

function changeEstado4(){
    if ($btnGreen.value != ""){
        box4.style.background = "green";
        console.log($btnGreen);
    }
}

function changeEstado5(){
    if ($btnBlue.value != ""){
        box5.style.background = "blue";
        console.log($btnBlue);
    }
}

function changeColorDefault(){
    if ($btnDefault.value == "Reiniciar"){
        box1.style.background = "grey";
        box2.style.background = "grey";
        box3.style.background = "grey";
        box4.style.background = "grey";
        box5.style.background = "grey";
        console.log($btnDefault);
    }
}