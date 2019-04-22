function file_init(field, params) {
  field = $("[name='" + params.name + "']");
  field.fileinput({
    showPreview: true,
    showDelete: true,
    showRemove: true,
    overwriteInitial: false,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    layoutTemplates: {
      main2: '{preview} {remove} {browse}'
    }
  });
}
