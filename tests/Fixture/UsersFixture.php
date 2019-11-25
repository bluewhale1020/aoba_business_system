<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'users'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 4,
                'username' => 'admin',
                'password' => '$2y$10$2VWiPnJaoXqwsBEe3pusSeQQAKmcbyBUYdD56Blf03ScjNib7A6BK',
                'role' => 'admin',
                'formal_name' => 'admin',
                'created' => '2019-10-24 09:35:10',
                'modified' => '2019-10-24 11:15:49'
            ],
            [
                'id' => 7,
                'username' => 'yyy',
                'password' => '$2y$10$ZzxL8XGzU0UoYLV6nDWR1uBA8MvhFfF30rnBVYGQTU0UdxFL3eKV2',
                'role' => 'user',
                'formal_name' => 'yyy nameawefa',
                'created' => '2019-10-24 09:56:01',
                'modified' => '2019-10-24 14:27:47'
            ],
            [
                'id' => 9,
                'username' => 'test',
                'password' => '$2y$10$jCt/rK/XzQRbpuGqWP0yreRAW5ikTv/IEE.CIn.4MjVpGsX.Qf17q',
                'role' => 'admin',
                'formal_name' => 'test name',
                'created' => '2019-10-24 14:34:53',
                'modified' => '2019-10-24 14:34:53'
            ],
            [
                'id' => 26,
                'username' => 'nakajima.kaori',
                'password' => '$2y$10$QCsn0qGJSxAnHJXAyiDzlu33DndTeOv0VmB2zEmC72RcBOwIBP.kS',
                'role' => 'user',
                'formal_name' => '山本 裕樹',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 27,
                'username' => 'kiriyama.akemi',
                'password' => '$2y$10$uitlWimRp0ldRg3oaiR0F./RO7nRa2R14lUN6LdE86WdsWIqcyJ2m',
                'role' => 'user',
                'formal_name' => '西之園 翼',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 28,
                'username' => 'naoki.tanaka',
                'password' => '$2y$10$EDuQ8AKWBMDaje/X1HmP2e/ffgtmAjeTem0QGyEbxzXpUfqwNE05S',
                'role' => 'admin',
                'formal_name' => '笹田 稔',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 29,
                'username' => 'chiyo09',
                'password' => '$2y$10$hblowWyscvegH3qdvOjLC.z53nQpjkyCRLJQEiIGwZ.xzB0ZiuQse',
                'role' => 'admin',
                'formal_name' => '原田 あすか',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 30,
                'username' => 'sato.ryosuke',
                'password' => '$2y$10$c4xaLpAowYaYQixImoPh4O2Fq1IZqQvPA6Asebx07v1dJArVru9PW',
                'role' => 'admin',
                'formal_name' => '加納 桃子',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 31,
                'username' => 'nakatsugawa.momoko',
                'password' => '$2y$10$IJ8.zNQZjI3GIt1y/vXJauGPryUi04ZoCj4zA5LDk/hrmX94yM5QW',
                'role' => 'admin',
                'formal_name' => '加納 直樹',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 32,
                'username' => 'rika32',
                'password' => '$2y$10$RKjM5f/ALbkrHPPoxcq7e.jNUedQpn7lGi2UaVPFLgqjeqKyXEA8S',
                'role' => 'admin',
                'formal_name' => '井上 康弘',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 33,
                'username' => 'koizumi.manabu',
                'password' => '$2y$10$4rgjZ8vEAWfNdszT4KEXJ.Ui1ORcHmq.kjj41TnA6uDxgmtUqbvVG',
                'role' => 'user',
                'formal_name' => '中村 拓真',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 34,
                'username' => 'mai29',
                'password' => '$2y$10$rqdqvVUeeAhrTmBR9WykAuL8QJ8TzCwZr5JpcJ0oQOZUSGeDElrUC',
                'role' => 'admin',
                'formal_name' => '井高 さゆり',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 35,
                'username' => 'wsaito',
                'password' => '$2y$10$aCsq42WrLaeEwvzpueNtkOBRw9NPSrXGfcpE/7u4Da0Y4NPt6M0n.',
                'role' => 'user',
                'formal_name' => '加納 直樹',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 36,
                'username' => 'ykondo',
                'password' => '$2y$10$j7rLXFR8.VHKCbaVp8WTVuh40LSPYz0mcxmFHHc3zV.YP4XUEqVVe',
                'role' => 'user',
                'formal_name' => '加藤 裕太',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 37,
                'username' => 'satomi.hirokawa',
                'password' => '$2y$10$sUOtAFCaQy5KBQMZBKpMceuLvInq8yQG2Zm2QKfVTLKI6fFDwRghq',
                'role' => 'admin',
                'formal_name' => '松本 里佳',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 38,
                'username' => 'shota.kobayashi',
                'password' => '$2y$10$Otp.85euZkvLqpTgRy6Zjuf0S.zY2F1P8ZSLySgKkl.Pqx9Bl9Vre',
                'role' => 'admin',
                'formal_name' => '加納 美加子',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 39,
                'username' => 'unagisa',
                'password' => '$2y$10$bqek6iTJ1JchMeaH1rIP9u/T2RJZW/yUKYTt3xkRGUrnM.cub9hyy',
                'role' => 'user',
                'formal_name' => '若松 里佳',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
            [
                'id' => 40,
                'username' => 'kenichi.ekoda',
                'password' => '$2y$10$VTMZs7sfA2vdCQZdEKsfhetZsx/0fiYSiLqF2iWAJep8lXN9cSojK',
                'role' => 'admin',
                'formal_name' => '吉田 裕太',
                'created' => '2019-10-25 11:19:10',
                'modified' => '2019-10-25 11:19:10'
            ],
        ];
        parent::init();
    }
}
