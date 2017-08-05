<?php

namespace backend\models;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $view_times
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @var
     */
    public $imgFile;//logo头像路径
    public static $sale_options = [1=>'上架',0=>'下架'];
    public static $status_options = [1=>'正常',0=>'删除'];
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getBrandOptions(){
        return ArrayHelper::map(Brand::find()->where(['!=','status',-1])->asArray()->all(),'id','name');
    }
    public function getGallerys()
    {
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
    }
//     获取商品详情
    public function getGoodsIntro()
    {
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    public function getGoodsCategory()
    {
        return $this->hasOne(Goods::className(),['id'=>'goods_category_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time', 'view_times'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => 'LOGO图片',
            'goods_category_id' => '商品分类id',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否在售(1在售 0下架)',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '添加时间',
            'view_times' => '浏览次数',
        ];
    }
}
