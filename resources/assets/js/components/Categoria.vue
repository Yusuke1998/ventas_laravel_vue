<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Categorías
                    <button type="button" class="btn btn-secondary" @click="abrirModal('categoria','registrar')">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                  <option value="nombre">Nombre</option>
                                  <option value="descripcion">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarCategoria('1',buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarCategoria('1',buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                <td>
                                    <button type="button" @click="abrirModal('categoria','actualizar',categoria)" class="btn btn-warning btn-sm">
                                      <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="categoria.condicion">
                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-trash" @click="desactivarCategoria(categoria.id)"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm">
                                            <i class="icon-check" @click="activarCategoria(categoria.id)"></i>
                                        </button>
                                    </template>

                                </td>
                                <td v-text="categoria.nombre"></td>
                                <td v-text="categoria.descripcion"></td>
                                <td>
                                    <div v-if="categoria.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else="categoria.condicion">
                                        <span class="badge badge-danger">Inactivo</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                    <span class="help-block">(*) Ingrese el nombre de la categoría</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="descripcion" class="form-control" placeholder="Descripcion de la categoria">
                                </div>
                            </div>
                            <hr>
                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMsjCategoria" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1"  @click="registrarCategoria()" class="btn btn-primary">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizarCategoria()" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data() {
            return  {
                categoria_id: 0,
                nombre: '',
                descripcion: '',
                arrayCategoria: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorCategoria: 0,
                errorMsjCategoria: [],
                pagination: {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page': 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        computed: {

            isActived: function(){
                return this.pagination.current_page;
            },
            // Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods: {
            listarCategoria(page, buscar, criterio){
                let me = this;
                var url = '/categorias?page='+ page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                // Actualiza la pagina
                me.pagination.current_page = page;
                // Envia la peticion para visualizar la data de esa pagina
                me.listarCategoria(page, buscar, criterio);
            },
            registrarCategoria(){
                if (this.validarCategoria()) {
                    return;
                }
                let me = this;
                axios.post('/categorias',{
                    'nombre':this.nombre,
                    'descripcion':this.descripcion
                })
                .then(function(response){
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });

            },
            actualizarCategoria(){
                if (this.validarCategoria()) {
                    return;
                }
                let me = this;
                let url = '/categorias/'+this.categoria_id;
                axios.post(url,{
                    '_method':'PUT',
                    'nombre':this.nombre,
                    'descripcion':this.descripcion
                })
                .then(function(response){
                    me.cerrarModal();
                    me.listarCategoria(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            activarCategoria(id){
                let me = this;
                let url = '/categoria/activar/'+id;
                axios.post(url,{
                    '_method':'PUT'
                })
                .then(function(response){
                    me.listarCategoria(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            desactivarCategoria(id){
                let me = this;
                let url = '/categoria/desactivar/'+id;
                axios.post(url,{
                    '_method':'PUT'
                })
                .then(function(response){
                    me.listarCategoria(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            validarCategoria(){
                this.errorCategoria = 0;
                this.errorMsjCategoria = [];
                if (!this.nombre) {
                    this.errorMsjCategoria.push("El nombre de la categoria no puede estar vacio!");
                    this.errorCategoria = 1;

                    return this.errorCategoria;
                }
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "categoria":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tipoAccion = 1;
                                this.modal = 1;
                                this.nombre = '';
                                this.descripcion = '';
                                this.tituloModal = 'Registrar categoria';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.categoria_id = data.id;
                                this.tipoAccion = 2;
                                this.modal = 1;
                                this.nombre = data.nombre;
                                this.descripcion = data.descripcion;
                                this.tituloModal = 'Actualizar categoria';
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.descripcion = '';
                this.errorCategoria = 0;
            }
        },
        mounted() {
            this.listarCategoria(1,this.buscar,this.criterio);

        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
