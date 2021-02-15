<?php
public function index() {



//        $page = Post::with(['attributes', 'childs' => function($q) {
//                        $q->with(['childs' => function($qu) {
//                                $qu->with(['childs' => function($subq) {
//                                        $subq->where('status', 'publish');
//                                        $subq->where('type', 'page');
//                                        $subq->orderBy('sort_order', 'asc');
//                                    }]);
//                                $qu->where('status', 'publish');
//                                $qu->where('type', 'page');
//                                $qu->orderBy('sort_order', 'asc');
//                            }]);
//                        $q->where('status', 'publish');
//                        $q->where('type', 'page');
//                        $q->orderBy('sort_order', 'asc');
//                    }, 'category' => function($query) {
//                        $query->where('status', 'publish');
//                    }])->where('type','page')->where('status', 'publish')->where(function($q){
//                        $q->where('parent_id',0);
//                        $q->orWhere('parent_id',null);
//                    })->get(['id','title','title_urdu','slug']);
//
//        return $page;












    $columes = array('id', 'title', 'title_urdu', 'slug', 'url', 'short_discription', 'short_discription_urdu', 'type', 'media_id', 'sort_order');

    $welcomeMessage = Post::where([
        'id' => 14,
        'status' => 'publish',
        'type' => 'page',
    ])->first($columes);
    $chairpersonStatement = Post::with('attributes')->where([
        'id' => 15,
        'status' => 'publish',
        'type' => 'page',
    ])->first($columes);
    $newsEvents = Post::with('attributes')->where([
        'status' => 'publish',
        'is_featured' => 1,
        'type' => 'photo-gallery',
    ])->with(['category' => function($query) {
        $query->where('status', 'publish');
    }])->take(3)
        ->orderBy('sort_order', 'ASC')
        ->get($columes);

    $newsHighlights = Post::where([
        'status' => 'publish',
        'type' => 'news-highlights',
    ])
        ->take(3)
        ->orderBy('id', '=', 'desc')
        ->get($columes);

    $slides = Post::with('media')->where([
        'status' => 'publish',
        'type' => 'slide',
    ])
        ->take(3)
        ->orderBy('id', '=', 'desc')
        ->get($columes);

    $this->data['welcomeMessage'] = $welcomeMessage;
    $this->data['chairpersonStatement'] = $chairpersonStatement;
    $this->data['notifiedOilPrices'] = $this->getMenu('notified_oil_prices');
    $this->data['licenses'] = $this->getMenu('licenses');
    $this->data['notifiedGasPrices'] = $this->getMenu('notified_gas_prices');
    $this->data['mediaCentre'] = $this->getMenu('media_centre');
    $this->data['decisionsAppeals'] = $this->getMenu('decisions_appeals');
    $this->data['publicHearingConsultation'] = $this->getMenu('public_hearing_consultation');
    $this->data['newsEvents'] = $newsEvents;
    $this->data['newsHighlights'] = $newsHighlights;
    $this->data['slides'] = $slides;

    return view('front.page.home')->with($this->data);
}

