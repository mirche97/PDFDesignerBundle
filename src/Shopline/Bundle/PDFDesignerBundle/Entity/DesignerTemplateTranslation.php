<?php

namespace Shopline\Bundle\PDFDesignerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Table(name="shopline_designer_template_translation", indexes={
 *      @ORM\Index(name="lookup_unique_idx", columns={"locale", "object_id", "field"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class DesignerTemplateTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
  
}
