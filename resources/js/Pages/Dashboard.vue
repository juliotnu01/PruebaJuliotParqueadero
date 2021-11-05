<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">

          <section class="container mx-auto p-6 font-mono">
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
              <div class="w-full overflow-x-auto">
                <nav class="font-sans flex flex-col text-center sm:flex-row sm:text-left sm:justify-between py-4 px-6 bg-white shadow sm:items-baseline w-full">
                    <div class="mb-2 sm:mb-0">
                        <!-- <a href="/home" class="text-2xl no-underline text-grey-darkest hover:text-blue-dark">Home</a> -->
                    </div>
                    <div>
                       <button class="bg-green-500 text-white px-6 py-3 rounded mr-2" @click="showModal()">
                            Agregar Vehiculo
                        </button>
                       <button class="bg-green-500 text-white px-6 py-3 rounded ml-2" @click="d">
                            Descargar Registros Vehiculos
                        </button>
                    </div>
                </nav>
                <table class="w-full">
                  <thead>
                    <tr
                      class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600"
                    >
                      <th class="px-4 py-3">PLACA</th>
                      <th class="px-4 py-3">TELÉFONO</th>
                      <th class="px-4 py-3">COLOR</th>
                      <th class="px-4 py-3">ESTADO</th>
                      <th class="px-4 py-3">ACCIÓN</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <tr class="text-gray-700" v-for="(vehiculo, v) in vehiculos" :key="v">
                      <td class="px-4 py-3 border">
                        <div class="flex items-center text-sm">
                          <div>
                            <p class="font-semibold text-black">{{vehiculo.placa}}</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-ms font-semibold border">{{vehiculo.telefono}}</td>
                      <td class="px-4 py-3 text-xs border">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm"
                        >
                          {{vehiculo.color}}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm border">{{vehiculo.estado_vehiculo == 1 ? 'en parqueadero': 'salieron del parqueadero'}}</td>
                      <td class="px-4 py-3 text-sm border ">
                        <button class="bg-yellow-500 text-white px-6 py-3 rounded mr-2" @click="showModalEdit(vehiculo)">
                            <img src="https://img.icons8.com/material-outlined/24/000000/edit--v1.png"/>
                            Editar
                        </button>
                        <button class="bg-red-500 text-white px-6 py-3 rounded ml-2" @click="deleteVehiculo(vehiculo)">
                            <img src="https://img.icons8.com/material-outlined/24/000000/trash--v1.png"/>
                            Eliminar
                        </button>
                        <button class="bg-purple-500 text-white px-6 py-3 rounded ml-2" @click="updateEstadoVehiculo(vehiculo)">
                            <img src="https://img.icons8.com/ios/24/000000/logout-rounded--v1.png"/>
                            Registrar Ingreso / salida
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
    </div>
    <div v-show="show_modal" class="fixed inset-0 z-30">
        <div v-show="show_modal" @click="showModal()" class="bg-filter bg-white opacity-25 fixed inset-0 w-full h-full z-20">
        </div>
        <main class="flex flex-col items-center justify-center h-full w-full">
            <transition name="fade-up-down">
                <div v-show="show_modal" class="modal-wrapper inline-block flex items-center z-30">
                    <div class="modal max-w-md mx-auto xl:max-w-5xl lg:max-w-5xl md:max-w-2xl bg-white max-h-screen shadow-lg flex-row rounded relative">
                        <!-- <div class="modal-header p-5 bg-gray-900 text-gray-900 rounded-t">
                            <h5 class="text-white text-2xl uppercase">this is header</h5>
                        </div> -->
                        <div class="modal-body p-5 w-full h-full overflow-y-auto ">
                            <p class="text-justify">
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="placa">PLACA</label>
                                    <input v-model="placa" required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="placa" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="placa == ''">Este campo no puede estar vacio</span>
                                </div>
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="telefono">TELEFONO</label>
                                    <input v-model="telefono" required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="telefono" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="telefono == ''">Este campo no puede estar vacio</span>
                                </div>
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="color">COLOR</label>
                                    <input v-model="color" required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="color" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="color == ''">Este campo no puede estar vacio</span>
                                </div>
                            </p>
                        </div>
                        <div class="modal-footer py-3 px-5 border0-t text-right">
                            <button class="bg-green-500 px-5 py-2 text-white" @click="addVehiculo()">Guardar</button>
                        </div>
                    </div>
                </div>
            </transition>
        </main>
    </div>
    <div v-show="show_modal_edit" class="fixed inset-0 z-30">
        <div v-show="show_modal_edit" @click="showModalEdit()" class="bg-filter bg-white opacity-25 fixed inset-0 w-full h-full z-20">
        </div>
        <main class="flex flex-col items-center justify-center h-full w-full">
            <transition name="fade-up-down">
                <div v-show="show_modal_edit" class="modal-wrapper inline-block flex items-center z-30">
                    <div class="modal max-w-md mx-auto xl:max-w-5xl lg:max-w-5xl md:max-w-2xl bg-white max-h-screen shadow-lg flex-row rounded relative">
                        <div class="modal-header p-5 bg-gray-900 text-gray-900 rounded-t">
                            <h5 class="text-white text-2xl uppercase">Editar</h5>
                        </div>
                        <div class="modal-body p-5 w-full h-full overflow-y-auto ">
                            <p class="text-justify">
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="placa">PLACA</label>
                                    <input v-model="vehiculo.placa"  required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="placa" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="vehiculo.placa == ''">Este campo no puede estar vacio</span>
                                </div>
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="telefono">TELEFONO</label>
                                    <input v-model="vehiculo.telefono"  required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="telefono" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="vehiculo.telefono == ''">Este campo no puede estar vacio</span>
                                </div>
                               <div class="mb-4 text-gray-700">
                                    <label class="block mb-1" for="color">COLOR</label>
                                    <input v-model="vehiculo.color"  required class="w-full h-10 px-3 text-base placeholder-gray-600 border border-red-700 rounded-lg focus:shadow-outline" type="text" id="color" />
                                    <span class="text-xs text-red-700" id="passwordHelp" v-if="vehiculo.color == ''">Este campo no puede estar vacio</span>
                                </div>
                            </p>
                        </div>
                        <div class="modal-footer py-3 px-5 border0-t text-right">
                            <button class="bg-green-500 px-5 py-2 text-white" @click="EditVehiculo()">Editar</button>
                        </div>
                    </div>
                </div>
            </transition>
        </main>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent , onMounted} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default defineComponent({
  components: {
    AppLayout,
  },
  data(){
      return {
        show_modal: false,
        show_modal_edit: false,
        placa: '',
        telefono: '',
        color: '',
        estado_vehiculo: '',
        vehiculos: [],
        vehiculo: {
            placa: '',
            telefono: '',
            color: '',
        }
    }
  },
  mounted(){
      this.getVehiculos();
  },
  methods:{
        showModal(){
            if(this.show_modal){
              //stop screen scrolling
              document.getElementsByTagName("html")[0].classList.remove('overflow-y-hidden'); 
              this.show_modal = false;
            }else{
              document.getElementsByTagName("html")[0].classList.add('overflow-y-hidden');
              this.show_modal = true;
            }
        },
        showModalEdit(item){
            if(this.show_modal_edit){
              //stop screen scrolling
              document.getElementsByTagName("html")[0].classList.remove('overflow-y-hidden'); 
              this.show_modal_edit = false;
            }else{
              document.getElementsByTagName("html")[0].classList.add('overflow-y-hidden');
              this.show_modal_edit = true;
            }
            this.vehiculo = item
        },
        async addVehiculo(){
            try{
                var model = {
                    placa: this.placa,
                    telefono: this.telefono,
                    color: this.color,
                    
                };
                if(this.placa == '' || this.telefono == '' ||  this.color == ''){
                    
                }else{
                    let {data} = await axios.post('/api/add-vehiculo', model);
                
                    this.getVehiculos();
                    this.show_modal = false;
                    this.placa = '';
                    this.telefono =  '';
                    this.color =  '';
                }
            }catch(error){

            }
        },
        async getVehiculos(){
            try{
                let {data} = await axios('/api/get-vehiculos');
                this.vehiculos = data
                console.log({V:this.vehiculos})
            }catch(error){
                console.log(error)
            }
        },
        async EditVehiculo(){
            try{ 
                let {data} = await axios.put(`/api/update-vehiculo/${this.vehiculo.id}`, this.vehiculo)
                this.getVehiculos();
                this.show_modal_edit = false
            }catch(error){

            }
        },
        async deleteVehiculo(item){
            try{
                axios.delete(`/api/delete-vehiculo/${item.id}`)
                this.getVehiculos();
            }catch(error){
                console.log(error)
            }
        },
        async updateEstadoVehiculo(item){
            try{    
                axios.put(`/api/update-estado-vehiculo/${item.id}`, item)
                this.getVehiculos();
            }catch(error){
                console.log(error)
            }
        },
        d(){
            axios.post('/api/download-registros-vehiculos')
        }
    }
});
</script>
<style>
  
  .modal-body{
    max-height: 500px;
  }
  .bg-gray-800-opacity{
    background-color: #2D374850;
  }
  @media screen and (max-width: 768px){
    .modal-body {
        max-height: 400px;
    }
  }

  /* animation for vue transition tag */

  .fade-up-down-enter-active {
    transition: all 0.3s ease;
  }
  .fade-up-down-leave-active {
    transition: all 0.3s ease;
  }
  .fade-up-down-enter {
    transform: translateY(10%);
    opacity: 0;
  }
  .fade-up-down-leave-to {
    transform: translateY(10%);
    opacity: 0;
  }

  .fade-enter-active{
      -webkit-transition: opacity 2s;
      transition: opacity .3s;

  }
  .fade-leave-active {
      transition: opacity .3s;
  }

  .fade-enter,
  .fade-leave-to{
      opacity: 0;
  }
  
  
  </style>
