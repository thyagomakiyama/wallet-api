<?php

namespace Domain\ValueObjects;

class CPF extends Document
{
    protected function validate(string $document): bool
    {
        $document = preg_replace('/[^0-9]/', '', $document);

        if ((strlen($document) != 11) || (preg_match('/(\d)\1{10}/', $document))) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $document[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($document[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
