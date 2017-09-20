<?php

namespace Enguys\CoreBundle\Manager;

class PageManager
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var array
     */
    private $breadcrumbs = [];

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaTitle(): ?string
    {
        return $this->metaTitle ?? $this->getTitle();
    }

    /**
     * @param string $metaTitle
     * @return $this
     */
    public function setMetaTitle(?string $metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }

    /**
     * @param array $breadcrumbs
     */
    public function setBreadcrumbs(array $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function addBreadcrumb(string $label, $href = null)
    {
        $this->breadcrumbs[] = ['label' => $label, 'href' => is_null($href) ? '#' : $href];

        return $this;
    }
}
