<template>
  <div class="setting-main-container customization">
    <div class="card setting-card">
      <ul class="tabs">
        <li class="tab" @click="setActiveTab('INVOICES')">
          <a :class="['tab-link', {'a-active': activeTab === 'INVOICES'}]" href="#">{{ $t('settings.customization.invoices.title') }}</a>
        </li>
        <li class="tab" @click="setActiveTab('PAYMENTS')">
          <a :class="['tab-link', {'a-active': activeTab === 'PAYMENTS'}]" href="#">{{ $t('settings.customization.payments.title') }}</a>
        </li>
        <li class="tab" @click="setActiveTab('SUBJECTS')">
          <a :class="['tab-link', {'a-active': activeTab === 'SUBJECTS'}]" href="#">{{ $t('settings.customization.class.title') }}</a>
        </li>
        <li class="tab" @click="setActiveTab('LEVELS')">
          <a :class="['tab-link', {'a-active': activeTab === 'LEVELS'}]" href="#">{{ $t('settings.customization.level.title') }}</a>
        </li>
      </ul>

      <!-- Invoices Tab -->
      <transition name="fade-customize">
        <div v-if="activeTab === 'INVOICES'" class="invoice-tab">
          <form action="" class="mt-3" @submit.prevent="updateInvoiceSetting">
            <div class="row">
              <div class="col-md-12 mb-4">
                <label class="input-label">{{ $t('settings.customization.invoices.invoice_prefix') }}</label>
                <base-input
                  v-model="invoices.invoice_prefix"
                  :invalid="$v.invoices.invoice_prefix.$error"
                  class="prefix-input"
                  @input="$v.invoices.invoice_prefix.$touch()"
                  @keyup="changeToUppercase('INVOICES')"
                />
                <span v-show="!$v.invoices.invoice_prefix.required" class="text-danger mt-1">{{ $t('validation.required') }}</span>
                <span v-if="!$v.invoices.invoice_prefix.maxLength" class="text-danger">{{ $t('validation.prefix_maxlength') }}</span>
                <span v-if="!$v.invoices.invoice_prefix.alpha" class="text-danger">{{ $t('validation.characters_only') }}</span>
              </div>
            </div>
            <div class="row pb-3">
              <div class="col-md-12">
                <base-button
                  icon="save"
                  color="theme"
                  type="submit"
                >
                  {{ $t('settings.customization.save') }}
                </base-button>
              </div>
            </div>
          </form>
          <hr>
          <div class="page-header pt-3">
            <h3 class="page-title">
              {{ $t('settings.customization.invoices.invoice_settings') }}
            </h3>
            <div class="flex-box">
              <div class="left">
                <base-switch
                  v-model="invoiceAutogenerate"
                  class="btn-switch"
                  @change="setInvoiceSetting"
                />
              </div>
              <div class="right ml-15">
                <p class="box-title">  {{ $t('settings.customization.invoices.autogenerate_invoice_number') }} </p>
                <p class="box-desc">  {{ $t('settings.customization.invoices.invoice_setting_description') }} </p>
              </div>
            </div>
          </div>
        </div>
      </transition>

      <!-- Payments Tab -->
      <transition name="fade-customize">
        <div v-if="activeTab === 'PAYMENTS'" class="payment-tab">
          <div class="page-header">
            <div class="row">
              <div class="col-md-8">
                <!-- <h3 class="page-title">
                  {{ $t('settings.customization.payments.payment_mode') }}
                </h3> -->
              </div>
              <div class="col-md-4 d-flex flex-row-reverse">
                <base-button
                  outline
                  class="add-new-tax"
                  color="theme"
                  @click="addPaymentMode"
                >
                  {{ $t('settings.customization.payments.add_payment_mode') }}
                </base-button>
              </div>
            </div>
          </div>
          <table-component
            ref="table"
            :show-filter="false"
            :data="paymentModes"
            table-class="table tax-table"
            class="mb-3"
          >
            <table-column
              :sortable="true"
              :label="$t('settings.customization.payments.payment_mode')"
              show="name"
            />
            <table-column
              :sortable="false"
              :filterable="false"
              cell-class="action-dropdown"
            >
              <template slot-scope="row">
                <span>{{ $t('settings.tax_types.action') }}</span>
                <v-dropdown>
                  <a slot="activator" href="#">
                    <dot-icon />
                  </a>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="editPaymentMode(row)">
                      <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon" />
                      {{ $t('general.edit') }}
                    </div>
                  </v-dropdown-item>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="removePaymentMode(row.id)">
                      <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                      {{ $t('general.delete') }}
                    </div>
                  </v-dropdown-item>
                </v-dropdown>
              </template>
            </table-column>
          </table-component>
          <hr>
          <form action="" class="pt-3" @submit.prevent="updatePaymentSetting">
            <div class="row">
              <div class="col-md-12 mb-4">
                <label class="input-label">{{ $t('settings.customization.payments.payment_prefix') }}</label>
                <base-input
                  v-model="payments.payment_prefix"
                  :invalid="$v.payments.payment_prefix.$error"
                  class="prefix-input"
                  @input="$v.payments.payment_prefix.$touch()"
                  @keyup="changeToUppercase('PAYMENTS')"
                />
                <span v-show="!$v.payments.payment_prefix.required" class="text-danger mt-1">{{ $t('validation.required') }}</span>
                <span v-if="!$v.payments.payment_prefix.maxLength" class="text-danger">{{ $t('validation.prefix_maxlength') }}</span>
                <span v-if="!$v.payments.payment_prefix.alpha" class="text-danger">{{ $t('validation.characters_only') }}</span>
              </div>
            </div>
            <div class="row pb-3">
              <div class="col-md-12">
                <base-button
                  icon="save"
                  color="theme"
                  type="submit"
                >
                  {{ $t('settings.customization.save') }}
                </base-button>
              </div>
            </div>
          </form>
          <hr>
          <div class="page-header pt-3">
            <h3 class="page-title">
              {{ $t('settings.customization.payments.payment_settings') }}
            </h3>
            <div class="flex-box">
              <div class="left">
                <base-switch
                  v-model="paymentAutogenerate"
                  class="btn-switch"
                  @change="setPaymentSetting"
                />
              </div>
              <div class="right ml-15">
                <p class="box-title">  {{ $t('settings.customization.payments.autogenerate_payment_number') }} </p>
                <p class="box-desc">  {{ $t('settings.customization.payments.payment_setting_description') }} </p>
              </div>
            </div>
          </div>
        </div>
      </transition>

      <!-- Subjects Tab -->
      <transition name="fade-customize">
        <div v-if="activeTab === 'SUBJECTS'" class="item-tab">
          <div class="page-header">
            <div class="row">
              <div class="col-md-8">
                <!-- <h3 class="page-title">
                  {{ $t('settings.customization.class.title') }}
                </h3> -->
              </div>
              <div class="col-md-4 d-flex flex-row-reverse">
                <base-button
                  outline
                  class="add-new-tax"
                  color="theme"
                  @click="addSubject"
                >
                  {{ $t('settings.customization.class.add_item_unit') }}
                </base-button>
              </div>
            </div>
          </div>
          <table-component
            ref="subjectTable"
            :show-filter="false"
            :data="subjects"
            table-class="table tax-table"
            class="mb-3"
          >
            <table-column
              :sortable="true"
              :label="$t('settings.customization.class.units')"
              show="name"
            />
            <table-column
              :sortable="true"
              :label="$t('settings.customization.class.code')"
              show="code"
            />
            <table-column
              :sortable="false"
              :filterable="false"
              cell-class="action-dropdown"
            >
              <template slot-scope="row">
                <span>{{ $t('settings.tax_types.action') }}</span>
                <v-dropdown>
                  <a slot="activator" href="#">
                    <dot-icon />
                  </a>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="editSubject(row)">
                      <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon" />
                      {{ $t('general.edit') }}
                    </div>
                  </v-dropdown-item>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="removeSubject(row.id)">
                      <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                      {{ $t('general.delete') }}
                    </div>
                  </v-dropdown-item>
                </v-dropdown>
              </template>
            </table-column>
          </table-component>
        </div>
      </transition>

      <!-- Levels Tab -->
      <transition name="fade-customize">
        <div v-if="activeTab === 'LEVELS'" class="item-tab">
          <div class="page-header">
            <div class="row">
              <div class="col-md-8">
                <!-- <h3 class="page-title">
                  {{ $t('settings.customization.class.title') }}
                </h3> -->
              </div>
              <div class="col-md-4 d-flex flex-row-reverse">
                <base-button
                  outline
                  class="add-new-tax"
                  color="theme"
                  @click="addLevel"
                >
                  {{ $t('settings.customization.level.add_level') }}
                </base-button>
              </div>
            </div>
          </div>
          <table-component
            ref="levelTable"
            :show-filter="false"
            :data="levels"
            table-class="table tax-table"
            class="mb-3"
          >
            <table-column
              :sortable="true"
              :label="$t('settings.customization.level.name')"
              show="name"
            />
            <table-column
              :sortable="false"
              :filterable="false"
              cell-class="action-dropdown"
            >
              <template slot-scope="row">
                <span>{{ $t('settings.tax_types.action') }}</span>
                <v-dropdown>
                  <a slot="activator" href="#">
                    <dot-icon />
                  </a>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="editLevel(row)">
                      <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon" />
                      {{ $t('general.edit') }}
                    </div>
                  </v-dropdown-item>
                  <v-dropdown-item>
                    <div class="dropdown-item" @click="removeLevel(row.id)">
                      <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                      {{ $t('general.delete') }}
                    </div>
                  </v-dropdown-item>
                </v-dropdown>
              </template>
            </table-column>
          </table-component>
        </div>
      </transition>
    </div>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { mapActions, mapGetters } from 'vuex'
