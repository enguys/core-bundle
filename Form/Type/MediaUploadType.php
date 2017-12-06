<?php

namespace Enguys\CoreBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Enguys\CoreBundle\Form\DataTransformer\MediaDataTransformer;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaUploadType extends AbstractType
{
    private $em;

    private $router;

    public function __construct(EntityManagerInterface $em, Router $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->addModelTransformer(new MediaDataTransformer($this->em));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $type = $options['media_type'];
        $accept = $options['accept'];
        if (null === $accept && $type === 'image') {
            $accept = 'image/*';
        }
        $view->vars = array_merge($view->vars, [
            'items' => $form->getData(),
            'url' => $this->router->generate('enguys_core_media_upload', ['type' => $type]),
            'media_type' => $type,
            'type' => 'hidden',
            'accept' => $accept,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'media_type' => 'image',
            'accept' => null,
        ]);
        $resolver->setAllowedValues('media_type', ['image', 'file']);
    }

    public function getBlockPrefix()
    {
        return 'media_upload';
    }

    public function getParent()
    {
        return TextType::class;
    }
}
