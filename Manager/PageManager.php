<?php

namespace Enguys\CoreBundle\Manager;

use Symfony\Component\HttpFoundation\RequestStack;

class PageManager
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $metaTitle;

    /**
     * @var string|null
     */
    private $metaAuthor;

    /**
     * @var string|null
     */
    private $metaDescription;

    /**
     * @var array
     */
    private $metaKeywords = [];

    /**
     * @var array
     */
    private $breadcrumbs = [];

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setTitle(?string $title): PageManager
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetaTitle(): ?string
    {
        return $this->metaTitle ?? $this->getTitle();
    }

    /**
     * @param null|string $metaTitle
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setMetaTitle(?string $metaTitle): PageManager
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
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setBreadcrumbs(array $breadcrumbs): PageManager
    {
        $this->breadcrumbs = $breadcrumbs;

        return $this;
    }

    /**
     * @param string $label
     * @param null $href
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function addBreadcrumb(string $label, $href = null): PageManager
    {
        $this->breadcrumbs[] = ['label' => $label, 'href' => $href];

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBodyClass()
    {
        $request = $this->requestStack->getCurrentRequest();

        return str_replace('_', '-', $request->get('_route'));
    }

    /**
     * @return null|string
     */
    public function getMetaAuthor(): ?string
    {
        return $this->metaAuthor;
    }

    /**
     * @param string $metaAuthor
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setMetaAuthor(?string $metaAuthor): PageManager
    {
        $this->metaAuthor = $metaAuthor;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setMetaDescription(?string $metaDescription): PageManager
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * @return array[]
     */
    public function getMetaKeywords(): array
    {
        return array_unique($this->metaKeywords);
    }

    /**
     * @param array[] $metaKeywords
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setMetaKeywords(array $metaKeywords): PageManager
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * @param string $keyword
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function addMetaKeyword(string $keyword): PageManager
    {
        $this->metaKeywords[] = $keyword;

        return $this;
    }
}
