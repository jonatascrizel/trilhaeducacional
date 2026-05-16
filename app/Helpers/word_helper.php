<?php

if (!function_exists('highlight_word')) {
    /**
     * Destaca uma palavra em um texto
     *
     * @param string $text Texto completo
     * @param string $word Palavra para destacar
     * @param bool $caseSensitive Diferencia maiúsculas e minúsculas
     * @return string Texto com a palavra destacada
     */
    function highlight_word(string $text, string $word, bool $caseSensitive = false): string
    {
        if (empty($word)) {
            return $text;
        }

        $highlight = '<span class="bg-warning text-dark px-1 rounded">$0</span>';
        
        if ($caseSensitive) {
            return preg_replace('/' . preg_quote($word, '/') . '/', $highlight, $text);
        } else {
            return preg_replace('/' . preg_quote($word, '/') . '/i', $highlight, $text);
        }
    }
}

// Adiciona o helper ao CodeIgniter
helper(['word']);
