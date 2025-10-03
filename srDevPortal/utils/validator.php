<?php 

// sanitizes a string and returns sanitized string
function sanitize($str){
    $str = trim($str);
    $str = stripslashes($str);
    $str = filter_var($str, FILTER_SANITIZE_STRING);
    $str = strip_tags($str);
    $str = htmlentities($str);
    return $str;
}

// validates a str is less than certain number of characters
function validateStr($str, $chars){
    $length = strlen($str);
    if($length > 1 && $length < $chars){
        return $str;
    } else {
        return false;
    }
}

// checks that the number is a valid integer
function validateNum($num){
    return filter_var($num, FILTER_VALIDATE_INT);
}