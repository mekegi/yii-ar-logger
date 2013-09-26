yii-ar-logger
=============

Yii ActiveRecord logger


Installation
------------
add to composer.json

    "require": {
        ...
        "mekegi/yii-ar-logger": "@dev",
        ...
    },
    "repositories": [
        ...
        {
            "type": "git",
            "url": "http://github.com/mekegi/yii-ar-logger"
        }
        ...
    ],

Config
------
add to config.php

    'aliases' => [
        // ...
        'vendor' => 'application.vendor', // path to composer vendor dir
        'mekegi.ArLogger' => 'vendor.mekegi.yii-ar-logger',
        // ...
    ],

Usage
-----
    public function behaviors()
    {
        return [
            ....
            // if you logged to db - before create 2 model LogChanges and LogSession
            // see in folder db example for this 2 models, and migrations for creating this models
            'arLoggerDb' => [
                'class' => 'mekegi\ArLogger\DbBehavior',
                'backtrace' => true, // if true add to add_info debug_backtrace for changes . [default false]
                'backTraceSkip' => 8, // how many lines skipped from backrace [default 8]
                'backTraceLines' => 2, // how many lines added to backtrace [default 2]
                'dontLogFields' => ['last_updated', 'security', ], // all this fields dont logged
            ],
            // if you logged to file
            'arLoggerFile' => [
                'class' => 'mekegi\ArLogger\FileBehavior',
                'dontLogFields' => ['last_updated', 'security', ],
                'filePath' => '/tmp/filelogger.log', // path to file
            ],
            .....

       ];
    }