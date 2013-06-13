<?php

return array(
    'user' => array(
        'count' => 2,
        'fields' => array(
            'id' => 'ai',
            'name' => array(
                'type' => 'source',
                'source' => array('Mary', 'Chuck', 'Bob', 'Den'),
            ),
            'age' => 'rand:20,30',
            'group' => 'source::groups',
            'post' => array(
                'type' => 'relation',
                'count' => '1,2',
                'offset' => 3,
                'fields' => array(
                    'id' => 'ai',
                    'user_id' => 'foreign',
                    'title' => array(
                        'type'  => 'expr',
                        'value' => function($number)
                        {
                            return "Post # $number";
                        },
                    ),
                    'text' => 'scalar:message text',
                    'tag' => array(
                        'type' => 'expr',
                        'value' => '$value',
                        'source' => 'tags',
                    ),
                    'comment' => array(
                        'type' => 'relation',
                        'count' => 2,
                        'fields' => array(
                            'id' => 'ai',
                            'post_id' => 'foreign',
                            'author_id' => 'rand:1,5',
                            'text' => 'scalar:comment text',
                            'date' => array(
                                'type' => 'scalar',
                                'value' => 'NOW()',
                                'escape' => false
                            ),
                            'rating' => array(
                                'type' => 'rand',
                                'source' => array(-2,-1,0,1,2,3,4),
                            ),
                        )
                    )
                )
            )
        )
    )
);