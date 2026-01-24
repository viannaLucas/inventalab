<?php

namespace App\Libraries;

use DateTime;

class ValidacaoBR {

    public function cpf(string $cpf): bool {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function cnpj(string $cnpj): bool {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        $resp = $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
        return $resp;
    }

    public function telefone(string $telefone): bool {
        return preg_match('/^\(\d{2}\) \d{4,5}-\d{4}$/', $telefone);
    }

    public function cep(string $cep): bool {
        return preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep);
    }

    public function dataBR(string $data): bool {
        $formato = 'd/m/Y';
        $d = DateTime::createFromFormat($formato, $data);
        $resp = $d && $d->format($formato) == $data;
        return $resp;
    }

    public function horaBR(string $hora): bool
    {
        return  DateTime::createFromFormat('H:i', $hora) !== false;
    }

    public function dataHoraBR(string $hora): bool
    {
        return  DateTime::createFromFormat('d/m/Y H:i', $hora) !== false;
    }

    public function dataHora(string $hora): bool
    {   
        if($hora == '0000-00-00 00:00:00') return true;
        return  DateTime::createFromFormat('Y-m-d H:i:s', $hora) !== false;
    }

    public function senhaForte(string $senha): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).{6,}$/', $senha) === 1;
    }
}
