import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const initialState = {
  students: 0,
  tutors: 0,
  classes: 0,
  invoices: 0,
  expenses: 0,
  totalDueAmount: [],
  isDataLoaded: false,

  weeklyInvoices: {
    days: [],
    counter: []
  },

  chartData: {
    months: [],
    invoiceTotals: [],
    expenseTotals: [],
    netProfits: [],
    receiptTotals: []
  },

  salesTotal: null,
  totalReceipts: null,
  totalExpenses: null,
  netProfit: null,

  dueInvoices: [],
  newContacts: [],

  recentStudents: [],
  recentClasses: []
}

export default {
  namespaced: true,

  state: initialState,

  getters: getters,

  actions: actions,

  mutations: mutations
}
