const formularios_ajax = document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach((formularios)=>{

    formularios.addEventListener("submit",function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Estas seguro?',
            text: "¿Quieres realizar la acción solicitada?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, realizar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let data= new FormData(this);
                let method = this.getAttribute("method");
                let action = this.getAttribute("action");

                let encabezado = new Headers();

                let config={
                    method:method,
                    headers:encabezado,
                    mode:'cors',
                    cache:'no-cache',
                    body : data,

                }
                fetch(action,config).then(respuesta => respuesta.json()).
                                     then(respuesta => {
                                        console.log(respuesta);
                                        return alertas_ajax(respuesta);
                                     }); 
            }
        })
    })
});

function alertas_ajax(alerta) {
    
    if (alerta.tipo=="simple") {
        Swal.fire({
            icon:  alerta.icono,
            title: alerta.titulo,
            text:  alerta.texto,
            confirmButtonText: 'Aceptar'
        });
        
    }else if(alerta.tipo=="recargar"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                location.reload();
            }
        });
    }else if(alerta.tipo=="limpiar"){
        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                document.querySelector(".FormularioAjax").reset();
            }
        });
    }else if(alerta.tipo=="redireccionar"){

        window.location.href=alerta.url;
    }
}
let btn_salir = document.getElementById("btn_exit");

btn_exit.addEventListener("click", function(e){

    e.preventDefault();
    Swal.fire({
        title: '¿Quieres salir del sistema?',
        text: "La sesión",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, salir',
        cancelButtonText: 'cancelar'
    }).then((resultado)=> {
        if(resultado.isConfirmed){
            let url = this.getAttribute("href");
            window.location.href=url;
        }
    })
});