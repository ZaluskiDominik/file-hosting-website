<?php if ( !isset($filename) ) throw new UndefinedTemplateContentVar('filename'); ?>

<div class="alert alert-success" role="alert">
    Plik <b><?php echo $filename; ?></b> gotowy do pobrania!
</div>