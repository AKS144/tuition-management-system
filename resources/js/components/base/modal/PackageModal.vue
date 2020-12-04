<template>
  <div class="category-modal">
    <form action="" @submit.prevent="submitPackageData">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('packages.category') }}<span class="required text-danger">*</span></label>
          <div class="col-sm-7">
            <base-input
              ref="name"
              :invalid="$v.formData.name.$error"
              v-model="formData.name"
              type="text"
              @input="$v.formData.name.$touch()"
            />

            <div v-if="$v.formData.name.$error">
              <span v-if="!$v.formData.name.required" class="text-danger">{{ $tc('validation.required') }}</span>
              <span v-if="!$v.formData.name.minLength" class="text-danger"> {{ $tc('validation.name_min_length', $v.formData.name.$params.minLength.min, { count: $v.formData.name.$params.minLength.min }) }} </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('packages.type') }}</label>
          <div class="col-sm-7">
            <base-text-area
              v-model="formData.type"
              rows="4"
              cols="50"
              @input="$v.formData.type.$touch()"
            />
            <div v-if="$v.formData.type.$error">
              <span v-if="!$v.formData.name.maxLength" class="text-danger"> {{ $tc('validation.description_maxlength') }} </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label input-label">{{ $t('packages.amount') }}</label>
            <div class="col-sm-7 base-input">
                <money
                    :class="{'invalid' : $v.formData.amount.$error}"
                    v-model="amount"
                    v-bind="defaultCurrencyForInput"
                    class="input-field"
                />
                <div v-if="$v.formData.amount.$error">
                    <span v-if="!$v.formData.amount.required" class="text-danger">{{ $t('validation.required') }} </span>
                    <span v-if="!$v.formData.amount.maxLength" class="text-danger">{{ $t('validation.price_maxlength') }}</span>
                    <span v-if="!$v.formData.amount.minValue" class="text-danger">{{ $t('validation.price_minvalue') }}</span>
                  </div>
            </div>
        </div>
      </div>
      <div class="card-footer">
        <base-button
          :outline="true"
          class="mr-3"
          color="theme"
          @click="closePackageModal"
        >
          {{ $t('general.cancel') }}
        </base-button>
        <base-button
          :loading="isLoading"
          icon="save"
          color="theme"
          type="submit"
        >
          {{ !isEdit ? $t('general.save') : $t('general.update') }}
        </base-button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { validationMixin } from 'vuelidate'
const { required, minLength, maxLength, minValue } = require('vuelidate/lib/validators')
export default {
  mixins: [validationMixin],
  data () {
    return {
      isEdit: false,
      isLoading: false,
      formData: {
        id: null,
        name: null,
        type: null,
        amount: null
      },
      money: {
        decimal: '.',
        thousands: ',',
        prefix: 'MYR ',
        precision: 2,
        masked: false
      }
    }
  },
  computed: {
    ...mapGetters('modal', [
      'modalDataID',
      'modalData',
      'modalActive'
    ]),
    ...mapGetters('currency', [
      'defaultCurrencyForInput'
    ]),
    amount: {
      get: function () {
        return this.formData.amount / 100
      },
      set: function (newValue) {
        this.formData.amount = newValue * 100
      }
    },
  },
  validations: {
    formData: {
      name: {
        required,
        minLength: minLength(3)
      },
      type: {
        maxLength: maxLength(255)
      },
      amount: {
          required,
          minValue: minValue(0.1),
          maxLength: maxLength(20)
      }
    }
  },
  watch: {
    'modalDataID' (val) {
      if (val) {
        this.isEdit = true
        this.setData()
      } else {
        this.isEdit = false
      }
    },
    'modalActive' (val) {
      if (!this.modalActive) {
        this.resetFormData()
      }
    }
  },
  mounted () {
    this.$refs.name.focus = true
    if (this.modalDataID) {
      this.isEdit = true
      this.setData()
    }
  },
  destroyed () {

  },
  methods: {
    ...mapActions('modal', [
      'closeModal',
      'resetModalData'
    ]),
    ...mapActions('pack', [
      'addPackage',
      'updatePackage'
    ]),
    resetFormData () {
      this.formData = {
        id: null,
        name: null,
        type: null,
        amount: null
      }
      this.$v.formData.$reset()
    },
    async submitPackageData () {
      this.$v.formData.$touch()

      if (this.$v.$invalid) {
        return true
      }
      this.isLoading = true
      let response
      if (!this.isEdit) {
        response = await this.addPackage(this.formData)
      } else {
        response = await this.updatePackage(this.formData)
      }

      if (response.data) {
        if (!this.isEdit) {
          window.toastr['success'](this.$t('settings.package.created_message'))
        } else {
          window.toastr['success'](this.$t('settings.package.updated_message'))
        }
        window.hub.$emit('newPackage', response.data.package)
        this.closePackageModal()
        this.isLoading = false
        return true
      }
      window.toastr['error'](response.data.error)
    },
    async setData () {
      this.formData = {
        id: this.modalData.id,
        name: this.modalData.name,
        type: this.modalData.type,
        amount: this.modalData.amount,
      }
    },
    closePackageModal () {
      this.resetFormData()
      this.closeModal()
    }
  }
}
</script>
