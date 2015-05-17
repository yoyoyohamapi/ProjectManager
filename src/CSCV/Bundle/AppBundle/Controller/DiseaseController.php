<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/5/15
 * Time: 下午9:30
 */

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\StorageBundle\Document\Disease;
use CSCV\Bundle\StorageBundle\Form\Type\DiseaseType;
use Symfony\Component\HttpFoundation\Request;

class DiseaseController extends BaseController
{

    /**
     * 获得所有疾病
     */
    public function indexAction()
    {
        $disService = $this->get('disease_service');
        $imgService = $this->get('image_service');
        $diseases = $disService->findAll();
        $counts = array(); // 每种分类下的图像数目
        foreach ($diseases as $disease) {
            $counts[] =
                $imgService->getImgCountByDisease($disease->getId());
        }

        return $this->render(
            '@CSCVApp/Disease/index.html.twig',
            array(
                'diseases' => $diseases,
                'counts' => $counts
            )
        );
    }

    /**
     * 显示某种疾病信息
     * @param $objectId 疾病id
     */
    public function showAction($id)
    {
        $disService = $this->get('disease_service');
        $diseases = $disService->findById($id);
        if (!empty($diseases)) {
            return $this->render(
                '@CSCVApp/Disease/show.html.twig',
                array(
                    'disease' => $diseases[0]
                )
            );
        }

    }

    /**
     * 编辑疾病
     * @param $objectId 当前编辑疾病Id
     */
    public function editAction($id)
    {
        $disService = $this->get('disease_service');
        $disease = $disService->findById($id)[0];
        $form = $this->createForm(
            new DiseaseType(),
            $disease
        );

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $disService->save($disease);

                // 返回疾病首页
                return $this->redirectToRoute(
                    'cscv_app_disease_index',
                    array(
                        'id' => $id
                    )
                );
            }
        }

        return $this->render(
            '@CSCVApp/Disease/edit.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * 创建疾病
     *
     */
    public function newAction(Request $requst)
    {
        $disease = new Disease();
        $form = $this->createForm(
            new DiseaseType(),
            $disease
        );
        $form->handleRequest($requst);
        if ($form->isValid()) {
            $disService = $this->get('disease_service');
            $disService->save($disease);

            // 返回疾病首页
            return $this->redirectToRoute('cscv_app_disease_index');
        }

        return $this->render(
            '@CSCVApp/Disease/new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

}