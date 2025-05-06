<?php

namespace App\Helpers;
use Lang;

class Document
{
    private $title;
    private $description;
    private $keywords;
    private $h1;
    private $text;
    private $type;
    private $styles = [];
    private $links = [];
    private $scripts = [];
    private $metas = [];
    private $micro_markup = [];
    private $graphs = [];
    private $breadcrumbs = [];

    public function setMetaTitle($title) {
        $this->title = $title;
    }

    public function getMetaTitle() {
        return $this->title;
    }

    public function setMetaDescription($description) {
        $this->description = $description;
    }

    public function getMetaDescription() {
        return $this->description;
    }

    public function setMetaKeywords($keywords) {
        $this->keywords = $keywords;
    }

    public function getMetaKeywords() {
        return $this->keywords;
    }

    public function setMetaH1($h1) {
        $this->h1 = $h1;
    }

    public function getMetaH1() {
        return $this->h1;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function pushStyle($href, $type = 'text/css', $rel = 'stylesheet', $media = null, $hreflang = null) {
        $this->styles[$href] = array(
            'href'  => public_path($href),// . '?v=' . md5(date("d.m.Y-H:s")),
            'type'  => $type,
            'rel'   => $rel,
        );
    }

    public function pushLink($href, $rel = 'stylesheet', $media = null, $hreflang = null) {
        array_push($this->links, array(
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media,
            'hreflang' => $hreflang,
        ));
    }

    public function getStyles() {
        return $this->styles;
    }

    public function getLinks() {
        return $this->links;
    }

    public function pushScript($href, $sort = 2) {
        $this->scripts[] = [
            'href' => $href . '?v='.md5(date("d.m.Y-H:s:i")),
            'sort' => $sort,
        ];
    }

    public function getScripts() {
        uasort($this->scripts, function($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });
        return $this->scripts;
    }

    public function pushMicroMarkup($micro_markup) {
        $this->micro_markup[] = $micro_markup;
    }

    public function getMicroMarkup() {
        return $this->micro_markup;
    }

    public function pushGraph($property, $content) {
        $this->graphs[$property] = [
            'property' => $property,
            'content' => $content,
//            'content' => mb_substr($content, (stripos($content, 'https:') !== false ? stripos($content, 'https:') + 6 : 0)),
        ];
    }

    public function getGraphs() {
        return $this->graphs;
    }

    public function pushBreadcrumb($title, $href, $type = 'category') {
        $this->breadcrumbs[] = [
            'title' => Lang::get($title),
            'href' => asset_seo($href, $type),
        ];
    }

    public function getBreadcrumbs() {
        return ['breadcrumbs' => $this->breadcrumbs];
    }

    public function setDescription($text){
        $this->text = $text;
    }

    public function getDescription(){
        return $this->text;
    }

    public function pushMeta($name = 'robots', $content = 'noindex, nofollow'){
        $this->metas[] = [
            'name' => $name,
            'content' => $content,
        ];
    }

    public function getMetas(){
        return $this->metas;
    }
}
