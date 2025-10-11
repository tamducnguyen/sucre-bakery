<?php
function require_css($path)
{ ?>
    <script>
        function require_css() {
            const parent = document.head;
            const linkElement = document.createElement("link");
            linkElement.rel = "stylesheet";
            linkElement.href = "<?= $path ?>";
            linkElement.type = "text/css";
            parent.appendChild(linkElement);
            document.currentScript.remove();
        }
        
        require_css();
    </script>
<?php } ?>