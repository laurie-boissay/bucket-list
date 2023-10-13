<?php

namespace App\service;

class Censurator
{
    // Liste des mots indésirables à censurer
    const UNWANTED_WORDS = ["casino", "viagra", "bad", "banana"];

    // Méthode pour purifier le texte en remplaçant les mots indésirables par des astérisques
    public function purify(string $text): string
    {
        // Parcours de la liste des mots indésirables
        foreach (self::UNWANTED_WORDS as $unwantedWord) {
            // Création d'une chaîne d'astérisques de la même longueur que le mot indésirable
            $replacement = str_repeat("*", mb_strlen($unwantedWord));

            // Remplacement insensible à la casse du mot indésirable par la chaîne d'astérisques
            $text = str_ireplace($unwantedWord, $replacement, $text);
        }
        // Retourne le texte censuré
        return $text;
    }
}
