<?php
/**
 * Created by CSCV.
 * Desc: 访问拒绝异常
 * User: Woo
 * Date: 15/6/9
 * Time: 下午5:51
 */

namespace CSCV\Bundle\RESTBundle\Exception;

class AccessDeniedException extends \Exception
{
    protected $message = 'UnAuthorized';   // 异常信息
    protected $code = 0;
}