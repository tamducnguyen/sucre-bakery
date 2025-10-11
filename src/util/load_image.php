<?php
function load_image($blob)
{
    echo "data:image/jpeg;base64," . base64_encode($blob);
}