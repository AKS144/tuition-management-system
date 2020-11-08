export default {
    Editors () {
        $('.ls-summernote').summernote()
    
        var editor = $('.ls-simplemde')[0]
    
        if (editor) {
          var simplemde = new SimpleMDE({ element: editor })
        }
      },
      initPlugins (plugins) {
        plugins.forEach((plugin) => {
          if (this.isFunction(this[plugin])) {
            this[plugin]()
          }
        })
      },
    
      isFunction (functionToCheck) {
        var getType = {}
        return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]'
      }
}