<?php
// This is global bootstrap for autoloading

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/stubs/DummyTransport.php';

// SMTP stubs
require_once __DIR__.'/stubs/Smtp/DummyAuthentication.php';
require_once __DIR__.'/stubs/Smtp/DummyCommand.php';
require_once __DIR__.'/stubs/Smtp/DummySimpleCommand.php';
require_once __DIR__.'/stubs/Smtp/DummyAddressCommand.php';
