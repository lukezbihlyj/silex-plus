<?php

namespace LukeZbihlyj\SilexPlus\Locale;

use Silex\Application;

/**
 * @package LukeZbihlyj\SilexPlus\Locale\LocaleHandler
 */
class LocaleHandler
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     * @return self
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * @param string $locale
     * @return void
     */
    public function init($locale = null)
    {
        if ($locale) {
            return $this->setLocale($locale);
        }

        $locale = $this->app->getSession()->get('locale');

        if ($locale) {
            return $this->setLocale($locale);
        }

        return $this->setLocale($this->app['i18n.default_locale']);
    }

    /**
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        putenv('LC_ALL=' . $locale);
        setlocale(LC_ALL, $locale);

        bindtextdomain('app', $this->app['i18n.locale_path']);
        bind_textdomain_codeset('app', 'UTF-8');

        textdomain('app');
    }
}
