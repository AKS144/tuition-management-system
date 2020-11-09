<template>
    <form
      id="registerForm"
      @submit.prevent="validateBeforeSubmit"
    >
      <div class="text-sm-left mb-4 text-primary font-weight-bold h3">
        {{ $t('login.register') }}
      </div>
      <!-- {{ csrf_field() }} -->

      <div :class="{'form-group' : true }">
        <p class="input-label">{{ $t('login.full_name') }} <span class="text-danger"> * </span></p>
        <base-input
          :invalid="$v.registerData.full_name.$error"
          v-model="registerData.full_name"
          :placeholder="$t('login.enter_full_name')"
          focus
          type="text"
          name="full_name"
          @input="$v.registerData.full_name.$touch()"
        />
        <div v-if="$v.registerData.full_name.$error">
          <span v-if="!$v.registerData.full_name.required" class="text-danger">
            {{ $tc('validation.required') }}
          </span>
        </div>
      </div>

      <div :class="{'form-group' : true }">
        <p class="input-label">{{ $t('login.email') }} <span class="text-danger"> * </span></p>
        <base-input
          :invalid="$v.registerData.email.$error"
          v-model="registerData.email"
          :placeholder="$t('login.enter_email')"
          focus
          type="email"
          name="email"
          @input="$v.registerData.email.$touch()"
        />
        <div v-if="$v.registerData.email.$error">
          <span v-if="!$v.registerData.email.required" class="text-danger">
            {{ $tc('validation.required') }}
          </span>
          <span v-if="!$v.registerData.email.email" class="text-danger">
            {{ $tc('validation.email_incorrect') }}
          </span>
        </div>
      </div>

      <div class="form-group">
        <p class="input-label">{{ $t('login.password') }} <span class="text-danger"> * </span></p>
        <base-input
            v-model="registerData.password"
            :invalid="$v.registerData.password.$error"
            type="password"
            name="password"
            show-password
            @input="$v.registerData.password.$touch()"
        />
        <div v-if="$v.registerData.password.$error">
            <span v-if="!$v.registerData.password.required" class="text-danger">{{ $tc('validation.required') }}</span>
            <span v-if="!$v.registerData.password.minLength" class="text-danger"> {{ $tc('validation.password_min_length', $v.registerData.password.$params.minLength.min, {count: $v.registerData.password.$params.minLength.min}) }} </span>
        </div>
      </div>

      <div class="form-group">
        <p class="input-label">{{ $t('login.c_password') }} <span class="text-danger"> * </span></p>
        <base-input
            v-model="registerData.c_password"
            :invalid="$v.registerData.c_password.$error"
            type="password"
            name="c_password"
            show-password
            @input="$v.registerData.c_password.$touch()"
        />
        <div v-if="$v.registerData.c_password.$error">
            <span v-if="!$v.registerData.c_password.required" class="text-danger">{{ $tc('validation.required') }}</span>
            <span v-if="!$v.registerData.c_password.minLength" class="text-danger"> {{ $tc('validation.password_min_length', $v.registerData.c_password.$params.minLength.min, {count: $v.registerData.c_password.$params.minLength.min}) }} </span>
            <span v-if="!$v.registerData.c_password.sameAsPassword" class="text-danger"> {{ $tc('validation.password_incorrect') }}</span>
        </div>
      </div>

      <div class="other-actions mb-4">
      <router-link to="login">
        {{ $t('general.back_to_login') }}
      </router-link>
    </div>

      <base-button :loading="isLoading" type="submit" color="theme" class="my-4">{{ $t('login.register') }}</base-button>
    </form>
</template>
<script type="text/babel">
import { mapActions } from 'vuex'
import { validationMixin } from 'vuelidate'
const { required, email, sameAs, minLength } = require('vuelidate/lib/validators')

export default {
    data () {
        return {
        registerData: {
            full_name: '',
            email: '',
            password: '',
            c_password: ''
        },
        submitted: false,
        isLoading: false
        }
    },
    validations: {
        registerData: {
            full_name: {
                required
            },
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(7)
            },
            c_password: {
                required,
                minLength: minLength(7),
                sameAsPassword: sameAs('password')
            }
        }
    },
    methods: {
      ...mapActions('auth', [
        'register'
        ]),
        async validateBeforeSubmit () {
        this.$v.registerData.$touch()
        if (this.$v.$invalid) {
            return true
        }

        this.isLoading = true
        this.register(this.registerData).then((res) => {
            this.$router.push('/login')
            this.isLoading = false
        }).catch(() => {
            this.isLoading = false
        })
        }
    }
}
</script>
