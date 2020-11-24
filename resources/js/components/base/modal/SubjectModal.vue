<template>
  <div class="item-unit-modal">
    <form action="" @submit.prevent="submitSubject">
      <div class="card-body">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.class.unit_name') }} <span class="required"> *</span></label>
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
          <label class="col-sm-4 col-form-label input-label">{{ $t('settings.customization.class.code') }} <span class="required"> *</span></label>
          <div class="col-sm-7">
            <base-input
              ref="code"
              :invalid="$v.formData.code.$error"
              v-model="formData.code"
              type="text"
              @input="$v.formData.code.$touch()"
            />
            <div v-if="$v.formData.code.$error">
              <span v-if="!$v.formData.code.required" class="form-group__message text-danger">{{ $tc('validation.required') }}</span>
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
          @click="closeSubjectModal"
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
const { required, minLength } = require('vuelidate/lib/validators')
export default {
  mixins: [validationMixin],
  data () {
    return {
      isEdit: false,
      isLoading: false,
      formData: {
        id: null,
        name: null,
        code: null
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
      code: {
        required,
        minLength: minLength(2)
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
        code: null
      }
      this.$v.formData.$reset()
    },
    async submitSubject () {
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
          this.closeSubjectModal()
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
            this.closeSubjectModal()
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
        code: this.modalData.code
      }
    },
    closeSubjectModal () {
      this.resetModalData()
      this.resetFormData()
      this.closeModal()
    }
  }
}
</script>
