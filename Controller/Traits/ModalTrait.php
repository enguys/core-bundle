<?php

namespace Enguys\CoreBundle\Controller\Traits;

trait ModalTrait
{
    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string $type The fully qualified class name of the form type
     * @param mixed $data The initial data for the form
     * @param array $options Options for the form
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    protected function createForm($type, $data = null, array $options = [])
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $options['action'] = $request->getRequestUri();

        return parent::createForm($type, $data, $options);
    }

    /**
     * Creates and returns a form builder instance.
     *
     * @param mixed $data The initial data for the form
     * @param array $options Options for the form
     *
     * @return \Symfony\Component\Form\FormBuilder|\Symfony\Component\Form\FormBuilderInterface
     */
    protected function createFormBuilder($data = null, array $options = [])
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $options['action'] = $request->getRequestUri();

        return parent::createFormBuilder($data, $options);
    }

    /**
     * @param string $fallbackUrl
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectBack(string $fallbackUrl)
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $destination = $request->query->get('destination');
        if (!empty($destination)) {
            return $this->redirect($destination);
        }
        $uri = $request->getUri();
        $referer = $request->headers->get('referer');
        if ($uri === $referer) {
            return $this->redirect($fallbackUrl);
        }

        return $this->redirect(!empty($referer) ? $referer : $fallbackUrl);
    }
}
