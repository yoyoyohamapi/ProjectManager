<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午9:10
 */

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\StorageBundle\Document\ApiToken;
use CSCV\Bundle\StorageBundle\Form\Type\ApiTokenType;
use Symfony\Component\HttpFoundation\Request;

class TokenController extends BaseController
{

    /**
     * 显示token
     */

    public function indexAction()
    {
        $tokenService = $this->get('api_token_service');
        $tokens = $tokenService->findAll();

        return $this->render(
            '@CSCVApp/Token/index.html.twig',
            array('tokens' => $tokens)
        );
    }

    /**
     * 创建Token
     */
    public function createAction(Request $request)
    {

        $token = new ApiToken();
        $form = $this->createForm(
            new ApiTokenType(),
            $token
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            // 获得ApiToken服务
            $tokenService = $this->get('api_token_service');
            // 产生Token字串
            $tokenStr = $tokenService->generateToken();
            $token->setToken($tokenStr);
            $tokenService->save($token);

            return $this->redirectToRoute('cscv_app_token_index');
        }

        return $this->render(
            '@CSCVApp/Token/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * 刷新Token
     * @param $id 待更新Token对象ID
     */
    public function editAction($id)
    {
        $tokenService = $this->get('api_token_service');
        $token = $tokenService->findById($id)[0];

        $form = $this->createForm(
            new ApiTokenType(),
            $token
        );
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                // 刷新Token
                $newTokenStr = $tokenService->generateToken();
                $token->setToken($newTokenStr);
                $tokenService->save($token);

                // 返回Token列表
                return $this->redirectToRoute('cscv_app_token_index');
            }
        }

        return $this->render(
            '@CSCVApp/Token/edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * 删除Token
     * @param $id 待删除对象Id
     */
    public function removeAction($id)
    {
        $tokenService = $this->get('api_token_service');
        $token = $tokenService->findById($id)[0];

        $tokenService->remove($token);

        return $this->redirectToRoute('cscv_app_token_index');
    }

}