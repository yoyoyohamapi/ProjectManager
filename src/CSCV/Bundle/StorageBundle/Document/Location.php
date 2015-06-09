<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/4/21
 * Time: 上午10:28
 */

namespace CSCV\Bundle\StorageBundle\Document;


final class Location
{
    const HEAD = 0; // 头
    const FACE = 1; // 脸
    const NECK = 2; // 颈部
    const UPPER_LIMB = 3; // 上肢
    const HAND = 4; // 手
    const THORACIC = 5; // 胸部
    const BACK = 6; // 背部
    const BELLY = 7; // 腹部
    const WAIST = 8; // 腰部
    const BUTTOCKS = 9; // 臀部
    const GENITALS = 10; // 生殖器
    const LOWER_LIMB = 11; // 下肢
    const LEG = 12; // 脚

    public static function getHashArray()
    {
        return array(
            Location::HEAD => '头部',
            Location::FACE => '脸',
            Location::NECK => '颈部',
            Location::UPPER_LIMB => '上肢',
            Location::HAND => '手',
            Location::THORACIC => '胸部',
            Location::BACK => '背部',
            Location::BELLY => '腹部',
            Location::WAIST => '腰部',
            Location::BUTTOCKS => '臀部',
            Location::GENITALS => '生殖器',
            Location::LOWER_LIMB => '下肢',
            Location::LEG => '脚',
        );
    }
}