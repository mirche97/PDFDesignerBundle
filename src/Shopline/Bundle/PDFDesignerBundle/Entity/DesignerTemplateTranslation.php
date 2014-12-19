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
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $content;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return DesignerTemplateTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return DesignerTemplateTranslation
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return DesignerTemplateTranslation
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set object
     *
     * @param \Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate $object
     * @return DesignerTemplateTranslation
     */
    public function setObject(\Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate $object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate 
     */
    public function getObject()
    {
        return $this->object;
    }
}
