<template>
  <div class="sidebar-left">
    <div class="sidebar-body scroll-pane">
      <div class="side-nav">
        <div
          v-for="(menuItems, index) in menu"
          :key="index"
          class="menu-group"
        >
          <router-link
            v-for="(item, index1) in menuItems"
            :key="index1"
            :to="item.route"
            class="menu-item"
            @click.native="Toggle"
          >
            <font-awesome-icon :icon="item.icon" class="icon menu-icon" /> <span class="ml-3 menu-text">{{ $t(item.title) }}</span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
export default {
  data () {
    return {
      sidebar: 'sidebar',
      menu: [

        [
          {
            title: 'navigation.dashboard',
            icon: 'home',
            route: '/admin/dashboard'
          },
          {
            title: 'navigation.students',
            icon: 'user',
            route: '/admin/students'
          },
          {
            title: 'navigation.class',
            icon: 'users',
            route: '/admin/class'
          }
        ],

        [
          {
            title: 'navigation.invoices',
            icon: 'file-alt',
            route: '/admin/invoices'
          },
          {
            title: 'navigation.payments',
            icon: 'credit-card',
            route: '/admin/payments'
          },
          {
            title: 'navigation.expenses',
            icon: 'money-bill-wave',
            route: '/admin/expenses'
          }
        ],

        [
          {
            title: 'navigation.reports',
            icon: 'signal',
            route: '/admin/reports'
          },
          {
            title: 'navigation.settings',
            icon: 'cog',
            route: '/admin/settings'
          }
        ]

      ]
    }
  },

  methods: {
    Toggle () {
      this.$utils.toggleSidebar()
    }
  }
}
</script>
