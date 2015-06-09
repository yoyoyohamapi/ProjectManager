<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午9:10
 */

namespace CSCV\Bundle\AppBundle\Controller;


use CSCV\Bundle\AppBundle\Utils\JsonMsgUtils;
use CSCV\Bundle\StorageBundle\Document\ApiToken;
use CSCV\Bundle\StorageBundle\Form\Type\ApiTokenType;
use FOS\RestBundle\Util\Codes;
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
        // 表单为添加Modal服务
        $token = new ApiToken();
        $newForm = $this->createForm(
            new ApiTokenType(),
            $token
        );
        $editForm = $this->createForm(
            new ApiTokenType(),
            $token
        );
        return $this->render(
            '@CSCVApp/Token/index.html.twig',
            array(
                'tokens' => $tokens,
                'newForm' => $newForm->createView(),
                'editForm' => $editForm->createView()
            )
        );
    }

    /**
     * 创建Token
     */
    public function newAction(Request $request)
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
            $jsonData[] = 'create a new token';
            $statusCode = Codes::HTTP_CREATED;
            $msg = JsonMsgUtils::SUCCESS_MSG;
        } else {
            $jsonData = JsonMsgUtils::FORM_INVALID_CB;
            $msg = JsonMsgUtils::ERROR_MSG;
            $statusCode = Codes::HTTP_BAD_REQUEST;
        }

        return $this->createJsonResponse($jsonData, $statusCode, $msg);

    }

    /**
     * 刷新Token
     * @param $id 待更新Token对象ID
     */
    public function updateAction(Request $request)
    {
        $tokenService = $this->get('api_token_service');
        $tokenId = $request->get('token_id');
        $request->request->remove('token_id');
        $token = $tokenService->findById($tokenId);
        $form = $this->createForm(
            new ApiTokenType(),
            $token,
            array(
                'method' => 'PUT'
            )
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            // 刷新Token
            $newTokenStr = $tokenService->generateToken();
            $token->setToken($newTokenStr);
            $tokenService->save($token);
            $jsonData = "refresh token";
            $msg = JsonMsgUtils::SUCCESS_MSG;
            $statusCode = Codes::HTTP_OK;
        } else {
            $jsonData = JsonMsgUtils::FORM_INVALID_CB;
            $msg = JsonMsgUtils::ERROR_MSG;
            $statusCode = Codes::HTTP_BAD_REQUEST;
        }

        return $this->createJsonResponse($jsonData, $statusCode, $msg);

    }

    /**
     * 删除Token
     * @param $id 待删除对象Id
     */
    public function removeAction(Request $request)
    {
        $tokenService = $this->get('api_token_service');
        $token = $tokenService->findById($request->get('id'));
        if (!$token) {
            $jsonData = JsonMsgUtils::NO_SUCH_RESOURCE_CB;
            $statusCode = Codes::HTTP_NOT_FOUND;
            $msg = JsonMsgUtils::ERROR_MSG;
        } else {
            $tokenService->remove($token);
            $jsonData = 'remove the apiToken successfully';
            $statusCode = Codes::HTTP_NO_CONTENT;
            $msg = JsonMsgUtils::SUCCESS_MSG;
        }

        return $this->createJsonResponse(
            $jsonData,
            $statusCode,
            $msg
        );
    }

}