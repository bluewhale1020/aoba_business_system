<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WorksFixture
 */
class Works2Fixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'works'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            ['id'=>1,
            'order_id'=>1,
            'done'=>1
            ],
            ['id'=>2,
            'order_id'=>2,
            'done'=>1
            ],
            ['id'=>3,
            'order_id'=>3,
            'done'=>1
            ],
            ['id'=>4,
            'order_id'=>4,
            'done'=>1
            ],
            ['id'=>5,
            'order_id'=>5,
            'done'=>1
            ],
            ['id'=>6,
            'order_id'=>6,
            'done'=>1
            ],
            ['id'=>7,
            'order_id'=>7,
            'done'=>1
            ],
            ['id'=>8,
            'order_id'=>8,
            'done'=>1
            ],
            ['id'=>9,
            'order_id'=>9,
            'done'=>0
            ],
            ['id'=>10,
            'order_id'=>10,
            'done'=>0
            ],
            ['id'=>11,
            'order_id'=>11,
            'done'=>1
            ],
            ['id'=>12,
            'order_id'=>12,
            'done'=>1
            ],
            ['id'=>13,
            'order_id'=>13,
            'done'=>1
            ],
            ['id'=>14,
            'order_id'=>14,
            'done'=>0
            ],
            ['id'=>15,
            'order_id'=>15,
            'done'=>0
            ],
            ['id'=>16,
            'order_id'=>16,
            'done'=>0
            ],
        ];


        parent::init();
    }
}
