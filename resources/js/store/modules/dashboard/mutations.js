import * as types from './mutation-types'

export default {
  [types.SET_INITIAL_DATA] (state, data) {
    state.students = data.studentsCount
    state.tutors = data.tutorCount
    state.classes = data.classCount
    state.invoices = data.invoicesCount
    state.expenses = data.expenses
    state.recentInvoices = data.invoices
    state.newContacts = data.students
    state.totalDueAmount = data.totalDueAmount

    state.dueInvoices = data.dueInvoices

    state.recentStudents = data.student
    state.recentClasses = data.class

    state.weeklyInvoices.days = data.weekDays
    state.weeklyInvoices.counter = data.counters

    if (state.chartData && data.chartData) {
      state.chartData.months = data.chartData.months
      state.chartData.invoiceTotals = data.chartData.invoiceTotals
      state.chartData.expenseTotals = data.chartData.expenseTotals
      state.chartData.netProfits = data.chartData.netProfits
      state.chartData.receiptTotals = data.chartData.receiptTotals
    }

    state.salesTotal = data.salesTotal
    state.totalReceipts = data.totalReceipts
    state.totalExpenses = data.totalExpenses
    state.netProfit = data.netProfit
  },

  [types.GET_INITIAL_DATA] (state, data) {
    state.isDataLoaded = data
  },

  [types.UPDATE_INVOICE_STATUS] (state, data) {
    let pos = state.dueInvoices.findIndex(invoice => invoice.id === data.id)

    if (state.dueInvoices[pos]) {
      state.dueInvoices[pos].status = data.status
    }
  },

  [types.DELETE_INVOICE] (state, id) {
    let index = state.dueInvoices.findIndex(invoice => invoice.id === id)
    state.dueInvoices.splice(index, 1)
  },
}
