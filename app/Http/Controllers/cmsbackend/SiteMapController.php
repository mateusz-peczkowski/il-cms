<?php

namespace App\Http\Controllers\cmsbackend;

use App\Repositories\Contracts\ModuleRecordRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Repositories\Contracts\SiteMapRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class SiteMapController extends BackendController
{
    public function __construct(SiteMapRepositoryInterface $sitemap, PageRepositoryInterface $page, ModuleRecordRepositoryInterface $moduleRecord)
    {
        parent::__construct();
        $this->sitemap = $sitemap;
        $this->page = $page;
        $this->moduleRecord = $moduleRecord;
    }

    public function index()
    {
        $this->breadcrumbs->addCrumb(__('Mapa strony'), '/cmsbackend/sitemap');
        $records = $this->sitemap->paginatedRecords();

        return view('cmsbackend.sitemap.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Mapa strony'),
            'records' => $records,
            'is_active_nav' => 'settings/sitemap'
        ]);
    }

    public function store(Request $request)
    {
        $obj = $request->only('url', 'type', 'update_frequency', 'priorty');
        if(!$this->sitemap->checkRecordExistByUrl($obj['url'])) {
            $obj['who_updated'] = Auth::id();
            $obj['status'] = 1;
            $obj['media'] = '';
            $obj['translations'] = null;
            $this->sitemap->create($obj);
            return redirect()->route('sitemap.index')->with([
                'status' => __('Rekord został dodany'),
                'status_type' => 'success'
            ]);
        }
        return redirect()->route('sitemap.index')->with([
            'status' => __('Rekord już istnieje w systemie'),
            'status_type' => 'danger'
        ])->withInput();
    }

    public function edit($id)
    {
        $record = $this->sitemap->find($id);
        $this->breadcrumbs->addCrumb(__('Mapa strony'), '/cmsbackend/sitemap');
        $this->breadcrumbs->addCrumb(__('Edytuj rekord'), '/cmsbackend/sitemap/'.$id.'/edit');
        return view('cmsbackend.sitemap.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj element mapy strony'),
            'record' => $record,
            'is_active_nav' => 'settings/sitemap'
        ]);
    }

    public function update($id, Request $request)
    {
        $obj = $request->only('url', 'type', 'update_frequency', 'priorty');
        $obj['who_updated'] = Auth::id();
        $this->sitemap->update($obj, $id);
        return redirect()->route('sitemap.index')->with([
            'status' => __('Rekord został zaaktualizowany'),
            'status_type' => 'success'
        ]);
    }

    public function delete($id)
    {
        $statusmsg = __('Rekord usunięty');
        return $this->change_status($id, 3, $statusmsg, 'success');
    }

    public function scan()
    {
        $this->populateSiteMapDefault();

        return redirect()->route('sitemap.index')->with([
            'status' => __('Rekordy mapy strony zostały wygenerowane'),
            'status_type' => 'success'
        ]);
    }

    private function change_status($id, $status, $statusmsg, $statusmsgtype)
    {
        $this->sitemap->update([
            'status' => $status,
            'who_updated' => Auth::id()
        ], $id);
        return redirect()->route('sitemap.index')->with([
            'status' => $statusmsg,
            'status_type' => $statusmsgtype
        ]);
    }

    protected function populateSiteMapDefault()
    {
        $pages = $this->page->all();

        foreach ($pages as $page) {
            $this->sitemap->create([
                'url' => URL::to($page->url),
                'media' => $page->thumbnail ? URL::to($page->thumbnail) : '',
                'element_type' => 'page',
                'update_frequency' => 'daily',
                'translations' => null,
                'who_updated' => Auth::id()
            ]);
        }

        $modules = $this->moduleRecord->all();
        foreach ($modules as $module) {
            $this->sitemap->create([
                'url' => URL::to('module', ['slug' => $module->slug]),
                'media' => '',
                'element_type' => 'module',
                'update_frequency' => 'daily',
                'translations' => null,
                'who_updated' => Auth::id()
            ]);
        }
        return;
    }
}
