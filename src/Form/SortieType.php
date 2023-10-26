<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie'
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et Heure de la sortie',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => "Date limite d'inscription",
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'label' => 'Nombre de places',
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée (en minutes)',
                'attr' => ['class' => 'duree-input']
            ])
            ->add('infosSortie', TextareaType::class, [
                'label' => 'Descriptions et Infos',
                'required' => false,
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'enable-dependent-fields', // Ajoutez une classe pour identifier les champs dépendants
                    'data-dependent-field' => 'lieu', // Champ dépendant
                    ],
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $sortie = $event->getData();

                $lieu = $sortie->getLieu();
                if ($lieu) {
                    $ville = $lieu->getVille();

                    // Ajoute le champ Ville
                    $form->add('ville', TextType::class, [
                        'data' => $ville->getNom(),
                        'attr' => [
                    'class' => 'dependent-field',
                      ],
                    ]);

                    // Ajoute le champ Rue
                    $form->add('rue', TextType::class, [
                        'data' => $lieu->getRue(),
                        'attr' => [
                            'class' => 'dependent-field',
                        ],
                    ]);

                    // Ajoute le champ Code Postal
                    $form->add('code_postal', TextType::class, [
                        'data' => $ville->getCodePostal(),
                        'attr' => [
                            'class' => 'dependent-field',
                        ],
                    ]);

                    // Ajoute le champ Latitude
                    $form->add('latitude', TextType::class, [
                        'data' => $lieu->getLatitude(),
                        'attr' => [
                            'class' => 'dependent-field',
                        ],
                    ]);

                    // Ajoute le champ Longitude
                    $form->add('longitude', TextType::class, [
                        'data' => $lieu->getLongitude(),
                        'attr' => [
                            'class' => 'dependent-field',
                        ],
                    ]);
                }
            }
        );
    }

        public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
