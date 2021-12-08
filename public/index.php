<?php

function autoloader($className)
{
    $class_pieces = explode('\\', $className);
    switch ($class_pieces[0])
    {
        case 'app':
            require __DIR__ . '/../' . implode(DIRECTORY_SEPARATOR, $class_pieces) . '.php';
            break;
        case 'lib':
            unset($class_pieces[0]);
            require __DIR__ . '/../vendor/application/' . implode(DIRECTORY_SEPARATOR, $class_pieces) . '.php';
            break;
    }
}

spl_autoload_register('autoloader', true, true);

try
{
    $app = new lib\router\App();

    $app->run();
}
catch (Error $e)
{
    echo "Error code: " . $e->getCode() . "<br>";
    echo "Error message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile () . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}