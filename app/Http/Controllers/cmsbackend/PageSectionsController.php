<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StorePageSection;
use App\Http\Requests\UpdatePageSection;
use App\PageSection;
use App\Repositories\Contracts\SectionRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Services\SectionFields\SectionFields;
use Auth;

/**
 * Page Sections Resource Controller
 *
 * Class PageSectionsController
 * @package App\Http\Controllers\cmsbackend
 */
class PageSectionsController extends BackendController
{
    public function __construct(PageRepositoryInterface $pages, SectionRepositoryInterface $sections)
    {
        parent::__construct();
        $this->pages = $pages;
        $this->sections = $sections;
    }

    /**
     * Show the application resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $page = $this->pages->getPageSections($id);
        $sections = $page->sections;

        $options = count($sections) ? $this->pages->getPageSectionsPaginated($id) : collect([]);

        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Sekcje'), '/cmsbackend/pages/'.$id.'/sections');
        return view('cmsbackend.sections.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Sekcje'),
            'page' => $page,
            'options' => $options,
            'is_active_nav' => 'pages'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\StorePageOption  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StorePageSection $request)
    {
        $obj = $request->only('title', 'type');
        $obj['who_updated'] = Auth::id();
        $obj['options'] = [];

        $section = $this->sections->create($obj);
        $pageSection = new PageSection(['page_id' => $id, 'section_id' => $section->id]);
        $section->page()->save($pageSection);

        return redirect()->route('pages.sections', $id)->with([
            'status' => __('Sekcja dodana'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = $this->sections->find($id);
        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj sekcję'), '/cmsbackend/pages/options/'.$id.'/edit');
        return view('cmsbackend.sections.edit')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj sekcje'),
            'option' => $option
        ]);
    }

    /**
     * Update created resource.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdatePage  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdatePageSection $request)
    {
        $obj = $request->only('title', 'type');
        $obj['who_updated'] = Auth::id();
        $this->sections->update($obj, $id);
        $page = $this->sections->find($id)->page->pop();

        return redirect()->route('pages.sections', $page->id)->with([
            'status' => __('Sekcja zaktualizowana'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Edit value of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function value($id)
    {
        $option = $this->sections->find($id);
        $sections = SectionFields::parseSections(collect([$option]));

        $this->breadcrumbs->addCrumb(__('Strony'), '/cmsbackend/pages');
        $this->breadcrumbs->addCrumb(__('Edytuj sekcje'), '/cmsbackend/pages/sections/'.$id.'/edit');
        $this->breadcrumbs->addCrumb(__('Edytuj wartość'), '/cmsbackend/pages/sections/'.$id);
        return view('cmsbackend.sections.value')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Edytuj wartość'),
            'option' => $option,
            'section' => $sections
        ]);
    }

    /**
     * Update value of created resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_value($id, Request $request)
    {
        $obj = $request->only('title', 'header', 'content', 'option');
        $obj['who_updated'] = Auth::id();
        $this->sections->update($obj, $id);
        $page = $this->sections->find($id)->page->pop();

        return redirect()->route('pages.sections', $page->id)->with([
            'status' => __('Wartość sekcji zaaktualizowana'),
            'status_type' => 'success'
        ]);
    }

    /**
     * @param  string  $module
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = $this->sections->find($id)->page->pop();
        $this->sections->destroy($id);

        return redirect()->route('pages.sections', $page->id)->with([
            'status' => __('Sekcja usunięta'),
            'status_type' => 'danger'
        ]);

    }
}
