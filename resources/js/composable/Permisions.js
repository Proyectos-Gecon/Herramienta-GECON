import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';


export function permisos(array){ 

    var val = false
   
    array.forEach(function(permiso){
        if(Inertia.page.props.user.permisos.includes(permiso) ){
            val =  true
        }
    })
 
    return {val}
}
