<?php

namespace frontend\modules\epid\models;

use Yii;

/**
 * This is the model class for table "t_surveil".
 *
 * @property string $hospcode
 * @property string $pid
 * @property string $cid
 * @property string $seq
 * @property string $fname
 * @property string $lname
 * @property string $sex
 * @property string $areacode
 * @property string $birth
 * @property integer $age_y
 * @property integer $age_m
 * @property integer $age_d
 * @property string $date_serv
 * @property string $an
 * @property string $datetime_admit
 * @property string $diagcode
 * @property string $diagcodelast
 * @property string $code506
 * @property string $code506last
 * @property string $illdate
 * @property string $illhouse
 * @property string $ill_areacode
 * @property string $ptstatus
 * @property string $date_death
 * @property string $groupname1560
 * @property string $groupname190
 * @property string $groupname506
 * @property string $LAT
 * @property string $LON
 */
class Tsurveil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_surveil_ems';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_hdc');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hospcode', 'pid', 'cid', 'seq', 'fname', 'lname', 'sex', 'areacode', 'birth', 'age_y', 'age_m', 'age_d', 'date_serv', 'diagcode', 'code506', 'illdate', 'ptstatus'], 'required'],
            [['birth', 'date_serv', 'datetime_admit', 'illdate', 'date_death','LAT','LON'], 'safe'],
            [['age_y', 'age_m', 'age_d'], 'integer'],
            [['hospcode'], 'string', 'max' => 5],
            [['pid'], 'string', 'max' => 15],
            [['cid'], 'string', 'max' => 13],
            [['seq'], 'string', 'max' => 16],
            [['fname', 'lname'], 'string', 'max' => 100],
            [['sex', 'ptstatus'], 'string', 'max' => 1],
            [['areacode', 'ill_areacode'], 'string', 'max' => 8],
            [['an'], 'string', 'max' => 9],
            [['diagcode', 'diagcodelast'], 'string', 'max' => 6],
            [['code506', 'code506last'], 'string', 'max' => 2],
            [['illhouse'], 'string', 'max' => 75],
            [['groupname1560', 'groupname190'], 'string', 'max' => 50],
            [['groupname506'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'pid' => 'Pid',
            'cid' => 'Cid',
            'seq' => 'Seq',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'sex' => 'Sex',
            'areacode' => 'Areacode',
            'birth' => 'Birth',
            'age_y' => 'Age Y',
            'age_m' => 'Age M',
            'age_d' => 'Age D',
            'date_serv' => 'Date Serv',
            'an' => 'An',
            'datetime_admit' => 'Datetime Admit',
            'diagcode' => 'Diagcode',
            'diagcodelast' => 'Diagcodelast',
            'code506' => 'Code506',
            'code506last' => 'Code506last',
            'illdate' => 'Illdate',
            'illhouse' => 'Illhouse',
            'ill_areacode' => 'Ill Areacode',
            'ptstatus' => 'Ptstatus',
            'date_death' => 'Date Death',
            'groupname1560' => 'Groupname1560',
            'groupname190' => 'Groupname190',
            'groupname506' => 'Groupname506',
            'LAT'=>'LAT',
            'LON'=>'LON'
        ];
    }
}
