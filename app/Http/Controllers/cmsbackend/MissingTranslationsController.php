<?php

namespace App\Http\Controllers\cmsbackend;

use Illuminate\Http\Request;
use App\Repositories\Contracts\TranslationRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Auth;

class MissingTranslationsController extends BackendController
{
    public function __construct(TranslationRepositoryInterface $translations, LanguageRepositoryInterface $language)
    {
        parent::__construct();
        $this->translations = $translations;
        $this->language = $language;
    }

    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Brakujące tłumaczenia'), '/cmsbackend/settings/translations');

        $missingTranslations = [];
        $languages = $this->language->all();
        $languagesArray = $languages->mapWithKeys(function ($item, $key) {
            return [$item->slug => $item->title];
        })->toBase();

        $translations = $this->translations->all()->groupBy('key');

        $translations->each(function ($items, $key) use ($languagesArray, &$missingTranslations) {
            $locales = $items->map(function($item, $key) {
                return $item->locale;
            });

            $missingLanguage = $languagesArray->except($locales->all());
            $presentLanguage = $languagesArray->only($locales->all());


            if (!$missingLanguage->isEmpty()) {
                $existingTranslations = $items->first();
                $missingTranslations[$key] = [
                    $missingLanguage->toArray(),
                    'translatedValue' => [$presentLanguage[$existingTranslations->locale] => $existingTranslations->value]
                ];
            }

        });

        return view('cmsbackend.missingtranslations.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Brakujące tłmaczenia'),
            'translations' => $missingTranslations,
            'is_active_nav' => 'settings/missing/translations'
        ]);
    }

    public function store(Request $request)
    {
        $translationsData = $request->input('missing_translation');

        foreach ($translationsData as $key => $missingTranslation) {
            if (!empty(array_filter($missingTranslation))) {
                foreach ($missingTranslation as $locale => $value) {
                    $massData = [
                        'key' => $key,
                        'value' => $value,
                        'status' => 1,
                        'locale' => $locale,
                        'who_updated' => Auth::id()
                    ];
                    $this->translations->create($massData);
                }
            }
        }
        return redirect()->route('missing.translations')->with([
            'status' => __('Tłumaczenia zostały uzupełnione'),
            'status_type' => 'success'
        ]);
    }
}
