<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des brancardiers</h3>

                <div class="card-tools">
                 <button class="btn btn-success" @click='newModal()'>Ajouter un brancardier
                     <i class="fas fa-user-plus fa-fw"></i>
                     </button>  
                </div> 

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nom</th>
                   
                      <th>Mail</th>
                      <th>Date de création</th>
                      <th>Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="brancardier in brancardiers" :key="brancardier.id">
                      <td>{{brancardier.id}}</td>
                      <td>{{brancardier.name | upText }}</td>
                      <td>{{brancardier.email}}</td>
                      <td>{{brancardier.created_at | myDate }}</td>
                     
                      <td>
<a @click='editModal(brancardier)'>
    <i class="fa fa-edit green" ></i>
</a>

/

<a @click="deleteBran(brancardier.id)">
    <i class="fa fa-trash red"></i>
</a>
                      </td>
                   
                    </tr>                 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show='editMode' class="modal-title" id="exampleModalCenterTitle">Modifier Un Brancardie</h5>               
                <h5 v-show='!editMode' class="modal-title" id="exampleModalCenterTitle">Ajouter Un Brancardie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent=" editMode ? updateBrancardier() : createBrancardier()">
            <div class="modal-body">

                <div class="form-group">
            <input v-model="form.name" type="text" name="name"
            placeholder="Nom"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
            <input v-model="form.email" type="text" name="email"
            placeholder="Email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
            <input v-model="form.password" type="text" name="password"
            placeholder="Password"
                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
                </div>

            </div>
            
            <div class="modal-footer">   
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                <button v-show='editMode' type="submit" class="btn btn-success">Modifier</button>                
                <button v-show='!editMode' type="submit" class="btn btn-primary">Créer</button>
            </div>

            </form>
            </div>
        </div>
        </div>


    </div>
</template>

<script>
        export default {
        data () {
        return {
         editMode:false,
        brancardiers: {},
        form: new Form({
            id:'',
            name: '',
            email: '',
            password: '',
            //remember: false
        })
        }
    },

    methods: {
updateBrancardier(){
  this.$Progress.start();
//console.log('updating data');
this.form.put('api/brancardier/'+this.form.id)
.then(()=>{
  Fire.$emit('AfterCreateBran');
     $('#addnew').modal('hide');
          swal.fire(
                    'Updated !',
                    'Les informations du brancardier est bien modifié.',
                    'success'
                  )
                  this.$Progress.finish();
})
.catch(()=>{
this.$Progress.fail();
})
},
newModal(){
   this.editMode=false;
        this.form.reset();
        $('#addnew').modal('show');

},
editModal(brancardier){
  this.editMode=true;
           this.form.reset();
            $('#addnew').modal('show');
           this.form.fill(brancardier);
},
      loadBrancardier(){
        axios.get('api/brancardier').then(({data})=>(this.brancardiers = data.data));  
      },



      createBrancardier(){
           this.$Progress.start();
           this.form.post('api/brancardier')
           .then(()=>{
            Fire.$emit('AfterCreateBran');
           Toast.fire({
            type: 'success',
            title: 'Brancardier crée avec succès'
          });
          $('#addnew').modal('hide');
           this.$Progress.finish();
           })
           .catch(()=>{})
      },

          deleteBran(id){
          
    swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {

          this.form.delete('api/brancardier/'+id)
          .then(()=>{
          Fire.$emit('AfterCreateBran');
          swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
          })
          .catch(()=>{
          swal.fire(
                    'Failed!',
                    'There was something worng.',
                    'warning'
                  )
          })   
      }
    })
        }
    },

     created() {
            
            this.loadBrancardier();
         //   setInterval(()=>this.loadBrancardier(),3000);
         Fire.$on('AfterCreateBran',()=>this.loadBrancardier());
           
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
