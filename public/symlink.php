<?php
/**
 * A work arround to create the storage link on the server
 * instead of using php artisan storage:link command
 */

symlink(
    __DIR__ . '/../storage/app/public',
    __DIR__ . '/storage'
);