<template>
    <div class="mt-3 col-12">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 float-left">Adminstracion de Trabajos Academicos</h3>
                        <button type="button" class="btn btn-success btn-sm float-right"  @click="openModal">Agregar <i class="fas fa-plus"></i></button>
                    </div>
                    <div class="card-body ">
                        <div class="row p-3"> 
                            <div class="col-2 mt-2">
                                <label class="">Por pagina</label>
                                <b-form-select class="col-4"
                                    v-model="perPage"
                                    id="perPageSelect"
                                    size="sm"
                                    :options="pageOptions"
                                ></b-form-select>             
                            </div>     
                            <div class="col-3">
                            </div>                            
                            <div class="col-6">
                                
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                    <input type="text"  class="form-control"  
                                        @input="getTrabajos()" v-model="search.search"
                                        placeholder="Tema">
                                </div>
                            </div>
                            <div class="col-1 pt-1">
                                <button type="button" class="btn btn-primary btn-sm" v-b-toggle.sidebar-right>
                                    Filtrar <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <b-table class="col-12"
                            bordered
                            striped
                            small
                            responsive 
                            :current-page="currentPage"
                            :per-page="perPage"
                            :items="items"
                            :fields="fields"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            sort-icon-left
                            responsive="sm">
                            <template v-slot:table-colgroup="scope">
                            
                                <col
                                v-for="field in scope.fields"
                                :key="field.key"
                                :style="{ width: field.key === 'accion' ? '180px' : '' }"
                                >
                            </template>

                            <template v-slot:cell(facultad)="row">
                                {{row.item.facultad.nombre}}
                            </template>

                            <template v-slot:cell(escuela)="row">
                                {{row.item.escuela.nombre}}
                            </template>

                            <template v-slot:cell(carrera)="row">
                                {{row.item.carrera.nombre}}
                            </template>

                            <template v-slot:cell(recinto)="row">
                                {{row.item.recinto.nombre}}
                            </template>
                            <template v-slot:cell(ubicacion)="row">
                                {{row.item.ubicacion.nombre}}
                            </template>

                            <template v-slot:cell(accion)="row">
                                <b-button size="sm" @click="row.toggleDetails" class="mr-2" variant="primary">
                                    {{ row.detailsShowing ?  'Ocultar' : 'Mostrar'}} <i class="fas fa-eye"></i>
                                </b-button>
                                <b-button size="sm" variant="warning" @click="editModal(row.item)">
                                    <i class="fas fa-edit"></i>
                                </b-button>
                                <b-button size="sm" variant="danger" :disabled="user.is_admin == 'no'" @click="deleteTrabajo(row.item.key_id)" >
                                    <i class="fas fa-trash"></i>
                                </b-button>
                            </template>

                            <template v-slot:row-details="row">
                                <b-card>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Titulo:</b></b-col>
                                        <b-col>{{ row.item.titulo }}</b-col>
                                    </b-row>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Tema:</b></b-col>
                                        <b-col>{{ row.item.tema }}</b-col>                                        
                                    </b-row>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Nivel:</b></b-col>
                                        <b-col>{{ row.item.nivel }}</b-col>
                                        <b-col sm="3" class="text-sm-right"><b>Tipo de Trabajo:</b></b-col>
                                        <b-col>{{ row.item.tipo_trabajo | upText }}</b-col>
                                    </b-row>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Facultad:</b></b-col>
                                        <b-col>{{ row.item.facultad.nombre }}</b-col>
                                        <b-col sm="3" class="text-sm-right"><b>Escuela:</b></b-col>
                                        <b-col>{{ row.item.escuela.nombre }}</b-col>
                                    </b-row>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Carrera:</b></b-col>
                                        <b-col>{{ row.item.carrera.nombre }}</b-col>
                                        <b-col sm="3" class="text-sm-right"><b>Recinto:</b></b-col>
                                        <b-col>{{ row.item.recinto.nombre }}</b-col>
                                    </b-row>
                                    <b-row class="mb-2">
                                        <b-col sm="3" class="text-sm-right"><b>Ubicacion:</b></b-col>
                                        <b-col>{{ row.item.ubicacion.nombre }}</b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col sm="3" class="text-sm-right"><b>Sustentantes:</b></b-col>
                                        <label v-for="sustentante in row.item.sustentantes">{{sustentante.sustentante.nombre ? ` ** ${sustentante.sustentante.nombre} ** |` : ''}}</label>
                                    </b-row>
                                    <b-row>
                                        <b-col sm="3" class="text-sm-right"><b>Asesores:</b></b-col>
                                        <label v-for="asesor in row.item.asesores">{{asesor.asesor.nombre ? ` ** ${asesor.asesor.nombre} ** |` : ''}}</label>
                                    </b-row>

                                    <b-button size="sm" @click="row.toggleDetails" variant="primary">Ocultar detalles</b-button>
                                </b-card>
                            </template>
                        
                        </b-table>
                        <div class="row pl-3 pr-3">
                            <div class="col-3">
                                <b-pagination
                                    v-model="currentPage"
                                    :total-rows="totalRows"
                                    :per-page="perPage"
                                    align="fill"
                                    size="sm"
                                    class="my-0"
                                ></b-pagination>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-4 text-right">
                                Organizado por: <b>{{ sortBy }}</b>, Orden:
                                <b>{{ sortDesc ? 'Descendente' : 'Ascendente' }}</b>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="createModalLabel">Crear Trabajo</h5>
                        <h5 class="modal-title" v-show="editMode" id="createModalLabel">Actualizar Trabajo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode === true ? updateTrabajo() : createTrabajo()">
                        <div class="modal-body">
                            <b-tabs content-class="mt-3">
                                <b-tab title="General" active>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Facultad</label>
                                            <b-form-select v-model="form.facultad_id" :options="facultades"  @change="getEscuelas(form.facultad_id)"
                                                :class="{ 'is-invalid': form.errors.has('facultad_id') }">
                                                
                                            </b-form-select>
                                            <has-error :form="form" field="facultad_id"></has-error>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Escuela</label>
                                            <b-form-select v-model="form.escuela_id" :options="escuelas" @change="getCarreras(form.escuela_id)"
                                                :class="{ 'is-invalid': form.errors.has('escuela_id') }"
                                            ></b-form-select>
                                            <has-error :form="form" field="escuela_id"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Carrera</label>
                                            <b-form-select v-model="form.carrera_id" :options="carreras" 
                                                :class="{ 'is-invalid': form.errors.has('carrera_id') }"
                                            ></b-form-select>
                                            <has-error :form="form" field="carrera_id"></has-error>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Titulo Obtenido</label>
                                            <input v-model="form.titulo" type="text" name="titulo" @click="getTitulo(form.carrera_id)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('titulo') }">
                                            <has-error :form="form" field="titulo"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Tema</label>
                                            <textarea class="form-control" id="tema" rows="3"
                                                v-model="form.tema" 
                                                name="tema"
                                                :class="{ 'is-invalid': form.errors.has('tema') }">
                                            </textarea>
                                            <has-error :form="form" field="tema"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label  for="fecha_inicio">Fecha inicio</label>
                                                    <b-form-datepicker
                                                        id="fecha_inicio"
                                                        v-model="form.fecha_inicio"
                                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                        locale="es"
                                                        placeholder="Seleccione"
                                                    >
                                                    </b-form-datepicker>
                                                </div> 
                                                <div class="form-group col-6">
                                                    <label  for="fecha_fin">Fecha fin</label>
                                                    <b-form-datepicker
                                                        id="fecha_fin"
                                                        v-model="form.fecha_fin"
                                                        :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                                                        locale="es"
                                                        placeholder="Seleccione"
                                                    >
                                                    </b-form-datepicker>
                                                </div> 
                                            </div>                                            
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Recinto</label>
                                                    <b-form-select v-model="form.recinto_id" :options="recintos"
                                                        :class="{ 'is-invalid': form.errors.has('recinto_id') }">
                                                        
                                                    </b-form-select>
                                                    <has-error :form="form" field="recinto_id"></has-error>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Tipo Trabajo</label>
                                                    <b-form-select v-model="form.tipo_trabajo"
                                                        :class="{ 'is-invalid': form.errors.has('tipo_trabajo') }">
                                                        <option value="tesis">Tesis</option>
                                                        <option value="monografico">Monografico</option>
                                                        
                                                    </b-form-select>
                                                    <has-error :form="form" field="tipo_trabajo"></has-error>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Nivel</label>
                                                    <b-form-select v-model="form.nivel"
                                                        :class="{ 'is-invalid': form.errors.has('nivel') }">
                                                        <option value="grado">Grado</option>
                                                        <option value="maestria">Maestria</option>
                                                        <option value="doctorado">Doctorado</option>
                                                    </b-form-select>
                                                    <has-error :form="form" field="nivel"></has-error>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label>Ubicacion</label>
                                                    <b-form-select v-model="form.ubicacion_id" :options="ubicaciones"
                                                        :class="{ 'is-invalid': form.errors.has('ubicacion_id') }">
                                                        
                                                    </b-form-select>
                                                    <has-error :form="form" field="ubicacion_id"></has-error>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </b-tab>
                                <b-tab v-if="editMode" title="Participantes Y Asesores">
                                    <h3>Participantes</h3>
                                    <div class="row mt-3">
                                        <div class="form-group col-6">
                                            <label>Participante</label>                        
                                            <b-form-input list="participante-search" v-model="participante.participante_search" @input="getParticipanteList()"></b-form-input>                                            
                                            <b-form-datalist  id="participante-search" >
                                                <option v-for="participante in participante.list" :key="participante.id" :value="participante.nombre"/>
                                            </b-form-datalist > 
                                        </div>
                                        <div class="form-group col-1 p-2 text-center">
                                            <b-button  class="mt-4 " variant="success" @click="createSustentante()" >
                                                <i class="fas fa-plus"></i>
                                            </b-button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <b-table  ref="sustentante_tbl" class="col-12"                                    
                                            striped
                                            small
                                            bordered 
                                            :fields="participante.fields" 
                                            :items="participante.items"                                        
                                            responsive="sm">
                                            <template v-slot:table-colgroup="scope">                            
                                                <col
                                                v-for="field in scope.fields"
                                                :key="field.key"
                                                :style="{ width: field.key === 'accion' ? '100px' : ''}"
                                                >
                                            </template>
                                            <template v-slot:cell(nombre)="row">
                                                {{row.item.sustentante.nombre}}
                                            </template>

                                            <template v-slot:cell(matricula)="row">
                                                {{row.item.sustentante.matricula}}
                                            </template>
                                            
                                            <template v-slot:cell(accion)="row">                                               
                                                <b-button size="sm"  variant="danger" @click="deleteSustentante(row.item.key_id)">
                                                    <i class="fas fa-trash"></i>
                                                </b-button>
                                            </template>
                                        </b-table>
                                    </div>
                                    
                                    <h3>Asesores</h3>
                                    <div class="row mt-3">
                                        <div class="form-group col-6">
                                            <label>Asesor</label>
                                            <b-form-input list="asesor-search" v-model="asesor.asesor_search" @input="getAsesorList()"></b-form-input>                                            
                                            <b-form-datalist  id="asesor-search" >
                                                <option v-for="asesor in asesor.list" :key="asesor.id" :value="asesor.nombre"/>
                                            </b-form-datalist > 
                                        </div>
                                        <div class="form-group col-1 p-2 text-center">
                                            <b-button  class="mt-4 " variant="success" @click="createAsesor()" >
                                                <i class="fas fa-plus"></i>
                                            </b-button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <b-table  ref="" class="col-12"                                    
                                            striped
                                            small
                                            bordered 
                                            :fields="asesor.fields" 
                                            :items="asesor.items" 
                                            
                                            responsive="sm">
                                            <template v-slot:table-colgroup="scope">                            
                                                <col
                                                v-for="field in scope.fields"
                                                :key="field.key"
                                                :style="{ width: field.key === 'accion' ? '100px' : '' }"
                                                >
                                            </template>
                                            <template v-slot:cell(nombre)="row">
                                                {{row.item.asesor.nombre}}
                                            </template>

                                            <template v-slot:cell(telefono)="row">
                                                {{row.item.asesor.telefono}}
                                            </template>
                                            
                                            <template v-slot:cell(accion)="row">                                               
                                                <b-button size="sm"  variant="danger"  @click="deleteAsesor(row.item.key_id)">
                                                    <i class="fas fa-trash"></i>
                                                </b-button>
                                            </template>
                                        </b-table>
                                    </div>
                                    
                                </b-tab>
                            </b-tabs>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button v-show="editMode" type="submit" class="btn btn-warning">Actualizar</button>
                            <button v-show="!editMode" type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <b-sidebar id="sidebar-right" title="Busqueda" right shadow>
            <div class="px-3 py-2">                
                <div class="row">
                    <div class="form-group col-12">
                        <label>Facultad</label>
                        <b-form-select v-model="search.facultad_id" :options="facultades"  @change="getEscuelas(search.facultad_id)">                            
                        </b-form-select>
                    </div>
                    <div class="form-group col-12">
                        <label>Escuela</label>
                        <b-form-select v-model="search.escuela_id" :options="escuelas" @change="getCarreras(search.escuela_id)"
                        ></b-form-select>
                    </div>                                    
                    <div class="form-group col-12">
                        <label>Carrera</label>
                        <b-form-select v-model="search.carrera_id" :options="carreras" 
                        ></b-form-select>
                    </div>      
                    <div class="form-group col-12">
                        <label>Recinto</label>
                        <b-form-select v-model="search.recinto_id" :options="recintos"
                        ></b-form-select>
                    </div>                                    
                    <div class="form-group col-12">
                        <label>Ubicacion</label>
                        <b-form-select v-model="search.ubicacion_id" :options="ubicaciones" 
                        ></b-form-select>
                    </div>                   
                </div>  
                <div class="form-group mt-5 float-left">
                    <button type="button" class="btn btn-primary" @click="getTrabajos()">
                            Buscar <i class="fas fa-search"></i>
                    </button>
                </div>                 
                <div class="form-group mt-5 float-right">
                    <button type="button" class="btn btn-secondary" @click="searchCleaner()">
                            Limpiar busqueda <i class="fas fa-trash"></i>
                    </button>
                </div> 
                                
            </div>
        </b-sidebar>
    </div>
