<div class="presentation">
    <figure class="presentation__content">
        <img src="<?php
        if (isset($header_break)) {
            if (isset($searchUsers)) {
                if ($searchUsers === false) {
                    echo '../';
                } else {
                    echo '../../';
                }
            } else {
                echo $header_break;
            }
        }   
        ?>../img/logo.png" alt="Logo" draggable="false" class="img-fluid w-50">
    </figure>
</div>