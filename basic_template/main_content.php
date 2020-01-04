<main class="container-fluid px-0 g-pt-65">
    <div class="row no-gutters g-pos-rel g-overflow-x-hidden">
      <?php include "basic_template/sidebar_nav.php"; ?>
      <div class="col g-ml-45 g-ml-0--lg g-pb-65--md">
        <div class="g-bg-lightblue-v10-opacity-0_5 g-pa-20">
          <div class="row justify-content-center">
          <div class="container">
        <div class="justify-content-center d-flex align-content-center flex-wrap">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>DESCARGA MASIVA  CFDI SAT</h1>
                </div>  
                <div class="col-md-12 row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-info btn-block" onclick="cambiarDiv('login');">Validar Login</button>

                    </div>    
                    <div class="col-md-4">
                    
                       <?php if(isset($_SESSION['token'])){ ?><button type="button" class="btn btn-secondary btn-block" onclick="cambiarDiv('solicitar');">Solicitar consulta</button><?php }?>
                    </div>
                    <div class="col-md-4">
                       <?php if(isset($_SESSION['token'])){ ?><button type="button" class="btn btn-primary btn-block" onclick="cambiarDiv('validar');">Verificar estatus de la consulta</button><?php }?>
                    </div>
                    <div class="col-md-4">                
                       <?php if(isset($_SESSION['token'])){ ?><button type="button" class="btn btn-danger btn-block" onclick="cambiarDiv('descargar');">Obtener paquete</button><?php }?>
                    </div>
                    <div class="col-md-4">
                       <?php if(isset($_SESSION['token'])){ ?><button type="button" class="btn btn-success btn-block" onclick="cambiarDiv('paquete');">Descargar paquete</button><?php }?>
                    </div>
                </div>
                <div id="divFormularios" class="col-md-12">
                <div class="col-md-12 border border-info" id="div_login" style="display:none">
                    <form action="" id="form_login" enctype="multipart/form-data">
                        <label for="cert">Archivo .cert</label><input class="form-control" type="file"  id="cert" name="cert">
                        <label for="key">Archivo .key</label><input class="form-control"  type="file"  id="key" name="key">
                        <button type="button" class="btn btn-info btn-block" onclick="funciones('login');">Validar Login</button>
                    </form>
                </div>
                <div class="col-md-12 border border-secondary" id="div_solicitar" style="display:none">
                    <form action="" id="form_solicitar_consulta" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4"> <label for="token">token</label> <input class="form-control" type="text" id="token" name="token" value="<?php if(isset($_SESSION['token'])){ echo $_SESSION['token']; } ?> " disabled ></div>
                        <div class="col-md-4"> <label for="rfc">RFC*</label> <input class="form-control" type="text" id="rfc" name="rfc"></div>
                        <div class="col-md-4"> <label for="fechaInicial">fechaInicial</label> <input class="form-control" type="date" id="fechaInicial" name="fechaInicial"></div>
                        <div class="col-md-4"> <label for="fechaFinal">fechaFinal</label> <input class="form-control" type="date" id="fechaFinal" name="fechaFinal"></div>
                        <div class="col-md-4"> <label for="TipoSolicitud">TipoSolicitud</label> <select class="form-control"  id="TipoSolicitud" name="tipoSolicitud"><option value="CFDI">CFDI</option><option value="Metadata">Metadata</option></select></div>
                        <div class="col-md-4"><label>_</label><button type="button" class="btn btn-secondary btn-block" onclick="funciones('solicitar_consulta');">Solicitar consulta</button></div>
                    </div>
                    </form>
                </div>
                <div class="col-md-12 border border-primary" id="div_validar" style="display:none">
                    <form action="" id="form_verificar_consulta" enctype="multipart/form-data">
                        <button type="button" class="btn btn-primary btn-block" onclick="funciones('verificar_consulta');">Verificar estatus de la consulta</button>
                    </form>
                </div>
                <div class="col-md-12 border border-danger" id="div_descargar" style="display:none">
                    <form action="" id="descargar" enctype="multipart/form-data">
                        <button type="button" class="btn btn-danger btn-block" onclick="funciones('descargar');">Obtener paquete</button>
                    </form>
                </div>
                <div class="col-md-12 border border-success" id="div_paquete" style="display:none">
                    <form action="" id="form_descargar_paquete" enctype="multipart/form-data">
                        <button type="button" class="btn btn-success btn-block" onclick="funciones('descargar_paquete');">Descargar paquete</button>
                    </form>
                </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 text-center">
                        <h3>Respuesta</h3>
                        <div class="col-md-12 responsive " id="divRespuesta">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h3>Tabla Historial</h3>
                        <table class="table table-bordered">
                            <thead>
                                <th>1</th>
                                <th>1</th>
                                <th>1</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>asdas</td>
                                    <td>1223</td>
                                    <td>1223</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
          </div>
        </div>

      <?php include "basic_template/footer.php"; ?>
      </div>
    </div>
</main>
<script>
cambiarDiv = function(divname){
    $('#divFormularios').children('div').each(function () {
        this.style.display = 'none';
        if(this.id == 'div_'+divname){this.style.display = 'inline-block';}
        console.log(this.id == 'div_'+divname);
        $('#divRespuesta').html('');

    });
}
funciones = function(funcion){
    var formData = new FormData(document.getElementById("form_"+funcion));
    formData.append("accion",funcion);
    if (funcion=='login') {
        formData.append( "cert", $('#cert')[0].files[0]);
        formData.append( "key", $('#key')[0].files[0]);
    } 
    console.log(formData);
    $.ajax({
        type:"POST",
        url:"functions.php",
        datatype:"html",
        data:formData,
        cache:false,
        contentType:false,
        processData:false,
        success:function(data){
            $('#divRespuesta').html('<p style="overflow:scroll">'+data+'</p>');
            if (funcion=='login') {
                // location.reload();
            }
        }
    });
    return false;
}
</script>