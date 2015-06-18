<?php
namespace CSCV\Bundle\AppBundle\Services\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Created by CSCV.
 * Desc: 自定义Twig扩展
 * User: Woo
 * Date: 15/6/18
 * Time: 下午2:44
 */
class CustomTwigExtension extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'asset_if' => new \Twig_Function_Method($this, 'asset_if'),
        );
    }


    public function getName()
    {
        return 'custom_twig_extension';
    }

    public function asset_if($path, $fallbackPath)
    {
        // Define the path to look for
        $pathToCheck = realpath($this->container->get('kernel')->getRootDir().'/../web/').'/'.$path;

        // If the path does not exist, return the fallback image
        if (!file_exists($pathToCheck)) {
            return $this->container->get('templating.helper.assets')->getUrl($fallbackPath);
        }

        // Return the real image
        return $this->container->get('templating.helper.assets')->getUrl($path);
    }


}