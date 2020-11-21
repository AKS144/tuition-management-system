<template>
  <div class="login-page login-3">
    <div class="site-wrapper">
      <div class="login-box">
        <div class="box-wrapper">
          <div class="logo-main">
              <img
                src="/img/logo-white.png"
                alt="Logo">
          </div>
          <router-view></router-view>
          <div class="page-copyright">
            <p>{{ $t('layout_login.copyright_crater') }}</p>
          </div>
        </div>
      </div>
      <div class="content-box">
        <h1>{{ $t('layout_login.tuition_management_system') }}</h1>
        <h2>{{ $t('layout_login.tuition_name') }}</h2>

        <div class="content-bottom"/>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
export default {
  watch: {
    $route: 'onRouteChange'
  },
  mounted () {
    this.setLayoutClasses()
  },
  methods: {
    setLayoutClasses () {
      let body = $('body')
      body.removeClass()
      body.addClass('login-page login-1 skin-crater')
    }
  },
  onRouteChange () {
    $('body').removeClass('login-page')
  }
}
</script>
