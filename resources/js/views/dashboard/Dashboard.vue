<template>
  <div id="app" class="main-content dashboard">
    <div class="row">
      <div class="dash-item col-sm-6">
        <router-link slot="item-title" to="/admin/invoices">
          <div class="dashbox">
            <div class="desc">
              <span
                v-if="isLoaded"
                class="amount"
              >
                <div v-html="$utils.formatMoney(getTotalDueAmount, defaultCurrency)"/>
              </span>
              <span class="title">
                {{ $t('dashboard.cards.due_amount') }}
              </span>
            </div>
            <div class="icon">
              <dollar-icon class="card-icon" />
            </div>
          </div>
        </router-link>
      </div>
      <div class="dash-item col-sm-6">
        <router-link slot="item-title" to="/admin/students">
          <div class="dashbox">
            <div class="desc">
              <span v-if="isLoaded"
                    class="amount" >
                {{ getStudents }}
              </span>
              <span class="title">
                {{ $t('dashboard.cards.customers') }}
              </span>
            </div>
            <div class="icon">
              <contact-icon class="card-icon" />
            </div>
          </div>
        </router-link>
      </div>
      <div class="dash-item col-sm-6">
        <router-link slot="item-title" to="/admin/invoices">
          <div class="dashbox">
            <div class="desc">
              <span v-if="isLoaded"
                    class="amount">
                {{ getInvoices }}
              </span>
              <span class="title">
                {{ $t('dashboard.cards.invoices') }}
              </span>
            </div>
            <div class="icon">
              <invoice-icon class="card-icon" />
            </div>
          </div>
        </router-link>
      </div>
      <div class="dash-item col-sm-6">
        <router-link slot="item-title" to="/admin/class">
          <div class="dashbox">
            <div class="desc">
              <span v-if="isLoaded"
                    class="amount">
                {{ getClasses }}
              </span>
              <span class="title">
                {{ $t('dashboard.cards.items') }}
              </span>
            </div>
            <div class="icon">
              <contact-icon class="card-icon" />
            </div>
          </div>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 mt-2">
        <div class="card dashboard-card">
          <div class="graph-body">
            <div class="card-body col-md-12 col-lg-12 col-xl-10">
              <div class="card-header">
                <h6><i class="fa fa-line-chart text-primary"/>{{ $t('dashboard.monthly_chart.title') }} </h6>
                <div class="year-selector">
                  <base-select
                    v-model="selectedYear"
                    :options="years"
                    :allow-empty="false"
                    :show-labels="false"
                    :placeholder="$t('dashboard.select_year')"
                  />
                </div>
              </div>
              <line-chart
                v-if="isLoaded"
                :format-money="$utils.formatMoney"
                :format-graph-money="$utils.formatGraphMoney"
                :invoices="getChartInvoices"
                :expenses="getChartExpenses"
                :receipts="getReceiptTotals"
                :income="getNetProfits"
                :labels="getChartMonths"
                class=""
              />
            </div>
            <div class="chart-desc col-md-12 col-lg-12 col-xl-2">
              <div class="stats">
                <div class="description">
                  <span class="title"> {{ $t('dashboard.chart_info.total_sales') }} </span>
                  <br>
                  <span v-if="isLoaded" class="total">
                    <div v-html="$utils.formatMoney(getTotalSales, defaultCurrency)"/>
                  </span>
                </div>
                <div class="description">
                  <span class="title"> {{ $t('dashboard.chart_info.total_receipts') }} </span>
                  <br>
                  <span v-if="isLoaded" class="total" style="color:#00C99C;">
                    <div v-html="$utils.formatMoney(getTotalReceipts, defaultCurrency)"/>
                  </span>
                </div>
                <div class="description">
                  <span class="title"> {{ $t('dashboard.chart_info.total_expense') }} </span>
                  <br>
                  <span v-if="isLoaded" class="total" style="color:#FB7178;">
                    <div v-html="$utils.formatMoney(getTotalExpenses, defaultCurrency)"/>
                  </span>
                </div>
                <div class="description">
                  <span class="title"> {{ $t('dashboard.chart_info.net_income') }} </span>
                  <br>
                  <span class="total" style="color:#5851D8;">
                    <div v-html="$utils.formatMoney(getNetProfit, defaultCurrency)"/>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <base-loader v-if="!getLoadedData"/>
    <div class="row table-row">
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="table-header">
          <h6 class="table-title">
            {{ $t('dashboard.classes_list_card.title') }}
          </h6>
          <router-link to="/admin/class">
            <base-button
              :outline="true"
              color="theme"
              class="btn-sm"
            >
              {{ $t('dashboard.classes_list_card.view_all') }}
            </base-button>
          </router-link>
        </div>
        <div class="dashboard-table">
          <table-component
            ref="class_table"
            :data="getRecentClasses"
            :show-filter="false"
            table-class="table"
            class="dashboard"
          >
            <table-column :label="$t('dashboard.classes_list_card.classes')" show="name" />
            <table-column :label="$t('dashboard.classes_list_card.class_code')" show="code" />
            <table-column :label="$t('dashboard.classes_list_card.tutor')" show="tutor.full_name" />
            <table-column
              :sortable="false"
              :filterable="false"
              cell-class="action-dropdown dashboard-recent-invoice-options no-click"
            >
              <template slot-scope="row">
                <v-dropdown>
                  <a slot="activator" href="#/">
                    <dot-icon />
                  </a>
                  <v-dropdown-item>
                    <router-link :to="{path: `class/${row.id}/edit`}" class="dropdown-item">
                      <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon"/>
                      {{ $t('general.edit') }}
                    </router-link>
                  </v-dropdown-item>
                </v-dropdown>
              </template>
            </table-column>
          </table-component>
        </div>
      </div>
      <div class="col-lg-12 col-xl-6 mt-2 mob-table">
        <div class="table-header">
          <h6 class="table-title">
            {{ $t('dashboard.student_list_card.title') }}
          </h6>
          <router-link to="/admin/students">
            <base-button
              :outline="true"
              color="theme"
              class="btn-sm"
            >
              {{ $t('dashboard.student_list_card.view_all') }}
            </base-button>
          </router-link>
        </div>
        <div class="dashboard-table">
          <table-component
            ref="student_table"
            :data="getRecentStudents"
            :show-filter="false"
            table-class="table"
          >
            <table-column :label="$t('dashboard.student_list_card.students')" show="full_name" />
            <table-column
              :label="$t('estimates.status')"
              show="status" >
            </table-column>
            <table-column
              :sortable="false"
              :filterable="false"
              cell-class="action-dropdown no-click"
            >
              <template slot-scope="row">
                <v-dropdown>
                  <a slot="activator" href="#/">
                    <dot-icon />
                  </a>
                  <v-dropdown-item>
                    <router-link :to="{path: `students/${row.id}/edit`}" class="dropdown-item">
                      <font-awesome-icon :icon="['fas', 'pencil-alt']" class="dropdown-item-icon" />
                      {{ $t('general.edit') }}
                    </router-link>
                  </v-dropdown-item>
                  <v-dropdown-item>
                    <router-link :to="{path: `students/${row.id}/view`}" class="dropdown-item">
                      <font-awesome-icon icon="eye" class="dropdown-item-icon" />
                      {{ $t('general.view') }}
                    </router-link>
                  </v-dropdown-item>
                </v-dropdown>
              </template>
            </table-column>
          </table-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import { SweetModal, SweetModalTab } from 'sweet-modal-vue'
