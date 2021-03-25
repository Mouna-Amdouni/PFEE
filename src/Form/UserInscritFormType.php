<?php


namespace App\Form;


use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserInscritFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->translator = $options['translator'];

        $builder
//            ->add('datenaissance', DateType::class,datepicker::class)


            ->add("username", TextType::class, ["label" => $this->translator->trans('backend.user.username')])
            ->add("email", EmailType::class)
            ->add("nomComplet", TextType::class, ["label" => $this->translator->trans('backend.user.name')])
//            ->add("justpassword", TextType::class, [
//                "label" => $this->translator->trans('backend.user.password'),
//                "required" => true,
//                "mapped" => false,
//                "constraints" => [
//                    new NotBlank(["message" => $this->translator->trans('backend.global.must_not_be_empty')])
//                ]
//            ]);
            ->add('justpassword', RepeatedType::class,[
                'type' => PasswordType::class,
                "label" => $this->translator->trans('backend.user.password'),
                "required" => true,
                "mapped" => false,
                "constraints" => [
                    new NotBlank(["message" => $this->translator->trans('backend.global.must_not_be_empty')])
                ],

                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
            ])
        ;  }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('translator');
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
