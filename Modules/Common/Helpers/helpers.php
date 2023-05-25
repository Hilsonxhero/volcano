<?php


function front_path($path, $param = [])
{
    $base = getenv("FRONT_ENDPOINT");
    return $base . $path . "?" . http_build_query($param);
}
