<?php
function redirect($path)
{ ?>
    <script>
        function redirect() {
            window.location.href = "<?= $path ?>";
            document.currentScript.remove();
        }

        redirect();
    </script>
<?php } ?>