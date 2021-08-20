<?php

namespace Domain\ValueObjects;

class CNPJ extends Document
{

    protected function validate(string $document): bool
    {
        $document = preg_replace('/[^0-9]/', '', $document);

        if ((strlen($document) != 14) || (preg_match('/(\d)\1{13}/', $document))) {
            return false;
        }

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $document[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($document[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $document[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $document[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