public function detailPage($slug) {

    $page = Post::with(['attributes', 'childs' => function($q) {
        $q->with(['childs' => function($qu) {
            $qu->where('status', 'publish');
            $qu->orderBy('sort_order', 'asc');
        }]);
        $q->where('status', 'publish');
        $q->orderBy('sort_order', 'asc');
    }, 'category' => function($query) {
        $query->where('status', 'publish');
    }])->where('slug', $slug)->where('status', 'publish')->first();

    if (!$page) {
        return redirect("/no-found/404");
    }
    $isSearchOn = false;
    $reports = [];
    $listType = StringHelper::slugify($page->getCustomAttribute('reports_type'));
    $qoute = Post::where(['status' => 'publish', 'type' => 'quote'])->first(array('id', 'title', 'title_urdu', 'sort_order', 'short_discription', 'short_discription_urdu'));

    if ($listType == 'video') {
        $reports = Post::with(['attributes'])
            ->where('status', 'publish')
            ->where('type', $listType)
            ->orderBy('id', 'DESC')
            ->take(4)->get();
        $recentVideos = Post::with(['attributes'])
            ->where('status', 'publish')
            ->where('type', $listType)
            ->orderBy('id', 'DESC')
            ->paginate($this->recordLimit);
    } elseif ($listType == 'downlaodable') {
        $categories = $page->category()->where('status', 'publish')->pluck('category_id');
        if (!empty($categories) && $categories->count() > 0) {



//                        $reports = Category::with(['posts' => function($query) use ($listType) {
//                                        $query->where('status', 'publish');
//                                        $query->where('type', 'page');
//                                    }])
//                                ->where('status', 'publish')
//                                ->whereIn('id', $categories)
//                                ->paginate($this->recordLimit);


            $reports = \App\Models\CategoryPost::with(['categories' => function($query) use ($listType) {
                $query->with(['posts' => function($q) use ($listType) {
                    $q->where('status', 'publish');
                    $q->where('type', $listType);
                    $q->orderBy('sort_order', 'ASC');
                }]);
                $query->where('status', 'publish');
                $query->where('type', $listType);
            }])
                ->where('post_id', $page->id)
                ->whereIn('category_id', $categories)
                ->orderBy('sort_order', 'asc')
                ->paginate($this->recordLimit);
        }
    } else {
        $reports = Category::with(['posts' => function($query) {
            $query->where('status', 'publish');
            $query->orderBy('id', 'DESC');
        }])
            ->where('status', 'publish')
            ->where('type', $listType)
            ->orderBy('id', 'DESC')
            ->paginate($this->recordLimit);
    }


    if (isset($reports) && !empty($reports)) {
        if ($reports->count() > 0) {
            $isSearchOn = TRUE;
        }
    }

    $columes = ['id', 'parent_id', 'title', 'title_urdu', 'slug', 'sort_order', 'url', 'is_featured'];
    $sidebarTitle = $page->getTitle();
    // $sidebarItems = $page->childs()->orderBy('sort_order')->get($columes);
    $sidebarItems = $page->childs;
    if ($page->parent_id != 0) {
        $parent = $page->getParent($page);
        $parentId = $parent->id;
        if ($parentId != '' || $parentId != null) {
            $sidebarItems = Post::with(['childs' => function($qu) {
                $qu->where('status', 'publish');
                $qu->orderBy('sort_order', 'asc');
            }])->where('parent_id', $parentId)->where('status', 'publish')->orderBy('sort_order', 'asc')->get();
            $sidebarTitle = $parent->getTitle();
        }
    }


    $sitemap = null;
    if ($page->id == 138) {
        $sitemap = Post::with(['attributes', 'childs' => function($q) {
            $q->with(['childs' => function($qu) {
                $qu->with(['childs' => function($subq) {
                    $subq->where('status', 'publish');
                    $subq->where('type', 'page');
                    $subq->orderBy('sort_order', 'asc');
                }]);
                $qu->where('status', 'publish');
                $qu->where('type', 'page');
                $qu->orderBy('sort_order', 'asc');
            }]);
            $q->where('status', 'publish');
            $q->where('type', 'page');
            $q->orderBy('sort_order', 'asc');
        }, 'category' => function($query) {
            $query->where('status', 'publish');
        }])->where('type', 'page')->where('status', 'publish')->where(function($q) {
            $q->where('parent_id', 0);
            $q->orWhere('parent_id', null);
        })->get(['id', 'parent_id', 'title', 'title_urdu', 'slug']);
    }



    $this->data['sitemap'] = $sitemap;
    $this->data['page'] = $page;
    $this->data['sidebarItems'] = $sidebarItems;
    $this->data['sidebarTitle'] = $sidebarTitle;
    $this->data['isSearchOn'] = $isSearchOn;
    $this->data['reports'] = $reports;
    $this->data['recentVideos'] = isset($recentVideos) ? $recentVideos : null;
    $this->data['listType'] = isset($listType) ? $listType : null;
    $this->data['qoute'] = isset($qoute) ? $qoute : null;
    $this->data['parentActive'] = ($page->parents()->first($columes)) ? $page->parents()->first($columes)->slug : null;


    return view('front.page.' . $page->template)->with($this->data);
}
?>