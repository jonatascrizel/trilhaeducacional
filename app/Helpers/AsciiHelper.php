<?php

namespace App\Helpers;

class AsciiHelper
{
    /**
     * Returns the description of an ASCII character
     *
     * @param int $code ASCII code
     * @return string Character description
     */
    public static function getDescription(int $code): string
    {
        $descriptions = [
            0 => 'Nulo (Null character)',
            1 => 'Início do cabeçalho (Start of Header)',
            2 => 'Início do texto (Start of Text)',
            3 => 'Fim do texto (End of Text)',
            4 => 'Fim da transmissão (End of Transmission)',
            5 => 'Consulta (Enquiry)',
            6 => 'Reconhecimento (Acknowledgment)',
            7 => 'Campainha (Bell)',
            8 => 'Backspace',
            9 => 'Tabulação horizontal (Horizontal Tab)',
            10 => 'Nova linha (Line feed)',
            11 => 'Tabulação vertical (Vertical Tab)',
            12 => 'Nova página (Form feed)',
            13 => 'Retorno de carro (Carriage return)',
            14 => 'Mudar para conjunto externo (Shift Out)',
            15 => 'Voltar ao padrão (Shift In)',
            16 => 'Link de dados (Data Link Escape)',
            17 => 'Controle de dispositivo 1 (Device Control 1)',
            18 => 'Controle de dispositivo 2 (Device Control 2)',
            19 => 'Controle de dispositivo 3 (Device Control 3)',
            20 => 'Controle de dispositivo 4 (Device Control 4)',
            21 => 'Confirmação negativa (Negative Acknowledgment)',
            22 => 'Modo síncrono (Synchronous Idle)',
            23 => 'Fim do bloco de transmissão (End of Transmission Block)',
            24 => 'Cancelar (Cancel)',
            25 => 'Fim da mídia (End of Medium)',
            26 => 'Substituição (Substitute)',
            27 => 'Escape',
            28 => 'Separador de arquivo (File Separator)',
            29 => 'Separador de grupo (Group Separator)',
            30 => 'Separador de registro (Record Separator)',
            31 => 'Separador de unidade (Unit Separator)',
            32 => 'Espaço (Space)',
            127 => 'Delete',
            128 => 'Início do caractere estendido',
            255 => 'Espaço sem quebra (Non-breaking space)'
        ];

        return $descriptions[$code] ?? '';
    }
}
