<?php

namespace Shopline\Bundle\PDFDesignerBundle\Form\Handler;

use Doctrine\ORM\EntityManager;

use Psr\Log\LoggerInterface;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Translation\Translator;

use Shopline\Bundle\PDFDesignerBundle\Form\Model\Designer;
use Shopline\Bundle\PDFDesignerBundle\Mailer\Processor;

use Oro\Bundle\EntityBundle\Tools\EntityRoutingHelper;

use Oro\Bundle\LocaleBundle\Formatter\NameFormatter;

class DesignerHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var Processor
     */
    protected $emailProcessor;

    /**
     * @var NameFormatter
     */
    protected $nameFormatter;

    /**
     * @var EntityRoutingHelper
     */
    protected $entityRoutingHelper;

    /**
     * @param FormInterface            $form
     * @param Request                  $request
     * @param EntityManager            $em
     * @param Translator               $translator
     * @param SecurityContextInterface $securityContext
     * @param LoggerInterface          $logger
     * @param Processor                $emailProcessor
     * @param NameFormatter            $nameFormatter
     * @param EntityRoutingHelper      $entityRoutingHelper
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        FormInterface $form,
        Request $request,
        EntityManager $em,
        Translator $translator,
        SecurityContextInterface $securityContext,
        Processor $emailProcessor,
        LoggerInterface $logger,
        NameFormatter $nameFormatter,
        EntityRoutingHelper $entityRoutingHelper
    ) {
        $this->form                = $form;
        $this->request             = $request;
        $this->em                  = $em;
        $this->translator          = $translator;
        $this->securityContext     = $securityContext;
        $this->emailProcessor      = $emailProcessor;
        $this->logger              = $logger;
        $this->nameFormatter       = $nameFormatter;
        $this->entityRoutingHelper = $entityRoutingHelper;
    }

    /**
     * Process form
     *
     * @param  Email $model
     * @return bool True on successful processing, false otherwise
     */
    public function process(Email $model)
    {
        if ($this->request->getMethod() === 'GET') {
            $this->initModel($model);
        }
        $this->form->setData($model);

        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                try {
                    $this->emailProcessor->process($model);
                    return true;
                } catch (\Exception $ex) {
                    $this->logger->error('Email sending failed.', array('exception' => $ex));
                    $this->form->addError(
                        new FormError($this->translator->trans('oro.email.handler.unable_to_send_email'))
                    );
                }
            }
        }

        return false;
    }

    /**
     * Populate a model with initial data.
     * This method is used to load an initial data from a query string
     *
     * @param Email $model
     */
    protected function initModel(Email $model)
    {
        if ($this->request->query->has('gridName')) {
            $model->setGridName($this->request->query->get('gridName'));
        }
        if ($this->request->query->has('entityClass')) {
            $model->setEntityClass(
                $this->entityRoutingHelper->decodeClassName($this->request->query->get('entityClass'))
            );
        }
        if ($this->request->query->has('entityId')) {
            $model->setEntityId($this->request->query->get('entityId'));
        }
        if ($this->request->query->has('from')) {
            $from = $this->request->query->get('from');
            if (!empty($from)) {
                $this->preciseFullEmailAddress($from);
            }
            $model->setFrom($from);
        }
        if ($this->request->query->has('to')) {
            $to = trim($this->request->query->get('to'));
            if (!empty($to)) {
                $this->preciseFullEmailAddress($to, $model->getEntityClass(), $model->getEntityId());
            }
            $model->setTo(array($to));
        }
        if ($this->request->query->has('subject')) {
            $subject = trim($this->request->query->get('subject'));
            $model->setSubject($subject);
        }
    }

    /**
     * @param string      $emailAddress
     * @param string|null $ownerClass
     * @param mixed|null  $ownerId
     */
    protected function preciseFullEmailAddress(&$emailAddress, $ownerClass = null, $ownerId = null)
    {
    }

    /**
     * Get the current authenticated user
     *
     * @return UserInterface|null
     */
    protected function getUser()
    {
        $token = $this->securityContext->getToken();
        if ($token) {
            $user = $token->getUser();
            if ($user instanceof UserInterface) {
                return $user;
            }
        }

        return null;
    }
}
