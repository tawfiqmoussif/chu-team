<template>
  

<div class="modal fade login " id="loginModal">
		      <div class="modal-dialog modal-dialog-centered modal-lg animated" >
    		      <div class="modal-content">
    		         <div class="modal-header">
                       <h5 class="modal-title">login</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
                    </div>
                    <div class="modal-body">
                        <div class="box">
                             <div class="content">
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <form method="" action="" accept-charset="UTF-8">
                                    <input id="email" v-model="email" class="form-control mb-3 mt-3" type="text" placeholder="Email" name="email">
                                    <input id="password" v-model="password" class="form-control mb-4" type="password" placeholder="Password" name="password">
                                    <input class="btn btn-teal btn-lg btn-block mb-2" @click="attemptLogin()" :disabled="!isValidLoginForm" type="button" value="Login" >
                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form ">
                                <form method="" html="{:multipart=>true}" data-remote="true" action="" accept-charset="UTF-8">
                                <input id="name" v-model="name" class="form-control " type="text" placeholder="Name" name="name">
                                <input id="email" v-model="remail" class="form-control" type="text" placeholder="Email" name="email">
                                <input id="password"  v-model="rpassword" class="form-control" type="password" placeholder="Password" name="password">
                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-teal btn-lg btn-block"  type="button" value="Create account" name="commit">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                             <span>Already have an account?</span>
                             <a href="javascript: showLoginForm();">Login</a>
                        </div>
                    </div>
    		      </div>
		      </div>
		  </div>
</template>
<script type="text/javascript">
   /* $(document).ready(function(){
        openLoginModal();// for open modal automaticly
    });*/
    import axios from 'axios'
     export default {
       data(){
         return{
           email: 'hi',
           password: '',
         }
       },
       computed: {
        isValidLoginForm(){
         return this.emailIsValid() && this.password 
        }
       },
       methods: {
         emailIsValid(mail) 
            {
              if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
                {
                  return (true)
                }
                  return (false)
            },
        attemptLogin(){
           this.$Progress.start();
            axios.post('/login',{
              email: this.email, password: this.password
            }).then(resp =>{
              console.log('nja7t'),
              location.reload()
              this.$Progress.finish();
             //redirectTo()
            }).catch(error => {
              this.$Progress.fail(),
              loginAjax(),
              console.log('khsart')
            },
              
              
            )
        },
        

       },
        mounted() {
            console.log('hi im tawfiq')
        }
    }
</script>