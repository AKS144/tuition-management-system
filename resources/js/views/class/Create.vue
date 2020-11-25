<template>
  <div class="main-content item-create">
    <div class="page-header">
      <h3 class="page-title">{{ isEdit ? $t('class.edit_item') : $t('class.new_item') }}</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link slot="item-title" to="/admin/dashboard">{{ $t('general.home') }}</router-link></li>
        <li class="breadcrumb-item"><router-link slot="item-title" to="/admin/class">{{ $tc('items.item',2) }}</router-link></li>
        <li class="breadcrumb-item"><a href="#"> {{ isEdit ? $t('items.edit_item') : $t('items.new_item') }}</a></li>
      </ol>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <form action="" @submit.prevent="submitClass">
            <div class="card-body">
              <div class="form-group">
                <label class="control-label">{{ $t('items.name') }}</label><span class="text-danger"> *</span>
                <base-input
                  v-model.trim="formData.name"
                  :invalid="$v.formData.name.$error"
                  focus
                  type="text"
                  name="name"
                  @input="$v.formData.name.$touch()"
                />
                <div v-if="$v.formData.name.$error">
                  <span v-if="!$v.formData.name.required" class="text-danger">{{ $t('validation.required') }} </span>
                  <span v-if="!$v.formData.name.minLength" class="text-danger">
                    {{ $tc('validation.name_min_length', $v.formData.name.$params.minLength.min, { count: $v.formData.name.$params.minLength.min }) }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">{{ $t('items.code') }}</label><span class="text-danger"> *</span>
                <base-input
                  v-model.trim="formData.code"
                  :invalid="$v.formData.code.$error"
                  focus
                  type="text"
                  name="code"
                  @input="$v.formData.code.$touch()"
                />
                <div v-if="$v.formData.code.$error">
                  <span v-if="!$v.formData.code.required" class="text-danger">{{ $t('validation.required') }} </span>
                  <span v-if="!$v.formData.code.minLength" class="text-danger">
                    {{ $tc('validation.code_min_length', $v.formData.code.$params.minLength.min, { count: $v.formData.code.$params.minLength.min }) }}
                  </span>
                </div>
              </div>
              <div class="form-group">
                <label>{{ $t('items.tutor') }}</label>
                <base-select
                  v-model="formData.tutor"
                  :options="classTutors"
                  :searchable="true"
                  :show-labels="false"
                  :placeholder="$t('items.select_a_unit')"
                  label="full_name"
                >
                </base-select>
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('items.batch_year') }}</label>
                <base-input
                  v-model.trim="formData.batch_year"
                  :invalid="$v.formData.batch_year.$error"
                  focus
                  type="text"
                  name="batch_year"
                  @input="$v.formData.batch_year.$touch()"
                />
                <span v-if="$v.formData.batch_year.$error && !$v.formData.batch_year.required" class="text-danger"> {{ $t('validation.required') }} </span>
              </div>
              <div class="form-group">
                <base-button
                  :loading="isLoading"
                  :disabled="isLoading"
                  icon="save"
                  color="theme"
                  type="submit"
                  class="collapse-button"
                >
                  {{ isEdit ? $t('items.update_item') : $t('items.save_item') }}
                </base-button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { mapActions, mapGetters } from 'vuex'
const { required, minLength, numeric, minValue, maxLength } = require('vuelidate/lib/validators')

export default {
  mixins: {
    validationMixin
  },
  data () {
    return {
      isLoading: false,
      title: 'Add Class',
      units: [],
      taxes: [],
      tutorName: [],
      taxPerItem: '',
      formData: {
        name: '',
        description: '',
        tutorName: '',
        price: '',
        unit_id: null,
        unit: null,
        taxes: [],
        tax_per_item: false
      title: 'Add Item',
      tutors: [],
      formData: {
        name: '',
        batch_year: '',
        code: '',
        tutor_id: null,
        tutor: null
      },
    }
  },
  computed: {
    ...mapGetters('currency', [
      'defaultCurrencyForInput'
    ]),
    ...mapGetters('item', [
      'itemUnits'
    ]),
    ...mapGetters('tutor', [
      'tutor'
    ]),
    price: {
      get: function () {
        return this.formData.price / 100
      },
      set: function (newValue) {
        this.formData.price = newValue * 100
      }
    },
    ...mapGetters('taxType', [
      'taxTypes'
    ...mapGetters('classroom', [
      'classTutors'
    ]),
    isEdit () {
      if (this.$route.name === 'class.edit') {
        return true
      }
      return false
    },
  },
  created () {
    this.fetchClassTutors()
    if (this.isEdit) {
      this.loadEditData()
    }
  },
  validations: {
    formData: {
      name: {
        required,
        minLength: minLength(3)
      },
      code: {
        required,
        minLength: minLength(3)
      },
      description: {
        maxLength: maxLength(255)
      },
      tutorName: {
        required,
        minLength: minLength(3)
      batch_year: {
        required
      }
    }
  },
  methods: {
    ...mapActions('classroom', [
      'fetchClassTutors',
      'updateClass',
      'addClass',
      'fetchClass'
    ]),
    ...mapActions('modal', [
      'openModal'
    ]),
    async loadEditData () {
      let response = await this.fetchItem(this.$route.params.id)

      this.formData = {...response.data.item, unit: null}
      this.formData.tutorName = this.tutor.find(_tutor => response.data.tutor.tutor_id === _tutor.id)
      this.formData.taxes = response.data.item.taxes.map(tax => {
        return {...tax, tax_name: tax.name + ' (' + tax.percent + '%)'}
      })

      this.formData.unit = this.itemUnits.find(_unit => response.data.item.unit_id === _unit.id)
      this.fractional_price = response.data.item.price
      let response = await this.fetchClass(this.$route.params.id)
      console.log(response)
      this.formData = {...response.data.class, tutor: null}
      
      this.formData.tutor = this.classTutors.find(_tutor => response.data.class.tutor_id === _tutor.id)
    },
    async submitClass () {
      this.$v.formData.$touch()
      if (this.$v.$invalid) {
        return false
      }
      if (this.formData.tutor) {
        this.formData.tutor_id = this.formData.tutor.id
      }
      console.log(this.formData)
      let response
      if (this.isEdit) {
        this.isLoading = true
        response = await this.updateClass(this.formData)
      } else {
        response = await this.addClass(this.formData)
      }
      if (response.data) {
        this.isLoading = false
        window.toastr['success'](this.$tc('items.updated_message'))
        this.$router.push('/admin/class')
        return true
      }
      window.toastr['error'](response.data.error)
    },
  }
}
</script>
