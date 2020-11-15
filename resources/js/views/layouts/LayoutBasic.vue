<template>
  <div class="template-container" v-if="isAppLoaded">
    <base-modal />
    <site-header/>
    <site-sidebar type="basic"/>

    <transition
      name="fade"
      mode="out-in">
      <router-view />
    </transition>
    <site-footer/>
  </div>
  <div v-else class="template-container">
    <font-awesome-icon icon="spinner" class="fa-spin"/>
  </div>
</template>
<script type="text/babel">
import SiteHeader from './partials/TheSiteHeader.vue'
import SiteFooter from './partials/TheSiteFooter.vue'
import SiteSidebar from './partials/TheSiteSidebar.vue'
import Layout from '../../helpers/layout'
import BaseModal from '../../components/base/modal/BaseModal'
import { mapActions, mapGetters } from 'vuex'

export default {
  components: {
    SiteHeader, SiteSidebar, SiteFooter, BaseModal
  },
  data () {
    return {
      'header': 'header'
    }
  },
  computed: {
    ...mapGetters([
      'isAppLoaded'
    ]),

    ...mapGetters('branch', {
      selectedBranch: 'getSelectedBranch',
      branches: 'getBranches'
    }),

    isShow () {
      return true
    }
  },
  mounted () {
    Layout.set('layout-default')
  },

  created () {
    this.bootstrap().then((res) => {
      this.setInitialBranch()
    })
  },

  methods: {
    ...mapActions(['bootstrap']),
    ...mapActions('branch', ['setSelectedBranch']),
    setInitialBranch () {
      let selectedBranch = Ls.get('selectedBranch') !== null

      if (selectedBranch) {
        let foundBranch = this.branches.find((branch) => branch.id === parseInt(selectedBranch))

        if (foundBranch) {
          this.setSelectedBranch(foundBranch)
          return
        }
      }

      this.setSelectedBranch(this.branches[0])
    }
  }
}
</script>
<style lang="scss" scoped>
body {
  background-color: #f8f8f8;
}
</style>
