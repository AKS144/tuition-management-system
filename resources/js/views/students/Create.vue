<template>
  <div class="customer-create main-content">
    <form action="" @submit.prevent="submitStudentData">
      <div class="page-header">
        <h3 class="page-title">{{ isEdit ? $t('students.edit_student') : $t('students.new_student') }}</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link slot="item-title" to="/admin/dashboard">{{ $t('general.home') }}</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link slot="item-title" to="/admin/students">{{ $tc('customers.customer', 2) }}</router-link>
          </li>
          <li class="breadcrumb-item">
            {{ isEdit ? $t('students.edit_student') : $t('students.new_student') }}
          </li>
        </ol>
        <div class="page-actions header-button-container">
          <base-button
            :loading="isLoading"
            :disabled="isLoading"
            :tabindex="23"
            icon="save"
            color="theme"
            type="submit"
          >
            {{ isEdit ? $t('students.update_student') : $t('students.save_student') }}
          </base-button>
        </div>
      </div>
      <div class="customer-card card">
        <div class="card-body">
          <div class="row">
            <div class="section-title col-sm-2">{{ $t('students.basic_info') }}</div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.full_name') }}</label><span class="text-danger"> *</span>
                <base-input
                  :invalid="$v.formData.full_name.$error"
                  v-model="formData.full_name"
                  focus
                  type="text"
                  name="full_name"
                  tab-index="1"
                  @input="$v.formData.full_name.$touch()"
                />
                <div v-if="$v.formData.full_name.$error">
                  <span v-if="!$v.formData.full_name.required" class="text-danger">
                    {{ $tc('validation.required') }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.age') }}</label>
                <base-input
                  :invalid="$v.formData.age.$error"
                  v-model.trim="formData.age"
                  type="number"
                  name="age"
                  tab-index="3"
                  @input="$v.formData.age.$touch()"
                />
                <div v-if="$v.formData.age.$error">
                  <span v-if="!$v.formData.age.required" class="text-danger">
                    {{ $tc('validation.required') }}
                  </span>
                  <span v-if="!$v.formData.age.numeric" class="text-danger">
                    {{ $tc('validation.numbers_only') }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.joined_date') }}</label>
                <base-date-picker
                  v-model="formData.date_joined"
                  :calendar-button="true"
                  calendar-button-icon="calendar"
                  @change="$v.formData.date_joined.$touch()"
                />
                <span v-if="$v.formData.date_joined.$error && !$v.formData.date_joined.required" class="text-danger"> {{ $t('validation.required') }} </span>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.nric') }}</label>
                <base-input
                  v-model.trim="formData.nric"
                  type="text"
                  tab-index="2"
                  @input="$v.formData.nric.$touch()"
                />
                <div v-if="$v.formData.nric.$error">
                  <span v-if="!$v.formData.nric.required" class="text-danger">
                    {{ $tc('validation.required') }}
                  </span>
                  <span v-if="!$v.formData.nric.minLength" class="text-danger"> 
                    {{ $tc('validation.nric_minlength', $v.formData.nric.$params.minLength.min, { count: $v.formData.nric.$params.minLength.min }) }} 
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.mobile_no') }}</label>
                <base-input
                  v-model.trim="formData.mobile_no"
                  type="text"
                  name="mobile_no"
                  tab-index="4"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.status') }}</label>
                  <base-select
                    v-model="status_key"
                    :options="status"
                    :allow-empty="false"
                    :searchable="true"
                    :show-labels="false"
                    :tabindex="5"
                    :placeholder="$t('students.set_student_status')"
                    label="key"
                    track-by="key"
                  />
              </div>
            </div>
          </div>          
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MultiSelect from 'vue-multiselect'
import { validationMixin } from 'vuelidate'
import AddressStub from '../../stub/address'
const { required, minLength, url, maxLength, numeric } = require('vuelidate/lib/validators')

export default {
  components: { MultiSelect },
  mixins: [validationMixin],
  data () {
    return {
      isLoading: false,
      formData: {
        full_name: null,
        age: null,
        nric: null,
        mobile_no: null,
        status: null,
        date_joined: null
      },

      status_key: null
    }
  },
  validations: {
    formData: {
      full_name: {
        required
      },
      age: {
        required,
        numeric
      },
      date_joined:{
        required
      },
      nric: {
        required,
        minLength: minLength(7)
      },
    }
  },
  computed: {
    ...mapGetters('user', [
      'status',
    ]),
    isEdit () {
      if (this.$route.name === 'students.edit') {
        return true
      }
      return false
    }
  },
  watch: {
    status_key(key){
      if(key){
        this.formData.status = key
      } else {
        this.formData.status = null
      }
    }
  },
  mounted () {
    if (this.isEdit) {
      this.loadStudent()
    } else {
      this.currency = this.defaultCurrency,
      this.status = this.status
    }
  },
  methods: {
    statusName ({key, value}) {
      return `${key}`
    },
    ...mapActions('student', [
      'addStudent',
      'fetchStudent',
      'updateStudent'
    ]),
    async loadStudent () {
      let { data: { student, parent } } = await this.fetchStudent(this.$route.params.id)

      this.formData.id = student.id
      this.formData.full_name = student.full_name
      this.formData.nric = student.nric
      this.formData.age = student.age
      this.formData.mobile_no = student.mobile_no
      this.formData.status = student.status
      this.formData.date_joined = student.formattedJoinedAt

      this.status_key = student.status
    },
    async submitStudentData () {
      this.$v.formData.$touch()

      if (this.$v.$invalid) {
        return true
      }

      if (this.status_key) {
          this.formData.status = this.status_key.key
        }

      if (this.isEdit) {
        this.isLoading = true
        try {
          console.log(this.formData)
          let response = await this.updateStudent(this.formData)
          console.log(response);
          if (response.data.success) {
            window.toastr['success'](this.$t('students.updated_message'))
            this.$router.push('/admin/students')
            this.isLoading = false
            return true
          } else {
            this.isLoading = false
            if (response.data.error) {
              window.toastr['error'](this.$t('validation.email_already_taken'))
            }
          }
        } catch (err) {
          console.log(err);
        }
      } else {
        this.isLoading = true
        if (this.currency) {
          this.isLoading = true
        }
        try {
          console.log(this.formData)
          let response = await this.addStudent(this.formData)
          if (response.data.success) {
            window.toastr['success'](this.$t('students.created_message'))
            this.$router.push('/admin/students')
            this.isLoading = false
            return true
          }
        } catch (err) {
          console.log(err)
        }
      }
    }
  }
}
</script>
