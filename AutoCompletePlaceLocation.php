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
use Fisharebest\Webtrees\Module\ModuleMapAutocompleteTrait;
use Fisharebest\Webtrees\Module\ModuleMapAutocompleteInterface;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * Class AutoCompletePlaceLocation
 *
 * Modules *must* implement ModuleCustomInterface.  This module also implements ModuleMapAutocompleteInterface
 */
class AutoCompletePlaceLocation extends AbstractModule implements ModuleCustomInterface, ModuleMapAutocompleteInterface
{
    // For every module interface that is implemented, the corresponding trait *should* also use be used.
    use ModuleCustomTrait, ModuleMapAutocompleteTrait;

    /**
     * The constructor is called on all modules, even ones that are disabled.
     * Note that you cannot rely on other modules (such as languages) here, as they may not yet exist.
     *
     */
    public function __construct()
    {
    }


    /**
     * Should this module be enabled when it is first installed?
     *
     * @return bool
     */
    public function isEnabledByDefault(): bool
    {
        return false;
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
        return I18N::translate('Allows autocomplete of places by search in place_location table');
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
        return '0.1.2';
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
                    'AutoComplete places via PlaceLocation'                              => 'AutoComplete für Orte via PlaceLocation',
                    'Allows autocomplete of places by search in place_location table'    => 'Ermöglicht Autovervollständigung der Orte aus der place_location Tabelle',
                ];

            //case 'some-other-language':
                // Arrays are preferred, and are faster.
                // If your module uses .MO files, then you can convert them to arrays like this.
                // return (new Translation('path/to/file.mo'))->asArray();

            default:
                return [];
        }
    }

    /**
     * @param string $place
     *
     * @return array<string>
     */
    public function searchPlaceNames(string $place): array
    {
        $query = DB::table('place_location AS p0')
            ->leftJoin('place_location AS p1', 'p1.id', '=', 'p0.parent_id')
            ->leftJoin('place_location AS p2', 'p2.id', '=', 'p1.parent_id')
            ->leftJoin('place_location AS p3', 'p3.id', '=', 'p2.parent_id')
            ->leftJoin('place_location AS p4', 'p4.id', '=', 'p3.parent_id')
            ->leftJoin('place_location AS p5', 'p5.id', '=', 'p4.parent_id')
            ->leftJoin('place_location AS p6', 'p6.id', '=', 'p5.parent_id')
            ->leftJoin('place_location AS p7', 'p7.id', '=', 'p6.parent_id')
            ->leftJoin('place_location AS p8', 'p8.id', '=', 'p7.parent_id')
            ->orderBy('p0.place')
            ->orderBy('p1.place')
            ->orderBy('p2.place')
            ->orderBy('p3.place')
            ->orderBy('p4.place')
            ->orderBy('p5.place')
            ->orderBy('p6.place')
            ->orderBy('p7.place')
            ->orderBy('p8.place')
            ->select([
                'p0.place AS place0',
                'p1.place AS place1',
                'p2.place AS place2',
                'p3.place AS place3',
                'p4.place AS place4',
                'p5.place AS place5',
                'p6.place AS place6',
                'p7.place AS place7',
                'p8.place AS place8',
            ]);
        // Filter each level of the hierarchy.
        foreach (explode(',', $place, 9) as $level => $string) {
            $query->where('p' . $level . '.place', 'LIKE', '%' . addcslashes($string, '\\%_') . '%');
        }
        $plc = [];
        foreach ($query->cursor() as $row) {
            $plc[] = implode(', ', array_filter((array) $row));
        };
        return $plc;
    }
}
