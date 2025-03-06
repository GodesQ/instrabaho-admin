<?php

if (!function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' Bytes';
        }
    }
}

if (!function_exists('generateContractCodeNumber')) {
    function generateContractCodeNumber()
    {
        return "INS-CTX-" . rand(10000, 100000) . "-" . date('d-m-y');
    }
}
