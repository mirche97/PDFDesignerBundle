<?php

namespace Shopline\Bundle\PDFDesignerBundle\Datagrid;

use Symfony\Component\Translation\TranslatorInterface;

use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\EntityBundle\Grid\GridHelper as BaseGridHelper;
use Oro\Bundle\EntityBundle\Provider\EntityProvider;

class DesignerTemplateGridHelper extends BaseGridHelper
{
    /** @var TranslatorInterface */
    protected $translator;

    /**
     * Constructor
     *
     * @param EntityProvider      $entityProvider
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityProvider $entityProvider, TranslatorInterface $translator)
    {
        parent::__construct($entityProvider);
        $this->translator = $translator;
    }

    /**
     * Returns callback for configuration of grid/actions visibility per row
     *
     * @return callable
     */
    public function getActionConfigurationClosure()
    {
        return function (ResultRecordInterface $record) {
            if ($record->getValue('isSystem')) {
                return array('delete' => false);
            }
        };
    }

    /**
     * Returns designer template type choice list
     *
     * @return array
     */
    public function getTypeChoices()
    {
        return [
            'html' => 'shopline.filter.type.html',
            'txt'  => 'shopline.filter.type.txt'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityNames()
    {
        $result            = [];
        $result = array_merge($result, parent::getEntityNames());

        return $result;
    }
}
