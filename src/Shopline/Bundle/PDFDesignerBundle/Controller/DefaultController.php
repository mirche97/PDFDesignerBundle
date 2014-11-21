<?php

namespace Shopline\Bundle\PDFDesignerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Oro\Bundle\EmailBundle\Provider\SystemVariablesProvider;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate as DesignerTemplate;

/**
 * @Route("/pdfdesigner")
 */

class DefaultController extends Controller
{
    /**
     * @Route("/template/update/{id}", requirements={"id"="\d+"}, defaults={"id"=0}, name="shopline_designertemplate_update" )
     * @Acl(
     *      id="shopline_designertemplate_update",
     *      type="entity",
     *      class="ShoplinePDFDesignerBundle:DesignerTemplate",
     *      permission="EDIT"
     * )
     * @Template("ShoplinePDFDesignerBundle:Default:create.html.twig")
     */
      
     public function updateAction(DesignerTemplate $entity, $isClone = false){
        return $this->update($entity, $isClone);
    } 
    /**
     * @Route("/templates/", name="shopline_manage_template"  )
     * @Acl(
     *      id="shopline_pdfdesignertemplate_update",
     *      type="entity",
     *      class="ShoplinePDFDesignerBundle:DesignerTemplate",
     *      permission="EDIT"
     * )
     * @Template()
     */

    public function indexAction($name='')
    {
        return $this->render('ShoplinePDFDesignerBundle:Default:index.html.twig');
    }
    /**
     * @Route("/template/create", name="shopline_designertemplate_create")
     * @Acl(
     *      id="shopline_designertemplate_create",
     *      type="entity",
     *      class="ShoplinePDFDesignerBundle:DesignerTemplate",
     *      permission="CREATE"
     * )
     * @Template()
     * @AclAncestor("shopline_designertemplate_create")
     */
    public function createAction(){
        return $this->update( new DesignerTemplate() );
    }
    /**
     * @Route("/preview/{id}/{pdf}", name="shopline_designertemplate_preview", requirements={"id"="\d+"}, defaults={"pdf" = null }))
     * @Acl(
     *      id="shopline_designertemplate_preview",
     *      type="entity",
     *      class="ShoplinePDFDesignerBundle:DesignerTemplate",
     *      permission="VIEW"
     * )
     * @Template("ShoplinePDFDesignerBundle:Default:preview.html.twig")
     * @param bool|int $id
     * @return array
     */
    public function previewAction($id, $pdf='')
    {
        if (!$id) {
            $designerTemplate = new DesignerTemplate();
        } else {
            /** @var EntityManager $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $designerTemplate = $em->getRepository('Shopline\Bundle\PDFDesignerBundle\Entity\DesignerTemplate')->find($id);
        }
        
        $loadedEntity = $em->getRepository($designerTemplate->getEntityName())->findAll();
        foreach( $loadedEntity as $entity ){
            $neededEntity = $entity;
            break;
        }
//        $loadedEntity = new $className();
        
        $twig = new \Twig_Environment(new \Twig_Loader_String());
        
        $content = $designerTemplate->getContent();
        
        
        $str = $designerTemplate->getContent().'';
        $system = $this->get('oro_email.emailtemplate.variable_provider.system')->getVariableValues();
        $content = $twig->render($str, array('entity'=> $neededEntity, 'system' => $system));
        
        $data = array(
            'header' => $designerTemplate->getHeader(),
            'footer' => $designerTemplate->getFooter(),
            'styleContent'=>$designerTemplate->getStyleContent(),
            'content'=> $content,
            'id' => $id,
            'pdf'=> $pdf,
            'system' => $system,
            'entity' => $loadedEntity
        );
        
        if( $pdf == 'pdf' ){
            $html = $this->renderView('ShoplinePDFDesignerBundle:Default:preview.html.twig', $data);

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="'.$designerTemplate->getName().'.pdf"'
                )
            );
        }
        
         //$content
        return $data;
    }
    /**
     * @param DesignerTemplate $entity
     * @param bool $isClone
     * @return array
     */
    protected function update(DesignerTemplate $entity, $isClone = false)
    {
        if ($this->get('shopline.form.handler.designertemplate')->process($entity)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('oro.email.controller.emailtemplate.saved.message')
            );

            return $this->get('oro_ui.router')->redirectAfterSave(
                ['route' => 'shopline_designertemplate_update', 'parameters' => ['id' => $entity->getId()]],
                ['route' => 'shopline_manage_template'],
                $entity
            );
        }

        return array(
            'reportGroup' => 'Table',
            'entity'  => $entity,
            'form'    => $this->get('shopline.form.designertemplate')->createView(),
            'entities' => $this->get('oro_report.entity_provider')->getEntities(),
            'metadata' => $this->get('oro_query_designer.query_designer.manager')->getMetadata('report'),
            'isClone' => $isClone
        );
    }

}
