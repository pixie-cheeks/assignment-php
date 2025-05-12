<?php
/**
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 */

function __echo_p(mixed $value): void
{
    echo '<p class="print_log">' . print_r($value, true) . '</p>';
}

function print_log(mixed $value): void
{
    if (is_bool($value)) {
        __echo_p($value ? 'true' : 'false');
        return;
    }

    __echo_p($value);
}