const { required, maxLength, alpha } = require('vuelidate/lib/validators')
export default {
  mixins: [validationMixin],
  data () {
    return {
      activeTab: 'INVOICES',
      invoiceAutogenerate: false,
      paymentAutogenerate: false,
      invoices: {
        invoice_prefix: null,
        invoice_notes: null,
        invoice_terms_and_conditions: null
      },
      payments: {
        payment_prefix: null
      },
      subject: {
        units: []
      },
      level: {
        levels: []
      },
      currentData: null
    }
  },
  computed: {
    ...mapGetters('subject', [
      'subjects'
    ]),
    ...mapGetters('level', [
      'levels'
    ]),
    ...mapGetters('payment', [
      'paymentModes'
    ])
  },
  watch: {
    activeTab () {
      this.loadData()
    }
  },
  validations: {
    invoices: {
      invoice_prefix: {
        required,
        maxLength: maxLength(5),
        alpha
      }
    },
    payments: {
      payment_prefix: {
        required,
        maxLength: maxLength(5),
        alpha
      }
    }
  },
  created () {
    this.loadData()
  },
  methods: {
    ...mapActions('modal', [
      'openModal'
    ]),
    ...mapActions('payment', [
      'deletePaymentMode'
    ]),
    ...mapActions('subject', [
      'deleteSubject'
    ]),
    ...mapActions('level', [
      'deleteLevel'
    ]),
    async setInvoiceSetting () {
      let data = {
        key: 'invoice_auto_generate',
        value: this.invoiceAutogenerate ? 'YES' : 'NO'
      }
      let response = await window.axios.put('/api/v1/settings/update-setting', data)
      if (response.data) {
        window.toastr['success'](this.$t('general.setting_updated'))
      }
    },
    async addSubject () {
      this.openModal({
        'title': this.$t('settings.customization.class.add_item_unit'),
        'componentName': 'Subject'
      })
      this.$refs.subjectTable.refresh()
    },
    async editSubject (data) {
      this.openModal({
        'title': this.$t('settings.customization.class.edit_item_unit'),
        'componentName': 'Subject',
        'id': data.id,
        'data': data
      })
      this.$refs.subjectTable.refresh()
    },
    async removeSubject (id) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$t('settings.customization.class.item_unit_confirm_delete'),
        icon: '/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (value) => {
        if (value) {
          let response = await this.deleteSubject(id)
          if (response.data.success) {
            window.toastr['success'](this.$t('settings.customization.class.deleted_message'))
            this.id = null
            this.$refs.subjectTable.refresh()
            return true
          }
          window.toastr['error'](this.$t('settings.customization.class.already_in_use'))
        }
      })
    },
    async addLevel () {
      this.openModal({
        'title': this.$t('settings.customization.level.add_level'),
        'componentName': 'Level'
      })
      this.$refs.levelTable.refresh()
    },
    async editLevel (data) {
      this.openModal({
        'title': this.$t('settings.customization.level.edit_level'),
        'componentName': 'Level',
        'id': data.id,
        'data': data
      })
      this.$refs.levelTable.refresh()
    },
    async removeLevel (id) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$t('settings.customization.level.level_confirm_delete'),
        icon: '/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (value) => {
        if (value) {
          let response = await this.deleteLevel(id)
          if (response.data.success) {
            window.toastr['success'](this.$t('settings.customization.level.deleted_message'))
            this.id = null
            this.$refs.levelTable.refresh()
            return true
          }
          window.toastr['error'](this.$t('settings.customization.level.already_in_use'))
        }
      })
    },
    async addPaymentMode () {
      this.openModal({
        'title': this.$t('settings.customization.payments.add_payment_mode'),
        'componentName': 'PaymentMode'
      })
      this.$refs.table.refresh()
    },
    async editPaymentMode (data) {
      this.openModal({
        'title': this.$t('settings.customization.payments.edit_payment_mode'),
        'componentName': 'PaymentMode',
        'id': data.id,
        'data': data
      })
      this.$refs.table.refresh()
    },
    removePaymentMode (id) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$t('settings.customization.payments.payment_mode_confirm_delete'),
        icon: '/assets/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (value) => {
        if (value) {
          let response = await this.deletePaymentMode(id)
          if (response.data.success) {
            window.toastr['success'](this.$t('settings.customization.payments.deleted_message'))
            this.id = null
            this.$refs.table.refresh()
            return true
          }
          window.toastr['error'](this.$t('settings.customization.payments.already_in_use'))
        }
      })
    },
    changeToUppercase (currentTab) {
      if (currentTab === 'INVOICES') {
        this.invoices.invoice_prefix = this.invoices.invoice_prefix.toUpperCase()
        return true
      }

      if (currentTab === 'PAYMENTS') {
        this.payments.payment_prefix = this.payments.payment_prefix.toUpperCase()
        return true
      }
    },
    async setPaymentSetting () {
      let data = {
        key: 'payment_auto_generate',
        value: this.paymentAutogenerate ? 'YES' : 'NO'
      }
      let response = await window.axios.put('/api/v1/settings/update-setting', data)
      if (response.data) {
        window.toastr['success'](this.$t('general.setting_updated'))
      }
    },
    async loadData () {
      let res = await window.axios.get('/api/v1/settings/get-customize-setting')

      if (res.data) {
        this.invoices.invoice_prefix = res.data.invoice_prefix
        this.invoices.invoice_notes = res.data.invoice_notes
        this.invoices.invoice_terms_and_conditions = res.data.invoice_terms_and_conditions
        this.payments.payment_prefix = res.data.payment_prefix

        if (res.data.invoice_auto_generate === 'YES') {
          this.invoiceAutogenerate = true
        } else {
          this.invoiceAutogenerate = false
        }

        if (res.data.payment_auto_generate === 'YES') {
          this.paymentAutogenerate = true
        } else {
          this.paymentAutogenerate = false
        }
      }
    },
    async updateInvoiceSetting () {
      this.$v.invoices.$touch()

      if (this.$v.invoices.$invalid) {
        return false
      }

      let data = {type: 'INVOICES', ...this.invoices}

      if (this.updateSetting(data)) {
        window.toastr['success'](this.$t('settings.customization.invoices.invoice_setting_updated'))
      }
    },
    async updatePaymentSetting () {
      this.$v.payments.$touch()

      if (this.$v.payments.$invalid) {
        return false
      }

      let data = {type: 'PAYMENTS', ...this.payments}

      if (this.updateSetting(data)) {
        window.toastr['success'](this.$t('settings.customization.payments.payment_setting_updated'))
      }
    },
    async updateSetting (data) {
      let res = await window.axios.put('/api/v1/settings/update-customize-setting', data)

      if (res.data.success) {
        return true
      }

      return false
    },
    setActiveTab (val) {
      this.activeTab = val
    }
  }
}
</script>
<style>
  .fade-customize-enter-active {
    transition: opacity 0.9s;
  }

  .fade-customize-leave-active  {
    transition: opacity 0s;
  }

  .fade-customize-enter, .fade-customize-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }
</style>
