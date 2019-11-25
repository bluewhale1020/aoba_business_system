<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ImportDataConversionsFixture
 */
class ImportDataConversionsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'import_data_conversions'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'category' => 'staffs',
                'name' => '氏名',
                'item_name' => 'name',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 2,
                'category' => 'staffs',
                'name' => 'フリガナ',
                'item_name' => 'kana',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 3,
                'category' => 'staffs',
                'name' => '生年月日',
                'item_name' => 'birth_date',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 4,
                'category' => 'staffs',
                'name' => '性別',
                'item_name' => 'sex',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => '_conv_sex'
            ],
            [
                'id' => 5,
                'category' => 'staffs',
                'name' => '電話番号',
                'item_name' => 'tel',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 6,
                'category' => 'staffs',
                'name' => '郵便番号',
                'item_name' => 'postal_code',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 7,
                'category' => 'staffs',
                'name' => '住所',
                'item_name' => 'address',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 8,
                'category' => 'staffs',
                'name' => '番地',
                'item_name' => 'banchi',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 9,
                'category' => 'staffs',
                'name' => '建物名',
                'item_name' => 'tatemono',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 10,
                'category' => 'staffs',
                'name' => '職種１',
                'item_name' => 'occupation_id',
                'tb_name' => 'staffs',
                'is_id_number' => 1,
                'id_tb_name' => 'Occupations',
                'conv' => null
            ],
            [
                'id' => 11,
                'category' => 'staffs',
                'name' => '職種２',
                'item_name' => 'occupation2_id',
                'tb_name' => 'staffs',
                'is_id_number' => 1,
                'id_tb_name' => 'Occupations',
                'conv' => null
            ],
            [
                'id' => 12,
                'category' => 'staffs',
                'name' => '肩書',
                'item_name' => 'title_id',
                'tb_name' => 'staffs',
                'is_id_number' => 1,
                'id_tb_name' => 'Titles',
                'conv' => null
            ],
            [
                'id' => 13,
                'category' => 'staffs',
                'name' => '備考',
                'item_name' => 'notes',
                'tb_name' => 'staffs',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 14,
                'category' => 'business_partners',
                'name' => '取引先名称',
                'item_name' => 'name',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 15,
                'category' => 'business_partners',
                'name' => 'フリガナ',
                'item_name' => 'kana',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 16,
                'category' => 'business_partners',
                'name' => '郵便番号',
                'item_name' => 'postal_code',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 17,
                'category' => 'business_partners',
                'name' => '住所',
                'item_name' => 'address',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 18,
                'category' => 'business_partners',
                'name' => '番地',
                'item_name' => 'banchi',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 19,
                'category' => 'business_partners',
                'name' => '建物名',
                'item_name' => 'tatemono',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 20,
                'category' => 'business_partners',
                'name' => '電話番号',
                'item_name' => 'tel',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 21,
                'category' => 'business_partners',
                'name' => 'FAX',
                'item_name' => 'fax',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 22,
                'category' => 'business_partners',
                'name' => '部署名',
                'item_name' => 'department',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 23,
                'category' => 'business_partners',
                'name' => '担当者名',
                'item_name' => 'staff',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 24,
                'category' => 'business_partners',
                'name' => '担当者連絡先',
                'item_name' => 'staff_tel',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 25,
                'category' => 'business_partners',
                'name' => '請負元',
                'item_name' => 'is_client',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 26,
                'category' => 'business_partners',
                'name' => '派遣先',
                'item_name' => 'is_work_place',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 27,
                'category' => 'business_partners',
                'name' => '請負元名称',
                'item_name' => 'parent_id',
                'tb_name' => 'business_partners',
                'is_id_number' => 1,
                'id_tb_name' => 'BusinessPartners',
                'conv' => null
            ],
            [
                'id' => 28,
                'category' => 'business_partners',
                'name' => '仕入先',
                'item_name' => 'is_supplier',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 29,
                'category' => 'business_partners',
                'name' => '備考',
                'item_name' => 'notes',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 30,
                'category' => 'business_partners',
                'name' => '定休日',
                'item_name' => 'holiday_numbers',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 31,
                'category' => 'business_partners',
                'name' => '特定休日',
                'item_name' => 'specific_holidays',
                'tb_name' => 'business_partners',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 32,
                'category' => 'orders',
                'name' => '受注No',
                'item_name' => 'order_no',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 33,
                'category' => 'orders',
                'name' => 'ステータス',
                'item_name' => 'temporary_registration',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => '_conv_status'
            ],
            [
                'id' => 34,
                'category' => 'orders',
                'name' => 'description',
                'item_name' => 'description',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 35,
                'category' => 'orders',
                'name' => '請負元',
                'item_name' => 'client_id',
                'tb_name' => 'orders',
                'is_id_number' => 1,
                'id_tb_name' => 'BusinessPartners',
                'conv' => null
            ],
            [
                'id' => 36,
                'category' => 'orders',
                'name' => '派遣先',
                'item_name' => 'work_place_id',
                'tb_name' => 'orders',
                'is_id_number' => 1,
                'id_tb_name' => 'BusinessPartners',
                'conv' => null
            ],
            [
                'id' => 37,
                'category' => 'orders',
                'name' => '開始日',
                'item_name' => 'start_date',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 38,
                'category' => 'orders',
                'name' => '終了日',
                'item_name' => 'end_date',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 39,
                'category' => 'orders',
                'name' => '開始時間',
                'item_name' => 'start_time',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 40,
                'category' => 'orders',
                'name' => '終了時間',
                'item_name' => 'end_time',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 41,
                'category' => 'orders',
                'name' => '業務内容',
                'item_name' => 'work_content_id',
                'tb_name' => 'orders',
                'is_id_number' => 1,
                'id_tb_name' => 'WorkContents',
                'conv' => null
            ],
            [
                'id' => 42,
                'category' => 'orders',
                'name' => '撮影部位',
                'item_name' => 'capturing_region_id',
                'tb_name' => 'orders',
                'is_id_number' => 1,
                'id_tb_name' => 'CapturingRegions',
                'conv' => null
            ],
            [
                'id' => 43,
                'category' => 'orders',
                'name' => '読影',
                'item_name' => 'need_image_reading',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 44,
                'category' => 'orders',
                'name' => 'フィルムサイズ',
                'item_name' => 'film_size_id',
                'tb_name' => 'orders',
                'is_id_number' => 1,
                'id_tb_name' => 'FilmSizes',
                'conv' => null
            ],
            [
                'id' => 45,
                'category' => 'orders',
                'name' => '受診者数',
                'item_name' => 'patient_num',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 46,
                'category' => 'orders',
                'name' => '保証料金',
                'item_name' => 'guaranty_charge',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 47,
                'category' => 'orders',
                'name' => '保証人数',
                'item_name' => 'guaranty_count',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 48,
                'category' => 'orders',
                'name' => '追加人数',
                'item_name' => 'additional_count',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 49,
                'category' => 'orders',
                'name' => '追加料金単価',
                'item_name' => 'additional_unit_price',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
            [
                'id' => 50,
                'category' => 'orders',
                'name' => '備考',
                'item_name' => 'notes',
                'tb_name' => 'orders',
                'is_id_number' => 0,
                'id_tb_name' => '',
                'conv' => null
            ],
        ];
        parent::init();
    }
}
