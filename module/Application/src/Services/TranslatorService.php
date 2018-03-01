<?php
namespace Application\Services;

use Zend\I18n\Translator\TranslatorInterface;

/**
 * Translator Service
 */
class TranslatorService implements TranslatorInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->locale = 'en_US';
        $this->includeLanguageFiles();
    }

    /**
     * @const
     */
    const LANGUAGE_DIR = '/Users/vlad/Projects/zf-tutorial/module/Application/language/';

    /**
     * Include language files.
     *
     * @return TranslatorService
     */
    public function includeLanguageFiles()
    {
        $this->translator
            ->addTranslationFile('PhpArray', self::LANGUAGE_DIR . 'german.php', null, 'de_DE');
        return $this;
    }

    /**
     * Set locale.
     *
     * @param  string            $locale
     * @return TranslatorService
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Translate.
     *
     * @param  string $message
     * @param  string $textDomain
     * @param  string $locale
     * @return string
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        return $this->translator->translate($message, null, $this->locale);
    }

    public function translatePlural($singular, $plural, $number, $textDomain = 'default', $locale = null)
    {
        return null;
    }
}
