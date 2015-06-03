<?php
/**
 * Created by CSCV.
 * Desc: 疾病控制器
 * User: Woo
 * Date: 15/6/2
 * Time: 上午11:09
 */

namespace CSCV\Bundle\RESTBundle\Controller;


use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DiseaseController extends BaseController
{

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="获得所有疾病"
     * )
     */
    public function getDiseasesAction()
    {
        $diseases = $this->get('disease_service')
            ->findAll();
        $view = $this->view($diseases, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="通过Id获得疾病"
     * )
     * @param $id 疾病Id
     */
    public function getDiseaseAction($id)
    {
        $disease = $this->get('disease_service')
            ->findById($id);
        $view = $this->view($disease, 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *      resource=true,
     *      description="获得疾病下的所有图像",
     * )
     * @param $disease 疾病号
     */
    public function getDiseaseImagesAction($disease)
    {
        $images = $this->get('image_service')
            ->findByDisease($disease);
        $view = $this->view($images, 200);

        return $this->handleView($view);
    }


}