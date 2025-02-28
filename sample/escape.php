<?php
    if ($_POST){
        $_POST = array_map(function($val) {
            return is_array($val)? array_map('htmlspecialchars', $val) : htmlspecialchars($val);
        }, $_POST);
    }
