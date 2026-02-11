<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslatorService
{
    protected $translator;

    public function __construct()
    {
        $lang = Session::get('app_locale', 'fr'); 

        $this->translator = new GoogleTranslate($lang);
        $this->translator->setSource(null); // auto detect
        //$this->translator->setUrlBase('https://translate.googleapis.com/translate_a/single'); 
    }

    public function translate($text)
    {
        return $this->translator->translate($text);
    }
}