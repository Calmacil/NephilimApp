Calendar = {
  mde : null,
  mdeConfig : {
    spellChecker: false,
    autoSave: {
      enabled: true,
      delay: 1000
    },
    forceSync : true
  },
  
  /**
   * Inits the calendar functions
   * @returns {undefined}
   */
  init: function() {
    Calendar.mde = new SimpleMDE(Calendar.mdeConfig);
    
    
    if (Calendar.mdeConfig.initialValue != undefined && Calendar.mdeConfig.initialValue) {
      Calendar.mde.togglePreview();
    }
  }
};

$(function() {
  Calendar.init();
});