</template>

<script>
    export default {
        created() {
            this.user = user;
            this.getTrabajos();
            this.getFacultades();  
            this.getRecintos();
            this.getUbicaciones();
            Fire.$on('AfterEvent',()=>{
                this.getTrabajos();
            });
        },
        data() {
            return {
                pageOptions: [10, 25, 50, 100],
                currentPage: 1,
                perPage: 10,
                sortBy: 'tema',
                sortDesc: false,
                fields: [
                    { key: 'tema', sortable: true },
                    { key: 'facultad', sortable: true },
                    { key: 'escuela',  sortable: true },
                    { key: 'carrera',  sortable: true },
                    { key: 'recinto', sortable: true },
                    { key: 'ubicacion', sortable: true},
                    { key: 'accion'}
                ],
                items: [],
                totalRows:0,
                editMode: false,                
                search:{
                    search: '',
                    facultad_id: 0,
                    escuela_id: 0,
                    carrera_id: 0,
                    recinto_id: 0,
                    ubicacion_id: 0
                },
                form: new Form({
                    id: 0,
                    facultad_id: 0,
                    escuela_id: 0,
                    carrera_id: 0,
                    recinto_id:0,
                    ubicacion_id: 0,
                    tipo_trabajo: '',
                    nivel: '',
                    tema: '',
                    titulo: '',
                    fecha_inicio: null,
                    fecha_fin: null,
                    key_id: ''
                }),
                participante:{
                    id: 0,
                    first:{},
                    participante_search:'',
                    list: [],
                    fields: [
                        { key: 'nombre', sortable: true },
                        { key: 'matricula', sortable: true },
                        { key: 'accion'}
                    ],
                    items: []
                },
                asesor:{
                    id: 0,
                    list: [],
                    first:{},
                    asesor_search: '',
                    fields: [
                        { key: 'nombre', sortable: true },
                        { key: 'telefono', sortable: true },
                        { key: 'accion'}
                    ],
                    items: []
                },
                facultades: [],
                escuelas:[],
                carreras:[],
                recintos:[],
                ubicaciones:[],
                user: null,
            }
        },
        methods:{
            getTrabajos(url = base_url + '/api/trabajo/'){

                let parametro = true;

                if(this.search.search == '' && this.search.facultad_id == 0 && this.search.escuela_id
                    &&this.search.carrera_id && this.search.recinto_id && this.search.ubicacion_id){
                        parametro = false;
                }

                axios.get(url, {params: {
                    parametro: parametro,
                    search:this.search.search,
                    facultad_id:this.search.facultad_id,
                    escuela_id:this.search.escuela_id,
                    carrera_id:this.search.carrera_id,                    
                    recinto_id:this.search.recinto_id,
                    ubicacion_id:this.search.ubicacion_id,
                }})
                .then(response => {
                    let data =  response.data;
                    this.items = data;
                    this.totalRows = data.length
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getFacultades(url = base_url + '/api/facultad/list/'){
                axios.get(url)
                .then(response => {
                    let data =  response.data.data;
                    this.facultades = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getEscuelas(facultad_id){
                axios.get(base_url + '/api/escuela/list/' + facultad_id)
                .then(response => {
                    let data =  response.data.data;
                    this.escuelas = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getCarreras(escuela_id){
                axios.get(base_url + '/api/carrera/list/' + escuela_id)
                .then(response => {
                    let data =  response.data.data;
                    this.carreras = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getTitulo(carrera_id){
                const resultado = this.carreras.find(carrera => carrera.value === carrera_id);
                this.form.titulo = resultado.titulo;
            },
            getRecintos(url = base_url + '/api/recinto/list/'){
                axios.get(url)
                .then(response => {
                    let data =  response.data.data;
                    this.recintos = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getUbicaciones(url = base_url + '/api/ubicacion/list/'){
                axios.get(url)
                .then(response => {
                    let data =  response.data.data;
                    this.ubicaciones = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            openModal(){
                this.editMode = false;
                this.form.reset();
                $('#createModal').modal('show');
            },
            createTrabajo(){          
                this.$Progress.start();  
                this.form.post('api/trabajo')
                .then(()=>{            
                    Fire.$emit('AfterEvent');                           
                    $('#createModal').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'El estatus ha sido creada.'
                    }); 
                    this.$Progress.finish();                   
                })
                .catch(()=>{
                    swal.fire('Error!','Hubo un error','error');
                });
            },
            editModal(trabajo){               
                this.form.reset();
                this.editMode = true,                
                $('#createModal').modal('show');
                this.form.fill(trabajo);
                this.getEscuelas(0);
                this.getCarreras(0);
                this.getSustentantes();
                this.getAsesores();
            },
            updateTrabajo(){
                this.$Progress.start();
                this.form.put('api/trabajo/'+this.form.key_id)
                .then(()=>{
                    $('#createModal').modal('hide');
                    swal.fire(
                        'Actualizado!',
                        'El trabajo ha sido actualizado',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterEvent'); 
                    
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            deleteTrabajo(key_id){
                swal.fire({
                    title: 'Estas seguro?',
                    text: "No Podras Revertir Esta accion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!'
                }).then((result) => {
                    if (result.value) { 
                        this.form.delete('api/trabajo/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El trabajo ha sido eliminado.',
                                'success'
                            );
                            Fire.$emit('AfterEvent');    
                        }).catch(()=>{
                            swal.fire('Error!','Ha ocurrido un error','error');
                            this.$Progress.fail();
                        });
                    }
                    
                });
            },
            getSustentantes(url = base_url + '/api/trabajo-sustentate/'+this.form.id){
                axios.get(url)
                .then(response => {
                    let data =  response.data;
                    this.participante.items = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getAsesores(url = base_url + '/api/trabajo-asesor/'+this.form.id){
                axios.get(url)
                .then(response => {
                    let data =  response.data;
                    this.asesor.items = data;
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            createSustentante(){
                if(!this.participante.first.id){
                    swal.fire('Error!','Debe Seleccionar un participante','error');
                }else{
                    let to_send = {
                        sustentante_id : this.participante.first.id,
                        trabajo_id : this.form.id
                    };

                    axios.post(base_url + '/api/trabajo-sustentate/', to_send)
                    .then(()=>{
                            toast.fire({
                            icon: 'success',
                            title: 'Registro insertado correctamente.'
                        }); 

                        this.participante.first = null;
                        this.participante.participante_search = null;
                        this.getSustentantes();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });      
                }
            },
            deleteSustentante(key_id){
                swal.fire({
                    title: 'Estas seguro?',
                    text: "No Podras Revertir Esta accion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!'
                }).then((result) => {
                    if (result.value) { 
                        this.form.delete('api/trabajo-sustentate/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El sustentate ha sido eliminado.',
                                'success'
                            );
                            this.getSustentantes();
                            Fire.$emit('AfterEvent');    
                        }).catch(()=>{
                            swal.fire('Error!','Ha ocurrido un error','error');
                            this.$Progress.fail();
                        });
                    }
                    
                });
                
            },
            createAsesor(){
                if(!this.asesor.first.id){
                    swal.fire('Error!','Debe Seleccionar un asesor','error');
                }else{
                    let to_send = {
                        asesor_id : this.asesor.first.id,
                        trabajo_id : this.form.id
                    };
                    axios.post(base_url + '/api/trabajo-asesor/', to_send)
                    .then(()=>{
                            toast.fire({
                            icon: 'success',
                            title: 'Registro insertado correctamente.'
                        }); 

                        this.asesor.first = null;
                        this.asesor.asesor_search = null;
                        this.getAsesores();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });      
                }
            },
            deleteAsesor(key_id){
                swal.fire({
                    title: 'Estas seguro?',
                    text: "No Podras Revertir Esta accion!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminalo!'
                }).then((result) => {
                    if (result.value) { 
                        this.form.delete('api/trabajo-asesor/'+key_id).then(()=>{ 
                            swal.fire(
                                'Eliminado!',
                                'El asesor ha sido eliminado.',
                                'success'
                            );
                            this.getAsesores();
                            Fire.$emit('AfterEvent');    
                        }).catch(()=>{
                            swal.fire('Error!','Ha ocurrido un error','error');
                            this.$Progress.fail();
                        });
                    }
                    
                });

                
            },
            getParticipanteList(url = base_url + '/api/sustentante/list/'){
                axios.get(url, {params: {search:this.participante.participante_search}})
                .then(response => {
                    let data = response.data.data;
                    this.participante.list = data;
                    this.participante.first = this.participante.list[0];
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            getAsesorList(url = base_url + '/api/asesor/list/'){
                axios.get(url, {params: {search:this.asesor.asesor_search}})
                .then(response => {
                    let data = response.data.data;
                    this.asesor.list = data;
                    this.asesor.first = this.asesor.list[0];
                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            searchCleaner(){
                this.search.search = '';
                this.search.facultad_id = 0;
                this.search.escuela_id = 0;
                this.search.carrera_id = 0;
                this.search.recinto_id = 0;
                this.search.ubicacion_id = 0;
            }
        }
    }
</script>