function avance(){
    document.getElementById('formAdmin').addEventListener('submit', function(event) {
        event.preventDefault();
        const fechas = [
            document.getElementById('fechaProgramado').value,
            document.getElementById('fechaDisenio').value,
            document.getElementById('fechaCorte').value,
            document.getElementById('fechaConfeccon').value,
            document.getElementById('fechaRevfinal').value
        ];
    
        let completed = 0;
        fechas.forEach(fecha => {
            if (fecha !== '') {
                completed++;
            }
        });
    
        const progress = (completed / fechas.length) * 100;
        const progressCircle = document.getElementById('progressCircle');
        progressCircle.textContent = `${progress}%`;
        progressCircle.style.background = `conic-gradient(green ${progress}%, lightgray ${progress}% 100%)`;
    });
}