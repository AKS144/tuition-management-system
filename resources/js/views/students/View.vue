<template>
  <div class="customer-create main-content">
    <form action="" @submit.prevent="submitStudentData">
      <div class="page-header">
        <h3 class="page-title">{{ $t('students.view_student') }}</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link slot="item-title" to="/admin/dashboard">{{ $t('general.home') }}</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link slot="item-title" to="/admin/students">{{ $tc('students.student', 2) }}</router-link>
          </li>
          <li class="breadcrumb-item">
            {{ $t('students.view_student') }}
          </li>
        </ol>
      </div>
      <div class="customer-card card">
        <div class="card-body">
          <div class="row">
            <div class="section-title col-sm-2">{{ $t('students.basic_info') }}</div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.full_name') }}</label>
                <base-input
                  :readOnly="true"
                  v-model="formData.full_name"
                  type="text"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.age') }}</label>
                <base-input
                  :readOnly="true"
                  v-model.trim="formData.age"
                  type="text"
                  name="age"
                  tab-index="3"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.joined_date') }}</label>
                <base-input
                  :readOnly="true"
                  v-model.trim="formData.joined_date"
                  type="text"
                  name="joined_date"
                  tab-index="3"
                />
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.nric') }}</label>
                <base-input
                  v-model.trim="formData.nric"
                  :readOnly="true"
                  type="text"
                  name="nric"
                  tab-index="2"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.mobile_no') }}</label>
                <base-input
                  v-model.trim="formData.mobile_no"
                  :readOnly="true"
                  type="text"
                  name="mobile_no"
                  tab-index="4"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.status') }}</label>
                <base-input
                  v-model.trim="formData.status"
                  :readOnly="true"
                  type="text"
                  name="status"
                  tab-index="4"
                />
              </div>
            </div>
          </div>
          <hr> <!-- first row complete  -->
            <div class="section-title col-sm-2">{{ $t('students.parent_info') }}</div>
          <div v-for="(item, index) in parents" v-if="item !== null" class="row">
            <div class="section-title col-sm-2"></div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.full_name') }}</label>
                <base-input
                  v-model="item.full_name"
                  :readOnly="true"
                  type="text"
                  tab-index="7"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.email') }}</label>
                <base-input
                  v-model.trim="item.email"
                  :readOnly="true"
                  type="text"
                  name="email"
                  tab-index="7"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.mobile_no') }}</label>
                <base-input
                  v-model.trim="item.mobile_no"
                  :readOnly="true"
                  type="text"
                  name="mobile_no"
                  tab-index="13"
                />
              </div>
              <div v-if="item.addresses !== null" class="form-group">
                <label class="form-label">{{ $t('students.state') }}</label>
                <base-input
                  v-model="item.addresses.state"
                  :readOnly="true"
                  type="text"
                  tab-index="9"
                />
              </div>
              <div v-if="item.addresses !== null" class="form-group">
                <label class="form-label">{{ $t('students.address') }}</label>
                <base-text-area
                  v-model.trim="item.addresses.address_street_1"
                  :placeholder="$t('general.street_1')"
                  :readOnly="true"
                  type="text"
                />
                <base-text-area
                  v-model.trim="item.addresses.address_street_2"
                  :placeholder="$t('general.street_2')"
                  :readOnly="true"
                  type="text"
                />
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="form-label">{{ $t('students.nric') }}</label>
                <base-input
                  v-model.trim="item.nric"
                  :readOnly="true"
                  type="text"
                  name="nric"
                  tab-index="7"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.job') }}</label>
                <base-input
                  v-model.trim="item.job"
                  :readOnly="true"
                  type="text"
                  name="job"
                  tab-index="7"
                />
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('students.relationship') }}</label>
                <base-input
                  v-model.trim="item.type"
                  :readOnly="true"
                  type="text"
                  tab-index="7"
                />
              </div>
              <div v-if="item.addresses !== null" class="form-group">
                <label class="form-label">{{ $t('students.country') }}</label>
                <base-input
                  v-model.trim="item.addresses.country.name"
                  label="country"
                  track-by="id"
                />
              </div>
              <div v-if="item.addresses !== null" class="form-group">
                <label class="form-label">{{ $t('students.city') }}</label>
                <base-input
                  v-model="item.addresses.city"
                  :readOnly="true"
                  type="text"
                  tab-index="10"
                />
              </div>
              <div v-if="item.addresses !== null" class="form-group">
                <label class="form-label">{{ $t('students.zip_code') }}</label>
                <base-input
                  v-model.trim="item.addresses.zip"
                  :readOnly="true"
                  type="text"
                  tab-index="14"
                />
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MultiSelect from 'vue-multiselect'
import AddressStub from '../../stub/address'
const { required, minLength, email, url, maxLength } = require('vuelidate/lib/validators')

export default {
  components: { MultiSelect },
  data () {
    return {
      isLoading: false,
      formData: {
        full_name: null,
        age: null,
        nric: null,
        mobile_no: null,
        status: null,
        joined_date: null,
        addresses: []
      },
      parents: {
        full_name: null,
        email: null,
        nric: null,
        job: null,
        relationship: null,
        country: null,
        state: null,
        city: null,
        mobile_no: null,
        zip: null,
        address_street_1: null,
        address_street_2: null,
      },
    }
  },
  mounted () {
      this.loadStudent()
  },
  methods: {
    ...mapActions('student', [
      'fetchStudent',
    ]),
    async loadStudent () {
      let { data: { student, parent }}  = await this.fetchStudent(this.$route.params.id)

      this.formData.id = student.id
      this.formData.full_name = student.full_name
      this.formData.nric = student.nric
      this.formData.age = student.age
      this.formData.mobile_no = student.mobile_no
      this.formData.status = student.status
      this.formData.joined_date = student.formattedJoinedAt

      this.parents = parent
    }
  }
}
</script>
