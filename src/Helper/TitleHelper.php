<?php

namespace rococo\seo\Helper;

use Pagekit\Application as App;

/**
 * Class TitleHelper
 *
 * @package rococo\seo\Helper
 */
class TitleHelper
{
    
    /**
     * @var array
     */
    protected $path = [];
    
    /**
     * @var array
     */
    protected $title = [];
    
    /**
     * @var array
     */
    protected $title_data = [];
    
    /**
     * @var
     */
    protected $seo;
    
    /**
     * TitleHelper constructor.
     */
    public function __construct()
    {
        $this->seo = App::module('spqr/seo');
    }
    
    /**
     * @param $meta
     *
     * @return string
     */
    public function generateTitle($meta)
    {
        $ordering = [];
        
        if ($this->seo->config('site_structure.title.use_og')
            && !empty($meta->get('og:title'))
        ) {
            $this->title_data[] = [
                'title'    => $meta->get('og:title'),
                'ordering' => $this->seo->config('site_structure.title.og_ordering'),
            ];
        }
        if ($this->seo->config('site_structure.title.use_sitename')
            && !empty(App::config('system/site')->get('title'))
        ) {
            $this->title_data[] = [
                'title'    => App::config('system/site')->get('title'),
                'ordering' => $this->seo->config('site_structure.title.sitename_ordering'),
            ];
        }
        if ($this->seo->config('site_structure.title.use_pagename')
            && !empty(App::node()->title)
        ) {
            $this->title_data[] = [
                'title'    => App::node()->title,
                'ordering' => $this->seo->config('site_structure.title.pagename_ordering'),
            ];
        }
        
        if ($this->seo->config('site_structure.title.use_path')) {
            $path = $this->generatePath();
            if ($path) {
                $this->title_data[] = [
                    'title'    => $path,
                    'ordering' => $this->seo->config('site_structure.title.path_ordering'),
                ];
            }
        }
        
        foreach ($this->title_data as $key => $row) {
            $ordering[$key] = $row['ordering'];
        }
        
        array_multisort($ordering, SORT_ASC, $this->title_data);
        
        foreach ($this->title_data as $t) {
            $this->title[] = $t['title'];
        }
        
        $title
            = implode($this->seo->config('site_structure.title.separator'),
            $this->title);
        
        return $title;
    }
    
    /**
     * @return bool|string
     */
    private function generatePath()
    {
        $node         = App::node();
        $frontpage    = App::config('system/site')->get('frontpage');
        $is_frontpage = $frontpage == $node->id;
        
        while ($parent_id = $node->parent_id) {
            if ($node = $node->find($parent_id, true)) {
                $is_frontpage = $is_frontpage ? : $frontpage == $node->id;
                $this->addPath($node->title);
            }
        }
        
        $tmp_path = [];
        
        foreach (array_reverse($this->getPaths()) as $title) {
            $tmp_path[] = $title;
        }
        
        if (is_array($tmp_path)) {
            $tmp_path = array_slice($tmp_path,
                $this->seo->config('site_structure.title.path_level'));
            if (is_array($tmp_path)) {
                return implode($this->seo->config('site_structure.title.separator'),
                    $tmp_path);
            }
        }
        
        return false;
    }
    
    /**
     * @param $path
     */
    public function addPath($path){
        $this->path[] = $path;
    }
    
    /**
     * @return array
     */
    public function getPaths(){
        return $this->path;
    }
    
}