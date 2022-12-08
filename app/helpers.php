<?php
        
if (! function_exists('clean')) {
  function clean(string $data) 
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES);
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
    return $data;
  }
}