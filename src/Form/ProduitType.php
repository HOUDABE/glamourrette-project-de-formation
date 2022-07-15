<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreProduit')
            ->add('descProduit')
            ->add('prixProduit')
            ->add('dateArrive')
            ->add('categorieR')
            ->add('imageProduit', FileType::class, [
                
                // unmapped means that this field is not associated to any entity property
              
                'mapped' => false,
                'required' => false,  
                'help' => 'PNG, JPG, JPEG, JP2, WEBP ou PDF - 2 Mo maximum', 
                
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximum autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            // 'image/*',
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2',
                            'image/webp',
                            'application/pdf',
                         ],
                         'mimeTypesMessage' => 'Le format de fichier est invalide ({{ type }}). Les types autorisés sont : {{ types }}'
                    ])
                ]

           ])
           ->add('valaider',SubmitType::class)
       ;
   }
  

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}