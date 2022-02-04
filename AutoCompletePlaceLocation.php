<?php

/**
 * Example module.
 */

declare(strict_types=1);

namespace tkempf\Webtrees\AutoCompletePlaceLocation;
use Fisharebest\Localization\Translation;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Module\AbstractModule;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleMapAutocompleteInterface;

/**
 * Class ExampleModule
 *
 * This example shows how to create a custom module.
 * All the functions are optional.  Just implement the ones you need.
 *
 * Modules *must* implement ModuleCustomInterface.  They *may* also implement other interfaces.
 */
class AutoCompletePlaceLocation extends AbstractModule implements ModuleCustomInterface,ModuleMapAutocompleteInterface
{
    // For every module interface that is implemented, the corresponding trait *should* also use be used.
    use ModuleCustomTrait,ModuleMapAutocompleteInterface;

    /**
     * The constructor is called on all modules, even ones that are disabled.
     * Note that you cannot rely on other modules (such as languages) here, as they may not yet exist.
     *
     */
    public function __construct()
    {
    }

    /**
     * Bootstrap.  This function is called on *enabled* modules.
     * It is a good place to register routes and views.
     * Note that it is only called on genealogy pages - not on admin pages.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * How should this module be identified in the control panel, etc.?
     *
     * @return string
     */
    public function title(): string
    {
        return I18N::translate('AutoComplete places via PlaceLocation');
    }

    /**
     * A sentence describing what this module does.
     *
     * @return string
     */
    public function description(): string
    {
        return I18N::translate('Allows autocomplete for places to search in place_location table');
    }

    /**
     * The person or organisation who created this module.
     *
     * @return string
     */
    public function customModuleAuthorName(): string
    {
        return 'Thomas Kempf';
    }

    /**
     * The version of this module.
     *
     * @return string
     */
    public function customModuleVersion(): string
    {
        return '0.1.0';
    }

    /**
     * A URL that will provide the latest version of this module.
     *
     * @return string
     */
    public function customModuleLatestVersionUrl(): string
    {
        return 'https://github.com/tkempf/autocomplete_place_location/raw/main/latest-version.txt';
    }

    /**
     * Where to get support for this module.  Perhaps a github repository?
     *
     * @return string
     */
    public function customModuleSupportUrl(): string
    {
        return 'https://github.com/tkempf/autocomplete_place_location';
    }

    /**
     * Additional/updated translations.
     *
     * @param string $language
     *
     * @return array<string>
     */
    public function customTranslations(string $language): array
    {
        switch ($language) {
            case 'de':
            case 'de-DE':
                return [
                    // These are new translations:
                    'AutoComplete places via PlaceLocation'                                  => 'AutoComplete places via PlaceLocation',
                    'enables autocompletion for places to search in place_location table'    => 'Ermöglicht Autovervollständigung der Orte aus der place_location Tabelle',
                ];

            case 'some-other-language':
                // Arrays are preferred, and are faster.
                // If your module uses .MO files, then you can convert them to arrays like this.
                return (new Translation('path/to/file.mo'))->asArray();

            default:
                return [];
        }
    }
    /**
     * @param string $place
     *
     * @return array<string>
     */
    public function searchPlaceNames(string $place):array{
        return[];
    }

}
