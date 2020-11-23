export const getStudents = (state) => state.students
export const getTutors = (state) => state.tutors
export const getClasses = (state) => state.classes
export const getInvoices = (state) => state.invoices
export const getExpenses = (state) => state.expenses
export const getRecentInvoices = (state) => state.recentInvoices
export const getNewContacts = (state) => state.newContacts
export const getTotalDueAmount = (state) => state.totalDueAmount

export const getRecentStudents = (state) => state.recentStudents
export const getRecentClasses = (state) => state.recentClasses

export const getDueInvoices = (state) => state.dueInvoices

export const getLoadedData = (state) => state.isDataLoaded

export const getWeeklyInvoicesCounter = (state) => state.weeklyInvoices.counter
export const getWeeklyInvoicesDays = (state) => state.weeklyInvoices.days

export const getChartMonths = (state) => state.chartData.months
export const getChartInvoices = (state) => state.chartData.invoiceTotals
export const getChartExpenses = (state) => state.chartData.expenseTotals
export const getNetProfits = (state) => state.chartData.netProfits
export const getReceiptTotals = (state) => state.chartData.receiptTotals

export const getTotalSales = (state) => state.salesTotal
export const getTotalReceipts = (state) => state.totalReceipts
export const getTotalExpenses = (state) => state.totalExpenses
export const getNetProfit = (state) => state.netProfit
