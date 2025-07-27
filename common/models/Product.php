<?php
namespace common\models;
use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord {
    public static function tableName()
    {
        return 'product';
    }

    public function getAuthor() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getWeight() {
        return $this->hasOne(ProductWeight::className(), ['id' => 'weight_id']);
    }

    public function getType() {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    public function getInnerYarn() {
        return $this->hasOne(ProductYarn::className(), ['id' => 'inner_yarn_id']);
    }

    public function getOuterYarn() {
        return $this->hasOne(ProductYarn::className(), ['id' => 'outer_yarn_id']);
    }

    public function getPrice($productId, $type = null) {
        $product = self::findOne($productId);

        /**
         * Select Inner and outer yarn %
         */
        $innerYarnPercentage = $product->inner_yarn_percent != 0 ? $product->inner_yarn_percent : 1;
        $outerYarnPercentage = $product->outer_yarn_percent;

        /**
         * Select Inner and outer yarns
         */
        $innerYarnCost = $product->inner_yarn_id != 0 ? $product->innerYarn->cost : 1;
        $outerYarnCost = $product->outerYarn->cost;

        /**
         * Select the weight of dozen (yarns weight only without the packing weight)
         */
        $weight = $product->weight->weight_gram;

        /**
         * Calculate the weight of each yarn (eg. 400 * (30 / 100))
         */
        $innerYarnWeight = $weight * ($innerYarnPercentage / 100);
        $outerYarnWeight = $weight * ($outerYarnPercentage / 100);

        /**
         * Calculate the cost of each yarn 
         *
         * eg. 5.00 * 320 / 1000 = $1.6
         */
        $innerYarnFinalCost = $innerYarnCost * $innerYarnWeight / 1000;
        $outerYarnFinalCost = $outerYarnCost * $outerYarnWeight / 1000;

        /**
         * Total cost of yarns
         */
        $totalYarnCost = $innerYarnFinalCost + $outerYarnFinalCost;

        /**
         * Select packing and rubber cost to calculate Total socks cost without other cost
         */
        $rubberCost = Cost::getRubberCost();
        $packingCost = Cost::getPackingCost();
        $totalCostWithoutOther = $rubberCost + $packingCost + $totalYarnCost;

        /**
         * Select Production Capacity
         * Select Other Cost
         * Select Salary cost
         *
         * eg. 6000 / (700 + 2100) = 2.14 $
         */
        $productionCapacity = Cost::getProductionCapacity();
        $otherCost = Cost::getOtherCost();
        $salariesCost = Cost::getSalariesCost();
        $productionOtherSalaries = $productionCapacity / ($otherCost + $salariesCost);

        /**
         * Total socks cost without profit
         */
        $totalSocksCostWithoutProfit = $totalCostWithoutOther + $productionOtherSalaries;

        /**
         * Add the profit
         *
         * eg. 6.5 X 30% = 1.95
         */
        $profitWithPrice = $totalSocksCostWithoutProfit + ($totalSocksCostWithoutProfit * (Cost::getProfitPercentCost() / 100));
        
        //Select Commission & Shipping cost
        $commissionPercent = CommissionShippingCost::getCommissionPercent();
        $shippingCost = CommissionShippingCost::getShippingCost();

        $finalPrice = $profitWithPrice;
        
        // Return the commission value of a product to add it to the invoice items table 
        // when issuing an invoice
        if( $type == 'commission-value' ) {
            if( $commissionPercent != 0 )
                return ($profitWithPrice * ($commissionPercent / 100));
            else
                return 0;
        }
        
        if( $commissionPercent != 0 ) {
            /**
             * Add commission percent if != 0
             * 8.45 * 5% = 0.42
             * The price including commission is 8.45 + 0.42 = 8.87
             */
            $finalPrice = $profitWithPrice + ($profitWithPrice * ($commissionPercent / 100));

        }


        if( $shippingCost != 0 ) {
            /**
             * Add shipping cost, if it is != 0
             * CommissionShipping table and weight table
             *
             * eg. Yarn weight shipping cost is 400 gram * 8 $ / 1000= 3.2 $
             */
            $packingWeightCost = Cost::getPackingWeightCost();
            $yarnWeightShippingCost = $weight * $shippingCost / 1000;
            $packingWeightShippingCost = $packingWeightCost * $shippingCost / 1000;
            $totalShippingCost = $yarnWeightShippingCost + $packingWeightShippingCost;
            $finalPrice = $finalPrice + $totalShippingCost;
        }

    return round($finalPrice,2) ;
    }

    public static function getProductName($productId) {
        return self::findOne($productId)->product_name;
    }

    public static function isAvailiable($productId) {
        return self::find()->where(['id' => $productId, 'availiable' => 1])->exists();
    }
    
    public static function exists($productId) {
        return self::find()->where(['id' => $productId])->exists();
    }

    public static function userHasProducts($userId) {
        return self::find()->where(['user_id' => $userId])->count() >= 1;
    }

    public static function hasPicture($productId) {
        return self::findOne($productId)->picture != '';
    }

    public static function getPicture($productId) {
        return self::findOne($productId)->picture;
    }

    public static function getPicturePath($productId) {
        return Yii::$app->request->hostInfo . '/costs/backend/web/' . self::findOne($productId)->picture;
    }

    public  function getProductSelectArray() {
        $_products = self::find()->where(['and',['availiable' => 1],['deleted' => 0]])->orderBy('product_name DESC')->all();

        $products = [];
        $products[0]='Select a product';

        foreach ($_products as $key => $t) {

            $text = $t->product_name . ', Type: ' . $t->type->type_name .
            ', Size: ' . $t->weight->size .
                ', Composition: ' . $t->outer_yarn_percent . '% ' . $t->outerYarn->yarn_name;

            if( $t->inner_yarn_id != 0 && $t->inner_yarn_percent != 0) {
                $text .=  ' & ' . $t->inner_yarn_percent . '% ' . $t->innerYarn->yarn_name;
            }
            $text.= ', Description: ' . $t->weight->description;
            $products[$t->id] = $text;
        }
        return $products;
    }

    public static function getTypeSelectArray() {
        $_types = ProductType::find()->all();
        $types = [];

        foreach ($_types as $key => $t)
            $types[$t->id] = $t->type_name;
        return $types;
    }

    public static function getYarnSelectArray() {
        $_yarns = ProductYarn::find()->where(['deleted' => 0])->all();
        $yarns = [];
        foreach ($_yarns as $key => $yarn)
            $yarns[$yarn->id] = $yarn->yarn_name;
        return $yarns;
    }

    public static function getWeightSelectArray() {
        $_weights = ProductWeight::find()->where(['deleted' => 0])->all();
        $weights = [];
        foreach ($_weights as $key => $weight)
            $weights[$weight->id] = 'Grams: ' . $weight->weight_gram .
                                    ', Size: ' . $weight->size .
                                    ', Type: ' . ProductType::getTypeName($weight->type_id) .
                                    ', Description: ' . $weight->description;
        return $weights;
    }
}