<?php

declare(strict_types=1);

namespace PrestaShop\Module\Kh_extrafield\Form;

use PrestaShop\PrestaShop\Core\Domain\Product\ValueObject\ProductId;
use PrestaShopBundle\Form\FormBuilderModifier;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;

final class ProductFormModifier
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FormBuilderModifier
     */
    private $formBuilderModifier;

    /**
     * @param TranslatorInterface $translator
     * @param FormBuilderModifier $formBuilderModifier
     */
    public function __construct(
        TranslatorInterface $translator,
        FormBuilderModifier $formBuilderModifier
    ) {
        $this->translator = $translator;
        $this->formBuilderModifier = $formBuilderModifier;
    }

    /**
     * @param ProductId|null $productId
     * @param FormBuilderInterface $productFormBuilder
     */
    public function modify(
        ?ProductId $productId,
        FormBuilderInterface $productFormBuilder,
        $extrafield
    ): void {
        $data['description'] = $extrafield;
        $this->modifyDescriptionTab($data, $productFormBuilder);
    }

    private function modifyDescriptionTab($data, FormBuilderInterface $productFormBuilder): void
    {

        $descriptionTabFormBuilder = $productFormBuilder->get('description');
        $this->formBuilderModifier->addAfter(
            $descriptionTabFormBuilder,
            'description',
            'kh_extrafield',
            TextareaType::class,
            [
                'label' => 'Extra Field',
                'label_attr' => [
                    'title' => 'h2',
                    'class' => 'text-info',
                ],
                'attr' => [
                    'placeholder' => 'EXTRA FIELD',
                    'class' => 'form-control',
                    'rows' => 6,
                ],
        
                'data' => $data['description'] ,
                'empty_data' => '',
                'form_theme' => '@PrestaShop/Admin/TwigTemplateForm/prestashop_ui_kit_base.html.twig',
            ]
        );
    }
}