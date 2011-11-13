<?php  
  function etc_init_form_classes() {
    global $lep;

    $lep->formclasses['inputText'] = 'inputText';
    $lep->formclasses['inputPassword'] = 'inputText';
    $lep->formclasses['textarea'] = 'textarea';
    $lep->formclasses['inputCheckbox'] = 'inputCheckbox';
    $lep->formclasses['inputRadio'] = 'inputRadio';
    $lep->formclasses['select'] = 'select';
    $lep->formclasses['selectmulti'] = 'selectmulti';
    $lep->formclasses['inputFile'] = 'inputFile';
    $lep->formclasses['richtext'] = 'richtext';
    $lep->formclasses['date'] = 'date';
    $lep->formclasses['inputCheckboxmulti'] = 'inputCheckboxmulti';
    $lep->formclasses['inputCheckboxDynamic'] = 'inputCheckboxDynamic';
  }
?>