<?php

namespace App\Libraries;

class ValidationValueConditional
{
    /**
     * requiredIfValue[campoBase,valorEsperado]
     * Torna o campo atual obrigatório se campoBase == valorEsperado.
     */
    public function requiredIfValue(?string $str, string $field, array $data): bool
    {
        $parts = array_map('trim', explode(',', $field, 2));
        if (count($parts) < 2) {
            // Uso incorreto da regra -> não reprova por segurança
            return true;
        }

        [$otherField, $expectedValue] = $parts;
        $otherValue = $data[$otherField] ?? null;

        // Se for requerido, não pode estar vazio
        if ($otherValue == $expectedValue) {
            if (is_array($str)) {
                return ! empty($str);
            }
            return trim((string) ($str ?? '')) !== '';
        }

        // Não requerido -> passa
        return true;
    }

    /**
     * inListIfRequired[campoBase,valorEsperado,op1,op2,...]
     * Só checa se o valor está na lista quando o campo É requerido (condição verdadeira).
     * Se a condição NÃO for verdadeira, a validação é ignorada (passa).
     */
    public function inListIfRequired(?string $str, string $field, array $data): bool
    {
        $parts = array_map('trim', explode(',', $field));
        if (count($parts) < 3) {
            // Precisamos de pelo menos campoBase, valorEsperado e 1 opção
            return true;
        }

        $otherField     = array_shift($parts);
        $expectedValue  = array_shift($parts);
        $allowed        = $parts; // restante são as opções permitidas

        $otherValue = $data[$otherField] ?? null;

        // Se NÃO é requerido, emula "permit_empty": não valida a lista
        if ($otherValue != $expectedValue) {
            return true;
        }

        // Quando É requerido: precisa ser não-vazio e pertencer à lista
        if (is_array($str)) {
            if (empty($str)) {
                return false;
            }
            foreach ($str as $v) {
                if (!in_array((string) $v, $allowed, true)) {
                    return false;
                }
            }
            return true;
        }

        $str = (string) ($str ?? '');
        if ($str === '') {
            return false;
        }

        return in_array($str, $allowed, true);
    }
}
