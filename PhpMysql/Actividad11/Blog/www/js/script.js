function deletePost(id){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.response == "ok"){
                    document.getElementById(`post-id-${id}`).remove();
                    document.getElementById('exampleModalLive').remove();
                    
                }
            }
        };
        xmlhttp.open("GET", `/DATW-DATABASES/PhpMysql/Actividad11/blog/pages/posts/delete.php?id=${id}`, true);
        xmlhttp.send();
}
function removeModal(){
    document.getElementById('exampleModalLive').remove();
}
function alertMessage(id){
    let checkmodel = document.getElementById('exampleModalLive');
    if(checkmodel != null){
        checkmodel.remove();
    }
    let model  = `<div id="exampleModalLive" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" style="background-color: rgb(0 0 0 / 66%); display: block; padding-right: 17px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLiveLabel">Borrar contenido</h5>
          <button type="button" class="close" data-dismiss="modal" onclick="removeModal()" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body bg-dark">
          <p>¿Estas seguro que quieres borrar este contendio?</p>
        </div>
        <div class="modal-footer bg-dark">
          <button type="button" class="btn btn-secondary" onclick="removeModal()" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="deletePost(${id})">Confrimar</button>
        </div>
      </div>
    </div>
  </div>`;
document.body.innerHTML += model;
document.getElementById('exampleModalLive').classList.add("anotherclass");
}



function alertModal(elem, id){
  let checkmodel = document.getElementById('exampleModalLive');
  if(checkmodel != null){
      checkmodel.remove();
  }
  let model  = `<div id="exampleModalLive" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" style="background-color: rgb(0 0 0 / 66%); display: block; padding-right: 17px;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLiveLabel">Cambiar Rol</h5>
        <button type="button" class="close" data-dismiss="modal" onclick="removeModal()" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="outputMessage"></div>
        <form method="post" name="form-cambiar-rol">
        <div class="form-group">
            <label class="control-label" for="rol">Roles</label>
            <select class="form-control" data-val="true" data-val-required="Seleciona un rol" id="rol" name="rol">
                <option value="">Selecciona un rol</option>
                <option value="admin">Administrador</option>
                <option value="user">user</option>
            </select>
        </div>
    </form>
      </div>
      <div class="modal-footer bg-dark">
        <button type="button" class="btn btn-secondary" onclick="removeModal()" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="cambiarRol(${id})">Guardar</button>
      </div>
    </div>
  </div>
</div>`;
document.body.innerHTML += model;
document.getElementById('exampleModalLive').classList.add("anotherclass");
}
function cambiarRol(id){
  let message = document.getElementById('outputMessage');
  let formData = new FormData(document.forms.namedItem("form-cambiar-rol"));
  let rol = formData.get("rol");
  if(rol ==""){
    message.innerHTML = `<div class="alert alert-danger" role="alert">
    Error: Selecciona una rol
  </div>`;
  }else{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if(this.response == "ok"){
            message.innerHTML = `<div class="alert alert-success" role="alert">
    Rol cambiado con exito.
  </div>`;
        }
          
        }
    };
    xmlhttp.open("GET", `./index.php?rol=${rol}&iduser=${id}`, true);
    xmlhttp.send();
  }
}
function renderPartial(element){
  let htmlContentChild ="";
  let tableName = element.innerText.toLowerCase();
  var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //convertir respues a json
              let jsonResult = JSON.parse(this.response);
              let jsonLength = jsonResult.length;
              if(tableName == 'usuarios'){
                for (var i = 0; i < jsonResult.length; ++i) {
                  htmlContentChild += `<tr>
                    <td>${jsonResult[i].nombre}</td>
                    <td>${jsonResult[i].apellidos}</td>
                    <td>${jsonResult[i].email}</td>
                    <td>${jsonResult[i].emailConfirmed}</td>
                    <td>${jsonResult[i].telefono}</td>
                    <td>${jsonResult[i].rol}</td>
                    <td>${jsonResult[i].commentsNum}</td>
                    <td>
                        <button class="btn btn-success" onclick="alertModal(this,${jsonResult[i].id_usuario})">cambiar rol</button>
                    </td>
                  </tr>`;
                }
              }else if(tableName == 'entradas'){
                for (var i = 0; i < jsonResult.length; ++i) {
                  htmlContentChild += `<tr id="post-id-${jsonResult[i].id_post}">
                    <td>${jsonResult[i].titulo}</td>
                    <td>${jsonResult[i].resumen}</td>
                    <td>${jsonResult[i].imgName}</td>
                    <td>${jsonResult[i].fechaEntrada}</td>
                    <td>${jsonResult[i].FechaModificacion}</td>
                    <td>${jsonResult[i].nombreC}</td>
                    <td>${jsonResult[i].nombreU}</td>
                    <td>${jsonResult[i].commentsNum}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-outline-warning" href="../pages/posts/edit.php?id=${jsonResult[i].id_post}"><i class="far fa-edit" aria-hidden="true"></i></a>
                            <a class="btn btn-outline-info" href="../pages/posts/details.php?id=${jsonResult[i].id_post}"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                            <li class="btn btn-danger" onclick="alertMessage(${jsonResult[i].id_post})"><i class="far fa-trash-alt" aria-hidden="true"></i></li>
                        </div>
                    </td>
                  </tr>`;
                }
              }
              crearHtml(htmlContentChild,tableName,jsonLength)
              
          }
      };
      xmlhttp.open("GET", `./index.php?q=${element.innerText.toLowerCase()}`, true);
      xmlhttp.send();
     
}

function crearHtml(htmlContentChild,tableName,jsonLength){
  let htmlContent = document.getElementById('mainContent');
  let theadContent = ``;
if(tableName == 'usuarios'){
    theadContent =`<tr>
    <th>Nombre</th>
      <th>Apellidos</th>
      <th>Email</th>
      <th>Email confirmado</th>
      <th>Telefono</th>
      <th>Rol</th>
      <th>comentarios</th>
      <th></th>
    </tr>`;
}else if (tableName == 'entradas'){
  theadContent = `<tr>
<th>Titúlo</th>
  <th>Resumen</th>
  <th>Imagen</th>
  <th>Fecha de entrada</th>
  <th>Fecha de Modificación</th>
  <th>Categoria</th>
  <th>Escritor</th>
  <th>Comentarios</th>
  <th></th>
</tr>`
}
  let htmlAddToMain = `<div class="mt-4">
  <div class="row">
    <div class="card">
    <div class="card-header bg-secondary">
        ${tableName}
        <div class="float-right">
            ${jsonLength} ${tableName}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    ${theadContent}
                </thead>
                <tbody>
                    ${htmlContentChild}
                </tbody>
            </table>
        </div>
    </div>
    </div>
  </div>
</div>`;
htmlContent.innerHTML = htmlAddToMain;
}