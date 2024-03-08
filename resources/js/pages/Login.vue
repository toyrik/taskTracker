<template>
    <div class="d-flex align-center flex-column">
    <v-form @submit.prevent="submitForm" ref="loginForm">
         <v-card width="400">
            <v-card-title class="text-center my-2">Login</v-card-title>
            <v-card-text>
               <v-text-field label="E-mail" v-model="emailRef" :rules="emailRules" />
               <v-text-field label="Password" type="password" v-model="passwordRef" :rules="passwordRules" />
            </v-card-text>
            <v-card-actions class="d-flex align-center flex-column">
               <v-btn type="submit" border color="#FF9100">
                  Login
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-form>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import store from '../store/index.js'

   const router = useRouter()
   const emailRef = ref('')
   const passwordRef = ref('')
   const loginForm = ref(null)

   const emailRules = ref([
      v => !!v || 'Email is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid'
   ])

   const passwordRules = ref([
      v => !!v || 'Password is required',
      v => (v && v.length >= 6) || 'Name must be at least 6 charachters',
   ])

   const submitForm = async () => {
      const { valid } = await loginForm.value.validate()
      if( valid ) {
         await login()
      }
   }

    const login = async () => {
        await axios({
            method: 'POST',
            url: '/api/login',
            data: {
                email: emailRef.value,
                password: passwordRef.value,
            }
        }).then(res => {
            store.dispatch('UPDATE_ALERT', {
               value: true,
               type: 'success',
               text: 'Login Successful',
            })
            store.dispatch('UPDATE_USER', res.data.data)
            store.dispatch('UPDATE_IS_AUTHENTICATED', true)
            router.push('/dashboard')
        }).catch(error => {
            store.dispatch('UPDATE_ALERT', {
               value: true,
               type: 'error',
               text: 'Login Failed',
            })
            console.log(`error : ${error}`)
        })
    }
</script>
