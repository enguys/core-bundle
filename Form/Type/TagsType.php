<?php

namespace Enguys\CoreBundle\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Enguys\CoreBundle\Form\DataTransformer\TagsDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->addModelTransformer(new TagsDataTransformer($this->em, $options['class']));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars = array_merge($view->vars, [
            'source' => $options['source'],
            'query_name' => $options['query_name'],
            'value_field' => $options['value_field'],
            'label_field' => $options['label_field'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'class' => null,
            'source' => null,
            'query_name' => 'q',
            'value_field' => 'id',
            'label_field' => 'name',
        ]);
        $resolver->setRequired(['class', 'source']);
    }

    public function getBlockPrefix()
    {
        return 'tags';
    }

    public function getParent()
    {
        return TextType::class;
    }
}
