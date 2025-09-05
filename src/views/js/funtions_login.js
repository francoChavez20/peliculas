async function iniciar_sesion() {
    let usuario = document.querySelector('#usuario').value;
    let password = document.querySelector('#password').value;
    if (usuario =="" || password == "") {
        alert('camos vacios');
        return;
    }
    try{
        // capturamos datos del formulario html
        const datos = new FormData(frmIniciar);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url+'src/controller/login.php?tipo=iniciar_sesion',{
            method: 'POST', 
            mode: 'cors',
            cache:'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            //swal("Iniciar Sesion",json.mensaje,"succes");
            location.replace(base_url+'inicio');
        }else{
            swal("Iniciar Sesion",json.mensaje,"error");
        }
    
        console.log(json);
    }catch(e){
        console.log("oops ocurrio un error"+e);
    }
    
    }


if (document.querySelector('#frmIniciar')) {
    //evita que se envie el formulario
    let frmIniciar = document.querySelector('#frmIniciar');
    frmIniciar.onsubmit = function(e){
        e.preventDefault();  
    iniciar_sesion();
  }
}

async function cerrar_sesion() {
    try{

         let respuesta = await fetch(base_url+'src/controller/login.php?tipo=cerrar_sesion',{
            method: 'POST', 
            mode: 'cors',
            cache:'no-cache',
        });
        json = await respuesta.json();
        if (json.status) {
            //swal("Iniciar Sesion",json.mensaje,"succes");
            location.replace(base_url+'login');
        }
    }catch(e){
        console.log("oops ocurrio un error"+e);
    }
    
}



