<?php

namespace common\models\traits;

/**
 * Trait Translit
 * @package common\models\traits
 */
trait Translit {

    protected function translitName()
    {
        $tr = \Transliterator::create('Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();');
        $s = $tr->transliterate($this->Name);
        $s = preg_replace('/[-\s]+/', '-', $s);

        $this->Translit = trim($s, '-');

    }
}
