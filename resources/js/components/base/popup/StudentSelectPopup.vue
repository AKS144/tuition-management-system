<template>
  <div class="customer-select">
    <div class="main">
      <div class="search-bar">
        <base-input
          v-model="search"
          :placeholder="$t('general.search')"
          focus
          type="text"
          icon="search"
          @input="searchStudent"
        />
      </div>

      <div v-if="(students.length > 0) && !loading" class="list">
        <div
          v-for="(student, index) in students"
          :key="index"
          class="list-item"
          @click="selectNewStudent(student.id)"
        >
          <span class="avatar" >{{ initGenerator(student.name) }}</span>
          <div class="name">
            <label class="title">{{ student.name }}</label>
            <label class="sub-title">{{ student.contact_name }}</label>
          </div>
        </div>
      </div>
      <div v-if="loading" class="list flex justify-content-center align-items-center">
        <font-awesome-icon icon="spinner" class="fa-spin"/>
      </div>
      <div v-if="students.length === 0" class="no-data-label">
        <label> {{ $t('customers.no_customers_found') }} </label>
      </div>
    </div>

    <button type="button" class="list-add-button" @click="openStudentModal">
      <font-awesome-icon class="icon" icon="user-plus" />
      <label>{{ $t('customers.add_new_customer') }}</label>
    </button>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  props: {
    type: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      search: null,
      loading: false
    }
  },
  computed: {
    ...mapGetters('student', [
      'students'
    ])
  },
  created () {
    this.fetchInitialStudents()
  },
  methods: {
    ...mapActions('modal', [
      'openModal'
    ]),
    ...mapActions('student', [
      'fetchStudents'
    ]),
    ...mapActions('invoice', {
      setInvoiceStudent: 'selectStudent'
    }),
    ...mapActions('estimate', {
      setEstimateStudent: 'selectStudent'
    }),
    async fetchInitialStudents () {
      await this.fetchStudents({
        filter: {},
        orderByField: '',
        orderBy: ''
      })
    },
    async searchStudent () {
      let data = {
        display_name: this.search,
        email: '',
        phone: '',
        orderByField: '',
        orderBy: '',
        page: 1
      }

      this.loading = true

      await this.fetchStudents(data)

      this.loading = false
    },
    openStudentModal () {
      this.openModal({
        title: this.$t('students.add_student'),
        componentName: 'StudentModal',
        size: 'lg'
      })
    },
    initGenerator (name) {
      if (name) {
        let nameSplit = name.split(' ')
        let initials = nameSplit[0].charAt(0).toUpperCase()
        return initials
      }
    },
    selectNewStudent (id) {
      if (this.type === 'estimate') {
        this.setEstimateStudent(id)
      } else {
        this.setInvoiceStudent(id)
      }
    }
  }
}
</script>
