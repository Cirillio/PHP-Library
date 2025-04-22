<?php
// autoload.php
spl_autoload_register(function ($class) {
    // Преобразуем пространство имен в путь к файлу
    $prefix = 'config\\';
    $base_dir = __DIR__ . '/'; // Базовая директория проекта
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Класс не принадлежит пространству имен config
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
