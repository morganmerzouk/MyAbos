<?php
namespace App\FrontOfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class ResiliationType extends AbstractType
{

    private $id;

    private $contractId;

    private $em;

    public function __construct(EntityManager $em, $id = null, $contractId = null)
    {
        $this->em = $em;
        $this->id = $id;
        $this->contractId = $contractId;
    }

    /**
     *
     * @param FormBuilderInterface $builder            
     * @param array $options            
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->id;
        $builder->add('causeResiliation', 'entity', array(
            'label' => false,
            'class' => 'AppMainBundle:CauseResiliation',
            'query_builder' => function (EntityRepository $er) use($id) {
                return $er->createQueryBuilder('c')
                    ->where('c.category = :id')
                    ->setParameter(":id", $this->id);
            },
            'attr' => array(
                'class' => 'form-control select-cause-resiliation'
            )
        ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver            
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\MainBundle\Entity\Contract'
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return 'app_mainbundle_causeresiliation';
    }
}
