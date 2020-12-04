<template>

  <div class="setting-main-container">
    <div class="card setting-card">
      <div class="page-header d-flex justify-content-between">
        <div>
          <h3 class="page-title">{{ $t('settings.package.title') }}</h3>
          <p class="page-sub-title">
            {{ $t('settings.package.description') }}
          </p>
        </div>
        <base-button
          outline
          class="add-new-tax"
          color="theme"
          @click="openPackageModal"
        >
          {{ $t('settings.package.add_new_package') }}
        </base-button>
      </div>

      <table-component
        ref="packageTable"
        :show-filter="false"
        :data="packages"
        table-class="table tax-table"
      >
        <table-column
          :label="$t('settings.package.package_name')"
          show="name"
        />
        <table-column
          :label="$t('settings.package.package_type')"
          show="type"
        />
        <table-column
          :label="$t('settings.package.amount')"
          show="amount"
        >
            <template slot-scope="row">
                <span>{{ $t('expenses.amount') }}</span>
                <div v-html="$utils.formatMoney(row.amount, defaultCurrency)" />
          </template>
        </table-column>
        <table-column
          :sortable="false"
          :filterable="false"
          cell-class="action-dropdown"
        >
          <template slot-scope="row">
            <span>{{ $t('settings.package.action') }}</span>
            <v-dropdown>
              <a slot="activator" href="#">
                <dot-icon />
              </a>
              <v-dropdown-item>
                <div class="dropdown-item" @click="EditPackage(row.id)">
                  <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon" />
                  {{ $t('general.edit') }}
                </div>
              </v-dropdown-item>
              <v-dropdown-item>
                <div class="dropdown-item" @click="removePackage(row.id)">
                  <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                  {{ $t('general.delete') }}
                </div>
              </v-dropdown-item>
            </v-dropdown>
          </template>
        </table-column>
      </table-component>
    </div>
  </div>

</template>
<script>

import { mapActions, mapGetters } from 'vuex'

export default {
  data () {
    return {
      id: null
    }
  },
  computed: {
    ...mapGetters('pack', [
      'packages',
      'getPackageById'
    ]),
    ...mapGetters('currency', [
      'defaultCurrency'
    ]),
  },
  mounted () {
    this.fetchPackages()
  },
  methods: {
    ...mapActions('modal', [
      'openModal'
    ]),
    ...mapActions('pack', [
      'fetchPackages',
      'fetchPackage',
      'deletePackage'
    ]),
    async removePackage (id, index) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$t('settings.package.confirm_delete'),
        icon: '/assets/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (willDelete) => {
        if (willDelete) {
          let response = await this.deletePackage(id)
          if (response.data.success) {
            window.toastr['success'](this.$tc('settings.package.deleted_message'))
            this.id = null
            this.$refs.packageTable.refresh()
            return true
          } window.toastr['error'](this.$t('settings.package.already_in_use'))
        }
      })
    },
    openPackageModal () {
      this.openModal({
        'title': this.$t('settings.package.add_package'),
        'componentName': 'PackageModal'
      })
      this.$refs.packageTable.refresh()
    },
    async EditPackage (id) {
      let response = await this.fetchPackage(id)
      this.openModal({
        'title': this.$t('settings.package.edit_package'),
        'componentName': 'PackageModal',
        'id': id,
        'data': response.data.package
      })
      this.$refs.packageTable.refresh()
    }
  }
}
</script>
