<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TodoListsFixture
 */
class TodoListsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'todo_lists'];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 2,
                'description' => 'test2あいうえo',
                'due_date' => '2019-10-08 00:00:00',
                'priority' => 10,
                'done' => false,
                'created' => '2019-10-29 14:06:29',
                'modified' => '2019-10-29 15:45:16'
            ],
            [
                'id' => 5,
                'description' => 'test3',
                'due_date' => '2019-11-08 00:00:00',
                'priority' => 8,
                'done' => false,
                'created' => '2019-10-29 15:06:12',
                'modified' => '2019-10-29 15:45:14'
            ],
            [
                'id' => 8,
                'description' => 'Nemo sunt voluptatibus voluptates sed dicta nisi cum.',
                'due_date' => '2019-12-10 00:00:00',
                'priority' => 10,
                'done' => true,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:57:08'
            ],
            [
                'id' => 9,
                'description' => 'Iure ullam consectetur nesciunt dignissimos.',
                'due_date' => '2020-01-04 00:00:00',
                'priority' => 8,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 10,
                'description' => 'Tenetur magni quod eaque illo dolores excepturi nostrum voluptatum.',
                'due_date' => '2019-12-25 00:00:00',
                'priority' => 8,
                'done' => true,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-30 08:33:17'
            ],
            [
                'id' => 11,
                'description' => 'Incidunt architecto esse quam est.',
                'due_date' => '2019-11-28 00:00:00',
                'priority' => 5,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 12,
                'description' => 'Quaerat perspiciatis sit recusandae sed et.',
                'due_date' => '2019-10-30 00:00:00',
                'priority' => 5,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 16,
                'description' => 'Mollitia et impedit fuga est.',
                'due_date' => '2019-12-21 00:00:00',
                'priority' => 10,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 17,
                'description' => 'Placeat ut odio similique qui deleniti.',
                'due_date' => '2019-12-08 00:00:00',
                'priority' => 5,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:57:22'
            ],
            [
                'id' => 18,
                'description' => 'Error consequuntur ullam eaque unde deleniti.',
                'due_date' => '2019-11-13 00:00:00',
                'priority' => 2,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-11-05 09:04:28'
            ],
            [
                'id' => 19,
                'description' => 'Enim pariatur cupiditate quaerat velit nihil.',
                'due_date' => '2019-11-16 00:00:00',
                'priority' => 5,
                'done' => true,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 20,
                'description' => 'Est ipsum libero quia quis.',
                'due_date' => '2019-12-07 00:00:00',
                'priority' => 10,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
            [
                'id' => 21,
                'description' => 'Id libero sit consequatur est cum.',
                'due_date' => '2019-12-01 00:00:00',
                'priority' => 8,
                'done' => false,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-11-05 09:04:36'
            ],
            [
                'id' => 22,
                'description' => 'Dolor fugiat quasi quo ad adipisci.',
                'due_date' => '2020-01-25 00:00:00',
                'priority' => 10,
                'done' => true,
                'created' => '2019-10-29 15:55:53',
                'modified' => '2019-10-29 15:55:53'
            ],
        ];
        parent::init();
    }
}
