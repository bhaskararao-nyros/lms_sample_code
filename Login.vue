<template>
	<div class="login_blk">

    <!-- NOTIFICATIONS COMPONENT -->
    <notifications group="login_notifications" />
    
    <div class="login_card">
      <h2 class="login_header">
        <h2><img class="logo_image" src="./lms/lms_logo.png"></h2>
        <h2>Logistics Management</h2>
      </h2>
      <b-card class="login_card_blk">
      <div class="text-center" v-if="form_err">
        <p class="text-danger">* {{ err_msg }}</p>
      </div>
        <b-form @submit.prevent="onLogin">
          <b-form-group
            label="Email">
            <b-form-input
              type="email"
              v-model="email"
            >
            </b-form-input>
          </b-form-group>
          <b-form-group label="Password">
            <b-form-input
              type="password"
              v-model="password"
            >
            </b-form-input>
          </b-form-group>
          <b-button class="login_btn" block type="submit" variant="primary">Login</b-button>
        </b-form>
      </b-card>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Login',
  data () {
    return {
    	user_credentials: {
        email: '',
        password: ''
      },
      email: '',
      password: '',
      form_err: false,
      err_msg: ''
    }
  },
  methods: {
    // CALLING NOTIFICATIONS AFTER EACH OPERATION
    callNotification (type,msg) {
      this.$notify({
        group: 'login_notifications',
        type: type,
        title: msg
      });
    },
    onLogin () {
      if (this.email === '') {
        this.form_err = true
        this.err_msg = "Email required"
      } else if (this.password === '') {
        this.form_err = true
        this.err_msg = "Password required"
      } else {
        this.form_err = false
        this.err_msg = ""
      }

      if (!this.form_err) {

        // SETTING USER CREDENTIALS OBJECT
        this.user_credentials.email = this.email
        this.user_credentials.password = this.password

        // CALLING LOGIN_USER ACTIONS METHOD
        this.$store.dispatch('LOGIN_USER', this.user_credentials).then((res)=> {
          console.log('res---', res)
          if (res.status === 'success') {
            if (localStorage.authUser) {
              this.$router.push('/')
            }
            this.resetForm()
            this.callNotification('success',res.msg)
          } else {
            this.callNotification('error',res.msg)
          }
        })
      }
    },
    resetForm () {
      this.email = ''
      this.password = ''
    }
  },
  computed: {

  }
}
</script>

<style>
.login_card_blk {
  padding: 5%;
}
.login_card {
  margin: 7% 30% 10% 30%;
}
.logo_image {
  opacity: 0.8;
  width: 80px;
  background-color: #fff;
  padding: 12px;
  border-radius: 2px;
}
.login_header {
  text-align: center;
  margin-bottom: 5%;
  opacity: 0.9;
}

/*media css*/

@media only screen and (max-width: 700px) {
  .login_card {
    margin: 20% 5% 0% 5%;
  }
  .login_header h2 {
    font-size: 18px;
    margin-bottom: 4%;
  }
  .login_header .logo_image {
    width: 80px;
    background-color: #fff;
    padding: 12px;
    border-radius: 2px;
  }
  .login_card .card-body {
    padding: 5% 3% 15% 3%;
  }
}
</style>