<?php
if ( !isset($downloadLink) ) 
    throw new UndefinedTemplateContentVar('downloadLink'); 
?>

<button tabindex="-1" class="btn btn-success downloadBtn">
    <a href=<?php echo '"' . $downloadLink . '"'; ?>> Pobierz </a>
</button>