import LineChart from '../../components/chartjs/LineChart'
import DollarIcon from '../../components/icon/DollarIcon'
import ContactIcon from '../../components/icon/ContactIcon'
import InvoiceIcon from '../../components/icon/InvoiceIcon'
import UsersIcon from '../../components/icon/users-solid'

export default {
  components: {
    LineChart,
    DollarIcon,
    ContactIcon,
    InvoiceIcon,
    UsersIcon
  },
  data () {
    return {
      incomeTotal: null,
      ...this.$store.state.dashboard,
      currency: { precision: 2, thousand_separator: ',', decimal_separator: '.', symbol: '$' },
      isLoaded: false,
      fetching: false,
      years: ['This year', 'Previous year'],
      selectedYear: 'This year'
    }
  },
  computed: {
    ...mapGetters('user', {
      'user': 'currentUser'
    }),
    ...mapGetters('dashboard', [
      'getChartMonths',
      'getChartInvoices',
      'getChartExpenses',
      'getNetProfits',
      'getReceiptTotals',
      'getStudents',
      'getTutors',
      'getClasses',
      'getInvoices',
      'getEstimates',
      'getTotalDueAmount',
      'getTotalSales',
      'getTotalReceipts',
      'getTotalExpenses',
      'getNetProfit',
      'getLoadedData',
      'getRecentClasses',
      'getRecentStudents'
    ]),
    ...mapGetters('currency', [
      'defaultCurrency'
    ])
  },
  watch: {
    selectedYear (val) {
      if (val === 'Previous year') {
        let params = {previous_year: true}
        this.loadData(params)
      } else {
        this.loadData()
      }
    }
  },
  created () {
    this.loadData()
  },
  methods: {
    ...mapActions('dashboard', [
      'getChart',
      'loadData'
    ]),

    async loadData (params) {
      await this.$store.dispatch('dashboard/loadData', params)
      this.isLoaded = true
    },

    refreshClassTable () {
      this.$refs.class_table.refresh()
    },

    refreshStudentTable () {
      this.$refs.student_table.refresh()
    },
  }
}
</script>
