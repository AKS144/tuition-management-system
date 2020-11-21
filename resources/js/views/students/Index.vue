<template>
  <div class="customer-create main-content">
    <div class="page-header">
      <h3 class="page-title">{{ $t('students.title') }}</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link
            slot="item-title"
            to="dashboard">
            {{ $t('general.home') }}
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link
            slot="item-title"
            to="#">
            {{ $tc('students.student',2) }}
          </router-link>
        </li>
      </ol>
      <div class="page-actions row">
        <div class="col-xs-2 mr-4">
          <base-button
            v-show="totalStudents || filtersApplied"
            :outline="true"
            :icon="filterIcon"
            size="large"
            color="theme"
            right-icon
            @click="toggleFilter"
          >
            {{ $t('general.filter') }}
          </base-button>
        </div>
        <router-link slot="item-title" class="col-xs-2" to="students/create">
          <base-button
            size="large"
            icon="plus"
            color="theme">
            {{ $t('students.new_student') }}
          </base-button>
        </router-link>
      </div>
    </div>

    <transition name="fade">
      <div v-show="showFilters" class="filter-section">
        <div class="row">
          <div class="col-sm-4">
            <label class="form-label">{{ $t('students.full_name') }}</label>
            <base-input
              v-model="filters.full_name"
              type="text"
              name="name"
              autocomplete="off"
            />
          </div>
          <div class="col-sm-4">
            <label class="form-label">{{ $t('students.nric') }}</label>
            <base-input
              v-model="filters.nric"
              type="text"
              name="nric"
              autocomplete="off"
            />
          </div>
          <div class="col-sm-4">
            <label class="form-label">{{ $t('students.mobile_no') }}</label>
            <base-input
              v-model="filters.mobile_no"
              type="text"
              name="mobile_no"
              autocomplete="off"
            />
          </div>
          <label class="clear-filter" @click="clearFilter">{{ $t('general.clear_all') }}</label>
        </div>
      </div>
    </transition>

    <div v-cloak v-show="showEmptyScreen" class="col-xs-1 no-data-info" align="center">
      <astronaut-icon class="mt-5 mb-4"/>
      <div class="row" align="center">
        <label class="col title">{{ $t('students.no_students') }}</label>
      </div>
      <div class="row">
        <label class="description col mt-1" align="center">{{ $t('students.list_of_students') }}</label>
      </div>
      <div class="btn-container">
        <base-button
          :outline="true"
          color="theme"
          class="mt-3"
          size="large"
          @click="$router.push('students/create')"
        >
          {{ $t('students.add_new_student') }}
        </base-button>
      </div>
    </div>

    <div v-show="!showEmptyScreen" class="table-container">
      <div class="table-actions mt-5">
        <p class="table-stats">{{ $t('general.showing') }}: <b>{{ students.length }}</b> {{ $t('general.of') }} <b>{{ totalStudents }}</b></p>

        <transition name="fade">
          <v-dropdown v-if="selectedStudents.length" :show-arrow="false">
            <span slot="activator" href="#" class="table-actions-button dropdown-toggle">
              {{ $t('general.actions') }}
            </span>
            <v-dropdown-item>
              <div class="dropdown-item" @click="removeMultipleStudents">
                <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                {{ $t('general.delete') }}
              </div>
            </v-dropdown-item>
          </v-dropdown>
        </transition>
      </div>

      <div class="custom-control custom-checkbox">
        <input
          id="select-all"
          v-model="selectAllFieldStatus"
          type="checkbox"
          class="custom-control-input"
          @change="selectAllStudents"
        >
        <label for="select-all" class="custom-control-label selectall">
          <span class="select-all-label">{{ $t('general.select_all') }} </span>
        </label>
      </div>

      <table-component
        ref="table"
        :show-filter="false"
        :data="fetchData"
        table-class="table"
      >
        <table-column
          :sortable="false"
          :filterable="false"
          cell-class="no-click"
        >
          <template slot-scope="row">
            <div class="custom-control custom-checkbox">
              <input
                :id="row.id"
                v-model="selectField"
                :value="row.id"
                type="checkbox"
                class="custom-control-input"
              >
              <label :for="row.id" class="custom-control-label" />
            </div>
          </template>
        </table-column>
        <table-column
          :label="$t('students.full_name')"
          show="full_name"
        />
        <table-column
          :label="$t('students.nric')"
          show="nric"
        />
        <table-column
          :label="$t('students.mobile_no')"
          show="mobile_no"
        />
        <table-column
          :label="$t('students.status')"
          show="status"
        />
        <table-column
          :label="$t('students.joined_date')"
          sort-as="date_joined"
          show="formattedJoinedAt"
        />
        <table-column
          :sortable="false"
          :filterable="false"
          cell-class="action-dropdown"
        >
          <template slot-scope="row">
            <span> {{ $t('students.action') }} </span>
            <v-dropdown>
              <a slot="activator" href="#">
                <dot-icon />
              </a>
              <v-dropdown-item>
                <router-link :to="{path: `students/${row.id}/edit`}" class="dropdown-item">
                  <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon"/>
                  {{ $t('general.edit') }}
                </router-link>
              </v-dropdown-item>
              
              <v-dropdown-item>
                <div class="dropdown-item" @click="removeStudent(row.id)">
                  <font-awesome-icon :icon="['fas', 'trash']" class="dropdown-item-icon" />
                  {{ $t('general.delete') }}
                </div>
              </v-dropdown-item>

              <v-dropdown-item>
              <router-link :to="{path: `students/${row.id}/view`}" class="dropdown-item">
                  <font-awesome-icon :icon="['fas', 'eye']" class="dropdown-item-icon" />
                  {{ $t('general.view') }}
                </router-link>
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
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'
import DotIcon from '../../components/icon/DotIcon'
import AstronautIcon from '../../components/icon/AstronautIcon'
import BaseButton from '../../../js/components/base/BaseButton'
import { request } from 'http'

