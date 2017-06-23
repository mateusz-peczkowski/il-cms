<?php

namespace App\Http\Controllers\cmsbackend;

use App\Http\Requests\StoreNodeNavigation;
use App\Http\Requests\UpdateNodeTitle;
use App\Repositories\Contracts\NavigationRepositoryInterface;
use App\Repositories\Contracts\NavigationNodeRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\PageRepositoryInterface;
use Auth;
use Session;
use CMS;

class NavigationNodesController extends BackendController
{
    public function __construct(NavigationRepositoryInterface $navigations, NavigationNodeRepositoryInterface $navigation_nodes, LanguageRepositoryInterface $languages, PageRepositoryInterface $pages)
    {
        parent::__construct();
        $this->navigations = $navigations;
        $this->navigation_nodes = $navigation_nodes;
        $this->languages = $languages;
        $this->pages = $pages;
    }

    /**
     * Show the application resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $navigation = $this->navigations->find($id);
        $locale = $this->checkLocale($navigation->slug);

        $pages = $this->pages->allActivePages($locale);
        $nodes = $this->navigation_nodes->allByNavigation($id, $locale);

        $tree = null;

        if($nodes) {
            $tree = $this->buildTree($nodes, null);
        }

        $this->breadcrumbs->addCrumb(__('Nawigacja').' - '.__($navigation->title), '/cmsbackend/navigations/'.$id);
        return view('cmsbackend.navigation_nodes.index')->with([
            'breadcrumbs' => $this->breadcrumbs,
            'pageTitle' => __('Nawigacja').' - '.__($navigation->title),
            'navigation' => $navigation,
            'tree' => $tree,
            'pages' => $pages,
            'nodes' => $nodes,
            'is_active_nav' => 'navigations-'.$navigation->tag,
            'all_languages' => $this->languages->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\StoreNodeNavigation  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, StoreNodeNavigation $request)
    {
        $obj = $request->only('title', 'page_id', 'parent_id');
        $redirect = redirect()->route('nodes', $id);
        $obj['locale'] = $this->checkLocale($this->navigations->find($id)->slug);
        $obj['navigation_id'] = $id;
        $obj['who_updated'] = Auth::id();
        if($obj['page_id'] == 'new') {
            $obj['title'] = ($obj['title'] ?: __('Nowa strona'));
            $last = $this->pages->findBy('locale', $obj['locale']) ? $this->pages->findBy('locale', $obj['locale'])->orderBy('order', 'desc')->first() : false;
            $order = $last ? $last->order+1 : '1';
            $page = $this->pages->create([
                'name' => $obj['title'],
                'url' => '/'.($obj['parent_id'] ? str_slug($this->navigation_nodes->find($obj['parent_id'])->title) : '').str_slug($obj['title']),
                'locale' => $obj['locale'],
                'order' => $order,
                'status' => 1,

            ]);
            $obj['page_id'] = $page->id;
        }
        $obj['title'] = ($obj['title'] ?: $this->pages->find($obj['page_id'])->name);
        $obj['order'] = $this->checkOrder($id, $obj['parent_id'], $obj['locale']);
        $this->navigation_nodes->create($obj);
        return redirect()->route('nodes', $id)->with([
            'status' => __('Element został dodany'),
            'status_type' => 'success'
        ]);
    }

    /**
     * update created resource in storage.
     *
     * @param  int  $id
     * @param  \App\Http\Requests\UpdateModule  $request
     * @return \Illuminate\Http\Response
     */
    public function update($nav_id, UpdateNodeTitle $request)
    {
        $title = $request->get('change_title');
        $node = $request->get('change_id');
        $this->navigation_nodes->update([
            'title' => $title,
            'who_updated' => Auth::id()
        ], $node);
        return redirect()->route('nodes', $nav_id)->with([
            'status' => __('Tytuł został zmieniony'),
            'status_type' => 'success'
        ]);
    }

    /**
     * Change set locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function locale($navigation_slug, $slug)
    {
        Session::put('cms_locale_navigation_'.$navigation_slug, $slug);
    }

    /**
     * Check component locale.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkLocale($slug)
    {
        if(Session::has('cms_locale_navigation_'.$slug) && CMS::isLocale(Session::get('cms_locale_navigation_'.$slug))) {
            return Session::get('cms_locale_navigation_'.$slug);
        }
        $this->locale($slug, CMS::getDefaultLocale());
        return CMS::getDefaultLocale();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($navigation_id, $id)
    {
        $this->navigation_nodes->destroy($id);

        return redirect()->route('nodes', $navigation_id)->with([
            'status' => __('Element usunięty'),
            'status_type' => 'danger'
        ]);

    }

    /**
     * @param  int  $id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function checkOrder($navigation_id, $parent_id = null, $locale = '')
    {
        $order = 1;

        $navigation_nodes = $this->navigation_nodes->countByParentNav($navigation_id, $parent_id, $locale);

        if($navigation_nodes) {
            $order = $navigation_nodes->order + 1;
        }

        return $order;
    }


    private function buildTree($elements, $parentId = null) {
        $tree = array();

        if(!$elements->isEmpty()) {
            foreach ($elements as $element) {
                if ($element->parent_id === $parentId) {
                    $children = $this->buildTree($elements, $element['id']);
                    if ($children) {
                        $element->children = $children;
                    }
                    $tree[] = $element;
                }
            }

        }

        return $tree;
    }


}
