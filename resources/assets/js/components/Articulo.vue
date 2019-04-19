<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Articulos
                    <button type="button" class="btn btn-secondary" @click="abrirModal('articulo','registrar')">
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
                                <input type="text" v-model="buscar" @keyup.enter="listarArticulo('1',buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarArticulo('1',buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Precio de venta</th>
                                <th>Stock</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                <td>
                                    <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                      <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="articulo.condicion">
                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-trash" @click="desactivarArticulo(articulo.id)"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm">
                                            <i class="icon-check" @click="activarArticulo(articulo.id)"></i>
                                        </button>
                                    </template>

                                </td>
                                <td v-text="articulo.codigo"></td>
                                <td v-text="articulo.nombre"></td>
                                <td v-text="articulo.nombre_categoria"></td>
                                <td v-text="articulo.precio_venta"></td>
                                <td v-text="articulo.stock"></td>
                                <td v-text="articulo.descripcion"></td>
                                <td>
                                    <div v-if="articulo.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else="articulo.condicion">
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
                                <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de articulo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de articulo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="precio_venta" class="form-control" placeholder="Precio de venta del articulo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="stock" class="form-control" placeholder="Cantidad disponible del articulo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="categoria_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre">Seleccione</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="descripcion" class="form-control" placeholder="Descripcion de la categoria">
                                </div>
                            </div>
                            <hr>
                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMsjArticulo" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1"  @click="registrarArticulo()" class="btn btn-primary">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizarArticulo()" class="btn btn-primary">Actualizar</button>
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
                articulo_id: 0,
                categoria_id: 0,
                nombre_categoria: '',
                precio_venta: 0,
                stock: 0,
                nombre: '',
                codigo: '',
                descripcion: '',
                arrayArticulo: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorArticulo: 0,
                errorMsjArticulo: [],
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
                buscar : '',
                arrayCategoria: []
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
            listarArticulo(page, buscar, criterio){
                let me = this;
                var url = '/articulos?page='+ page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            selectCategoria(){
                let me = this;
                var url = '/select/categorias';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
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
                me.listarArticulo(page, buscar, criterio);
            },
            registrarArticulo(){
                if (this.validarArticulo()) {
                    return;
                }
                let me = this;
                axios.post('articulos',{
                    'codigo':this.codigo,
                    'nombre':this.nombre,
                    'descripcion':this.descripcion,
                    'categoria_id':this.categoria_id,
                    'stock':this.stock,
                    'precio_venta':this.precio_venta
                })
                .then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            actualizarArticulo(){
                if (this.validarArticulo()) {
                    return;
                }
                let me = this;
                let url = '/articulos/'+me.articulo_id;
                axios.post(url,{
                    '_method':'PUT',
                    'codigo':me.codigo,
                    'nombre':me.nombre,
                    'descripcion':me.descripcion,
                    'categoria_id':me.categoria_id,
                    'stock':me.stock,
                    'precio_venta':me.precio_venta
                })
                .then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            activarArticulo(id){
                let me = this;
                let url = '/articulo/activar/'+id;
                axios.post(url,{
                    '_method':'PUT'
                })
                .then(function(response){
                    me.listarArticulo(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            desactivarArticulo(id){
                let me = this;
                let url = '/articulo/desactivar/'+id;
                axios.post(url,{
                    '_method':'PUT'
                })
                .then(function(response){
                    me.listarArticulo(1,'','nombre');
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            validarArticulo(){
                this.errorArticulo = 0;
                this.errorMsjArticulo = [];
                if (!this.nombre) {
                    this.errorMsjArticulo.push("El nombre del articulo no puede estar vacio!");
                    this.errorArticulo = 1;
                }

                if (!this.codigo) {
                    this.errorMsjArticulo.push("El codigo del articulo no puede estar vacio!");
                    this.errorArticulo = 1;
                }

                if (this.categoria_id == 0) {
                    this.errorMsjArticulo.push("Debe seleccionar una categoria!");
                    this.errorArticulo = 1;
                }

                if (!this.stock) {
                    this.errorMsjArticulo.push("El stock del articulo debe ser un numero y no puede estar vacio!");
                    this.errorArticulo = 1;
                }

                if (!this.precio_venta) {
                    this.errorMsjArticulo.push("El precio del articulo debe ser un numero y no puede estar vacio!");
                    this.errorArticulo = 1;
                }
                return this.errorArticulo;
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tipoAccion = 1;
                                this.modal = 1;
                                this.nombre = '';
                                this.descripcion = '';
                                this.categoria_id = 0;
                                this.nombre_categoria = '';
                                this.precio_venta = 0;
                                this.stock = 0;
                                this.codigo = '';
                                this.tituloModal = 'Registrar articulo';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.articulo_id = data.id;
                                this.tipoAccion = 2;
                                this.modal = 1;
                                this.nombre = data.nombre;
                                this.descripcion = data.descripcion;
                                this.categoria_id = data.categoria_id;
                                this.nombre_categoria = data.nombre_categoria;
                                this.precio_venta = data.precio_venta;
                                this.stock = data.stock;
                                this.codigo = data.codigo;
                                this.tituloModal = 'Actualizar articulo';
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.errorArticulo = 0;
                this.nombre = '';
                this.descripcion = '';
                this.categoria_id= 0;
                this.nombre_categoria= '';
                this.precio_venta= 0;
                this.stock= 0;
                this.codigo= '';
            }
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
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