export default {
  components: {
    DotIcon,
    AstronautIcon,
    SweetModal,
    SweetModalTab,
    BaseButton
  },
  data () {
    return {
      showFilters: false,
      filtersApplied: false,
      isRequestOngoing: true,
      filters: {
        full_name: '',
        nric: '',
        mobile_no: ''
      }
    }
  },
  computed: {
    showEmptyScreen () {
      return !this.totalStudents && !this.isRequestOngoing && !this.filtersApplied
    },
    filterIcon () {
      return (this.showFilters) ? 'times' : 'filter'
    },
    ...mapGetters('student', [
      'students',
      'selectedStudents',
      'totalStudents',
      'selectAllField'
    ]),
    selectField: {
      get: function () {
        return this.selectedStudents
      },
      set: function (val) {
        this.selectStudent(val)
      }
    },
    selectAllFieldStatus: {
      get: function () {
        return this.selectAllField
      },
      set: function (val) {
        this.setSelectAllState(val)
      }
    }
  },
  watch: {
    filters: {
      handler: 'setFilters',
      deep: true
    }
  },
  destroyed () {
    if (this.selectAllField) {
      this.selectAllStudents()
    }
  },
  methods: {
    ...mapActions('student', [
      'fetchStudents',
      'selectAllStudents',
      'selectStudent',
      'deleteStudent',
      'deleteMultipleStudents',
      'setSelectAllState'
    ]),
    refreshTable () {
      this.$refs.table.refresh()
    },
    async fetchData ({ page, filter, sort }) {
      let data = {
        full_name: this.filters.full_name,
        nric: this.filters.nric,
        mobile_no: this.filters.mobile_no,
        orderByField: sort.fieldName || 'created_at',
        orderBy: sort.order || 'desc',
        page
      }

      this.isRequestOngoing = true
      let response = await this.fetchStudents(data)
      this.isRequestOngoing = false

      return {
        data: response.data.students.data,
        pagination: {
          totalPages: response.data.students.last_page,
          currentPage: page
        }
      }
    },
    setFilters () {
      this.filtersApplied = true
      this.refreshTable()
    },
    clearFilter () {
      this.filters = {
        full_name: '',
        nric: '',
        mobile_no: ''
      }

      this.$nextTick(() => {
        this.filtersApplied = false
      })
    },
    toggleFilter () {
      if (this.showFilters && this.filtersApplied) {
        this.clearFilter()
        this.refreshTable()
      }

      this.showFilters = !this.showFilters
    },
    async removeStudent (id) {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$tc('students.confirm_delete'),
        icon: '/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (willDelete) => {
        if (willDelete) {
          let res = await this.deleteStudent(id)
          if (res.data.success) {
            window.toastr['success'](this.$tc('students.deleted_message'))
            this.refreshTable()
            return true
          } else if (request.data.error) {
            window.toastr['error'](res.data.message)
          }
        }
      })
    },
    async removeMultipleStudents () {
      swal({
        title: this.$t('general.are_you_sure'),
        text: this.$tc('students.confirm_delete', 2),
        icon: '/assets/icon/trash-solid.svg',
        buttons: true,
        dangerMode: true
      }).then(async (willDelete) => {
        if (willDelete) {
          let request = await this.deleteMultipleStudents()
          if (request.data.success) {
            window.toastr['success'](this.$tc('students.deleted_message', 2))
            this.refreshTable()
          } else if (request.data.error) {
            window.toastr['error'](request.data.message)
          }
        }
      })
    }
  }
}
</script>
