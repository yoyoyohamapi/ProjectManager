<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/4/21
 * Time: 上午10:28
 */

namespace CSCV\Bundle\StorageBundle\Document;


final class Disease
{
    const MELANOMA = 0; // 黑素瘤
    const PN = 1; // 色素痣
    const BCC = 2; // 基底细胞癌
    const SK = 3; // 脂溢性角化症

    /**
     * 返回对应的皮肤病类型数组
     * @return array
     */
    public static function getHashArray()
    {
        return array(
            Disease::MELANOMA => '黑素瘤',
            Disease::PN => '色素痣',
            Disease::BCC => '基底细胞癌',
            Disease::SK => '脂溢性角化症'
        );
    }
}