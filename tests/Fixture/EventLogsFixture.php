<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventLogsFixture
 */
class EventLogsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'event_logs'];

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
                'created' => '2019-12-10 14:40:51',
                'event' => 'ログイン',
                'action_type' => 'login',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 2,
                'created' => '2019-12-10 14:41:31',
                'event' => 'ログアウト',
                'action_type' => 'logout',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 3,
                'created' => '2019-12-10 14:41:43',
                'event' => 'ログイン',
                'action_type' => 'login',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 6,
                'created' => '2019-12-10 15:14:40',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Orders',
                'record_id' => 12,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:4:{s:10:"start_date";O:20:"Cake\\I18n\\FrozenDate":3:{s:4:"date";s:26:"2019-12-05 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:8:"end_date";O:20:"Cake\\I18n\\FrozenDate":3:{s:4:"date";s:26:"2019-12-08 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:10:"start_time";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 10:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}s:8:"end_time";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}}',
                'new_val' => 'a:6:{s:10:"start_date";s:10:"2019/12/05";s:8:"end_date";s:10:"2019/12/08";s:10:"start_time";s:5:"10:00";s:8:"end_time";s:5:"15:00";s:10:"date_range";s:23:"2019/12/05 - 2019/12/08";s:5:"total";s:6:"150000";}'
            ],
            [
                'id' => 7,
                'created' => '2019-12-10 15:19:39',
                'event' => 'データの新規登録',
                'action_type' => 'insert',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => 'a:6:{s:11:"formal_name";s:3:"yyy";s:8:"username";s:4:"yyyy";s:4:"role";s:4:"user";s:7:"created";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:19:38.895662";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}s:8:"modified";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:19:38.895760";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}s:2:"id";i:42;}'
            ],
            [
                'id' => 8,
                'created' => '2019-12-10 15:21:01',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:2:{s:11:"formal_name";s:3:"yyy";s:8:"modified";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:19:38.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}}',
                'new_val' => 'a:2:{s:11:"formal_name";s:4:"yyyy";s:8:"modified";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:21:01.646189";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}}'
            ],
            [
                'id' => 9,
                'created' => '2019-12-10 15:25:15',
                'event' => 'データの削除',
                'action_type' => 'delete',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:6:{s:2:"id";i:42;s:8:"username";s:4:"yyyy";s:4:"role";s:4:"user";s:11:"formal_name";s:4:"yyyy";s:7:"created";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:19:38.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}s:8:"modified";O:20:"Cake\\I18n\\FrozenTime":3:{s:4:"date";s:26:"2019-12-10 15:21:01.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:10:"Asia/Tokyo";}}',
                'new_val' => null
            ],
            [
                'id' => 10,
                'created' => '2019-12-11 09:55:46',
                'event' => 'ログイン',
                'action_type' => 'login',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 11,
                'created' => '2019-12-11 13:04:48',
                'event' => 'ログイン',
                'action_type' => 'login',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 12,
                'created' => '2019-12-11 15:03:57',
                'event' => 'データの新規登録',
                'action_type' => 'insert',
                'table_name' => 'Users',
                'record_id' => 43,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => 'a:6:{s:11:"formal_name";s:9:"test test";s:8:"username";s:13:"test@test.com";s:4:"role";s:4:"user";s:7:"created";s:19:"2019/12/11 15:03:57";s:8:"modified";s:19:"2019/12/11 15:03:57";s:2:"id";i:43;}'
            ],
            [
                'id' => 13,
                'created' => '2019-12-11 15:05:02',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Users',
                'record_id' => 43,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:2:{s:11:"formal_name";s:9:"test test";s:8:"modified";s:19:"2019/12/11 15:03:57";}',
                'new_val' => 'a:2:{s:11:"formal_name";s:10:"test test2";s:8:"modified";s:19:"2019/12/11 15:05:02";}'
            ],
            [
                'id' => 14,
                'created' => '2019-12-11 15:06:58',
                'event' => 'データの削除',
                'action_type' => 'delete',
                'table_name' => 'Users',
                'record_id' => 43,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:6:{s:2:"id";i:43;s:8:"username";s:13:"test@test.com";s:4:"role";s:4:"user";s:11:"formal_name";s:10:"test test2";s:7:"created";s:19:"2019/12/11 15:03:57";s:8:"modified";s:19:"2019/12/11 15:05:02";}',
                'new_val' => null
            ],
            [
                'id' => 15,
                'created' => '2019-12-11 15:09:38',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Works',
                'record_id' => 12,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:2:{s:11:"absent_nums";s:3:"1,5";s:9:"staff2_id";N;}',
                'new_val' => 'a:18:{s:16:"operation_number";i:1;s:11:"absent_nums";s:5:"1,5,8";s:9:"staff2_id";i:4;s:12:"A_date_range";s:23:"2019/12/05 - 2019/12/08";s:12:"A_start_date";s:10:"2019/12/05";s:10:"A_end_date";s:10:"2019/12/08";s:12:"B_date_range";s:0:"";s:12:"B_start_date";s:0:"";s:10:"B_end_date";s:0:"";s:12:"C_date_range";s:0:"";s:12:"C_start_date";s:0:"";s:10:"C_end_date";s:0:"";s:12:"D_date_range";s:0:"";s:12:"D_start_date";s:0:"";s:10:"D_end_date";s:0:"";s:12:"E_date_range";s:0:"";s:12:"E_start_date";s:0:"";s:10:"E_end_date";s:0:"";}'
            ],
            [
                'id' => 16,
                'created' => '2019-12-11 15:11:51',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Orders',
                'record_id' => 15,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:6:{s:9:"recipient";N;s:10:"start_date";s:19:"2019/12/20 00:00:00";s:8:"end_date";s:19:"2019/12/23 00:00:00";s:10:"start_time";s:19:"2019/12/11 10:00:00";s:8:"end_time";s:19:"2019/12/11 15:00:00";s:11:"patient_num";i:100;}',
                'new_val' => 'a:8:{s:9:"recipient";s:0:"";s:10:"start_date";s:10:"2019/12/20";s:8:"end_date";s:10:"2019/12/23";s:10:"start_time";s:5:"10:00";s:8:"end_time";s:5:"15:00";s:11:"patient_num";i:110;s:10:"date_range";s:23:"2019/12/20 - 2019/12/23";s:5:"total";s:6:"150000";}'
            ],
            [
                'id' => 17,
                'created' => '2019-12-11 15:17:29',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Bills',
                'record_id' => 6,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:3:{s:7:"bill_no";s:5:"A1240";s:8:"due_date";s:19:"2019/11/30 00:00:00";s:14:"bill_sent_date";s:19:"2019/11/19 00:00:00";}',
                'new_val' => 'a:5:{s:7:"bill_no";s:5:"A1241";s:8:"due_date";s:10:"2019/11/30";s:14:"bill_sent_date";s:10:"2019/11/19";s:4:"data";a:3:{s:4:"year";s:4:"2019";s:5:"month";s:2:"11";s:6:"Orders";a:1:{i:0;a:8:{s:8:"order_id";s:2:"18";s:8:"order_no";s:7:"order23";s:11:"description";s:44:"株式会社 田辺 撮影 胸部 DR Bレ車";s:15:"guaranty_charge";s:6:"150000";s:14:"guaranty_count";s:2:"50";s:16:"additional_count";s:1:"0";s:21:"additional_unit_price";s:1:"0";s:12:"other_charge";s:1:"0";}}}s:13:"tax_inclusion";s:1:"0";}'
            ],
            [
                'id' => 18,
                'created' => '2019-12-11 15:17:29',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Orders',
                'record_id' => 18,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:0:{}',
                'new_val' => 'a:3:{s:7:"bill_id";i:6;s:10:"is_charged";i:1;s:8:"order_id";s:2:"18";}'
            ],
            [
                'id' => 19,
                'created' => '2019-12-11 15:21:28',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Bills',
                'record_id' => 6,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:3:{s:7:"bill_no";s:5:"A1241";s:8:"due_date";s:19:"2019/11/30 00:00:00";s:14:"bill_sent_date";s:19:"2019/11/19 00:00:00";}',
                'new_val' => 'a:3:{s:7:"bill_no";s:5:"A1242";s:8:"due_date";s:10:"2019/11/30";s:14:"bill_sent_date";s:10:"2019/11/19";}'
            ],
            [
                'id' => 20,
                'created' => '2019-12-11 15:21:28',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Orders',
                'record_id' => 18,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:0:{}',
                'new_val' => 'a:0:{}'
            ],
            [
                'id' => 21,
                'created' => '2019-12-12 09:00:59',
                'event' => 'ログイン',
                'action_type' => 'login',
                'table_name' => null,
                'record_id' => null,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => null
            ],
            [
                'id' => 22,
                'created' => '2019-12-12 09:27:43',
                'event' => 'データの新規登録',
                'action_type' => 'insert',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => null,
                'new_val' => 'a:6:{s:11:"formal_name";s:25:"テスト　ユーザー3";s:8:"username";s:10:"test user3";s:4:"role";s:4:"user";s:7:"created";s:19:"2019/12/12 09:27:43";s:8:"modified";s:19:"2019/12/12 09:27:43";s:2:"id";i:42;}'
            ],
            [
                'id' => 23,
                'created' => '2019-12-12 09:27:58',
                'event' => 'データの更新',
                'action_type' => 'update',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:3:{s:8:"username";s:10:"test user3";s:11:"formal_name";s:25:"テスト　ユーザー3";s:8:"modified";s:19:"2019/12/12 09:27:43";}',
                'new_val' => 'a:3:{s:8:"username";s:10:"test user4";s:11:"formal_name";s:25:"テスト　ユーザー4";s:8:"modified";s:19:"2019/12/12 09:27:58";}'
            ],
            [
                'id' => 24,
                'created' => '2019-12-12 09:28:14',
                'event' => 'データの削除',
                'action_type' => 'delete',
                'table_name' => 'Users',
                'record_id' => 42,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:6:{s:2:"id";i:42;s:8:"username";s:10:"test user4";s:4:"role";s:4:"user";s:11:"formal_name";s:25:"テスト　ユーザー4";s:7:"created";s:19:"2019/12/12 09:27:43";s:8:"modified";s:19:"2019/12/12 09:27:58";}',
                'new_val' => null
            ],
            [
                'id' => 25,
                'created' => '2019-12-12 09:31:36',
                'event' => 'データの削除',
                'action_type' => 'delete',
                'table_name' => 'Users',
                'record_id' => 40,
                'user_id' => 4,
                'remote_addr' => '::1',
                'old_val' => 'a:6:{s:2:"id";i:40;s:8:"username";s:13:"kenichi.ekoda";s:4:"role";s:5:"admin";s:11:"formal_name";s:13:"吉田 裕太";s:7:"created";s:19:"2019/10/25 11:19:10";s:8:"modified";s:19:"2019/10/25 11:19:10";}',
                'new_val' => null
            ],
        ];
        parent::init();
    }
}
