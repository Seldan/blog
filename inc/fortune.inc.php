<?php
    function fortune($fortunes) {
        /*returns a random fortune*/
        return $fortunes[rand(0, count($fortunes)-1)];
    }
?>