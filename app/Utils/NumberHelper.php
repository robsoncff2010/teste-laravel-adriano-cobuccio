<?php

namespace App\Utils;

class NumberHelper
{
    public static function parseCurrency(?string $value): float
    {
        if (empty($value)) return 0.0;

        $valor = preg_replace('/[^0-9.,]/', '', $value);
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return (float) $valor;
    }
}
