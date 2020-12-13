<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap;

class ErrorHandler
{
    public function handle($nb, $msg, $file, $line)
    {
        $message = "($nb): $msg in file $file on line $line";
        throw new \RuntimeException($message);
    }
}