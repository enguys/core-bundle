<?php

namespace Enguys\CoreBundle\Manager;

use Symfony\Component\HttpFoundation\RequestStack;

class PageManager
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    private $config;

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
    private $ogProperties = [];

    /**
     * @var array
     */
    private $breadcrumbs = [];

    public function __construct(RequestStack $requestStack, array $config = [])
    {
        $this->requestStack = $requestStack;
        $this->config = $config;
        if (!empty($config['page']['default_og_title'])) {
            $this->setOgTitle($config['page']['default_og_title']);
        }
        if (!empty($config['page']['default_og_description'])) {
            $this->setOgDescription($config['page']['default_og_description']);
        }
        if (!empty($config['page']['default_og_image'])) {
            $this->setOgImage($config['page']['default_og_image']);
        }
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
        if (!in_array('og:title', $this->ogProperties)) {
            $this->setOgTitle($title);
        }

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
        if (!in_array('og:description', $this->ogProperties)) {
            $this->setOgDescription($metaDescription);
        }

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

    /**
     * @return array
     */
    public function getOgProperties(): array
    {
        return $this->ogProperties;
    }

    /**
     * @param array $ogProperties
     *
     * @return \Enguys\CoreBundle\Manager\PageManager
     */
    public function setOgProperties(array $ogProperties): PageManager
    {
        $this->ogProperties = $ogProperties;

        return $this;
    }

    /**
     * @param string $property
     * @param string $content
     *
     * @return $this
     */
    public function setOgProperty(string $property, string $content)
    {
        $this->ogProperties[$property] = $content;

        return $this;
    }

    /**
     * @param string $property
     *
     * @return $this
     */
    public function removeOgProperty(string $property)
    {
        if (in_array($property, $this->ogProperties)) {
            unset($this->ogProperties[$property]);
        }

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setOgType(string $content)
    {
        $this->setOgProperty('og:type', $content);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setOgTitle(string $content)
    {
        $this->setOgProperty('og:title', $content);
        if (!in_array('twitter:card', $this->ogProperties)) {
            $this->setOgProperty('twitter:card', 'summary');
        }
        if (!in_array('twitter:title', $this->ogProperties)) {
            $this->setOgProperty('twitter:title', $content);
        }

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setOgUrl(string $content)
    {
        $this->setOgProperty('og:url', $content);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setOgImage(string $content)
    {
        $this->setOgProperty('og:image', $content);
        if (!in_array('twitter:card', $this->ogProperties)) {
            $this->setOgProperty('twitter:card', 'summary');
        }
        if (!in_array('twitter:image', $this->ogProperties)) {
            $this->setOgProperty('twitter:image', $content);
        }

        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setOgDescription(string $content)
    {
        $this->setOgProperty('og:description', $content);
        if (!in_array('twitter:card', $this->ogProperties)) {
            $this->setOgProperty('twitter:card', 'summary');
        }
        if (!in_array('twitter:description', $this->ogProperties)) {
            $this->setOgProperty('twitter:description', $content);
        }

        return $this;
    }
}
