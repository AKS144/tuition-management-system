<template>
  <div class="item-unit-modal">
    <form action="" @submit.prevent="submitParent">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.parent.name') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="name"
              :invalid="$v.formData.name.$error"
              v-model="formData.name"
              type="text"
              @input="$v.formData.name.$touch()"
            />
            <div v-if="$v.formData.name.$error">
              <span v-if="!$v.formData.name.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.parent.nric') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="nric"
              :invalid="$v.formData.nric.$error"
              v-model="formData.nric"
              type="text"
              @input="$v.formData.nric.$touch()"
            />
            <div v-if="$v.formData.nric.$error">
              <span v-if="!$v.formData.nric.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
              <span v-if="!$v.formData.nric.minLength" class="text-danger"> 
                {{ $tc('validation.nric_minlength', $v.formData.nric.$params.minLength.min, { count: $v.formData.nric.$params.minLength.min }) }} 
              </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.parent.mobile') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="mobile_no"
              :invalid="$v.formData.mobile_no.$error"
              v-model="formData.mobile_no"
              type="text"
              @input="$v.formData.mobile_no.$touch()"
            />
            <div v-if="$v.formData.mobile_no.$error">
              <span v-if="!$v.formData.mobile_no.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.parent.email') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="email"
              :invalid="$v.formData.email.$error"
              v-model="formData.email"
              type="text"
              @input="$v.formData.email.$touch()"
            />
            <div v-if="$v.formData.email.$error">
              <span v-if="!$v.formData.email.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.parent.relationship') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="relationship"
              :invalid="$v.formData.relationship.$error"
              v-model="formData.relationship"
              type="text"
              @input="$v.formData.relationship.$touch()"
            />
            <div v-if="$v.formData.relationship.$error">
              <span v-if="!$v.formData.relationship.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <base-button
          :outline="true"
          class="mr-3"
          color="theme"
          type="button"
          @click="closeParentModal"
        >
          {{ $t('general.cancel') }}
        </base-button>
        <base-button
          :loading="isLoading"
          color="theme"
          icon="save"
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
const { required, minLength, numeric } = require('vuelidate/lib/validators')
export default {
  mixins: [validationMixin],
  data () {
    return {
      isEdit: false,
      isLoading: false,
      formData: {
        id: null,
        name: null,
        nric: null,
        mobile_no: null,
        relationship: null,
        email: null
      }
    }
  },
  computed: {
    ...mapGetters('modal', [
      'modalDataID',
      'modalData',
      'modalActive'
    ])
  },
  validations: {
    formData: {
      name: {
        required,
        minLength: minLength(2)
      },
      nric: {
        required,
        minLength: minLength(12)
      },
      mobile_no: {
          required,
      },
      relationship: {
          required,
      },
      email: {
          required
      }
    }
  },
  async mounted () {
    this.$refs.name.focus = true
    if (this.modalDataID) {
      this.isEdit = true
      this.setData()
    }
  },
  methods: {
    ...mapActions('modal', [
      'closeModal',
      'resetModalData'
    ]),
    ...mapActions('subject', [
      'addSubject',
      'updateSubject'
    ]),
    resetFormData () {
      this.formData = {
        id: null,
        name: null,
        nric: null,
        mobile_no: null,
        relationship: null,
        email: null
      }
      this.$v.formData.$reset()
    },
    async submitParent () {
      this.$v.formData.$touch()
      if (this.$v.$invalid) {
        return true
      }
      this.isLoading = true

      let response

      if (this.isEdit) {
        response = await this.updateSubject(this.formData)

        if (response.data) {
          window.toastr['success'](this.$t('settings.customization.class.item_unit_updated'))
          this.closeParentModal()
          return true
        }

        window.toastr['error'](response.data.error)
        this.isLoading = false
      } else {
        try {
          response = await this.addSubject(this.formData)
          if (response.data) {
            this.isLoading = false
            window.toastr['success'](this.$t('settings.customization.class.item_unit_added'))
            this.closeParentModal()
            return true
          } window.toastr['error'](response.data.error)
          this.isLoading = false
        } catch (err) {
          if (err.response.data.errors.name) {
            this.isLoading = true
            window.toastr['error'](this.$t('validation.item_unit_already_taken'))
          }
        }
      }
    },
    async setData () {
      this.formData = {
        id: this.modalData.id,
        name: this.modalData.name,
        nric: this.modalData.nric
      }
    },
    closeParentModal () {
      this.resetModalData()
      this.resetFormData()
      this.closeModal()
    }
  }
}
</script>
