<template>
  <div class="item-selector">
    <base-select
      ref="baseSelect"
      v-model="studentSelect"
      :options="students"
      :show-labels="false"
      :preserve-search="false"
      :placeholder="$t('students.type_or_click')"
      label="name"
      class="multi-select-item"
      @close="checkStudents"
      @value="onTextChange"
      @select="(val) => $emit('select', val)"
      @remove="deselectStudent"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  data () {
    return {
      studentSelect: null,
      loading: false
    }
  },
  computed: {
    ...mapGetters('student', [
      'students'
    ])
  },
  methods: {
    ...mapActions('student', [
      'fetchStudents'
    ]),
    async searchStudents (search) {
      this.loading = true

      await this.fetchStudents({search})

      this.loading = false
    },
    onTextChange (val) {
      this.searchStudents(val)
    },
    checkStudents (val) {
      if (!this.students.length) {
        this.fetchStudents()
      }
    },
    deselectStudent () {
      this.studentSelect = null
      this.$emit('deselect')
    }
  }
}
</script>
