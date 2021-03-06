<?php
/**
 * Created by PhpStorm.
 * User: ugurgucer
 * Date: 2018-12-20
 * Time: 23:05
 */

namespace App\Model;

use App\Core\Model;
use App\Helpers;
use App\Migration\Food as FoodMigration;

class Food extends Model
{
    protected $tableName = 'foods';

    public function __construct(){
        parent::__construct();

        (new FoodMigration())->create();
    }

    public function getFoodWithCaloryInterval($min, $max){
        try{
            $sorgu = "SELECT * FROM {$this->tableName} as f WHERE f.kalori BETWEEN {$min} AND {$max}";

            return $this->db->query($sorgu)->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function insertFood($option){
        $params = Helpers::optionToQuery($option);

        $is_exist = "SELECT count(*) as t FROM {$this->tableName} WHERE yiyecek = '{$option['yiyecek']}' AND kalori = {$option['kalori']}"
;        try{
            if($this->db->query($is_exist)->fetch()['t'])
                throw new \Exception('Girmek istediğiniz yemek veri tabanımızda vardır.');
            $sorgu = "INSERT INTO {$this->tableName} ({$params[0]}) VALUES({$params[1]})";
            $this->db->prepare($sorgu)->execute($option);
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function searchFood($pattern){
        try{
            $sorgu = "SELECT * FROM {$this->tableName} WHERE yiyecek LIKE :pattern";

            $sonuc = $this->db->prepare($sorgu);
            $sonuc->execute(['pattern' => '%'.$pattern.'%']);

            return $sonuc->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            throw $e;
        }
    }
}