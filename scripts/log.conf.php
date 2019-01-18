<?php
return new oat\oatbox\log\LoggerService(array(
    'logger' => new \oat\oatbox\log\LoggerAggregator(
        array(

            new oat\oatbox\log\logger\TaoLog(array(
                'appenders' => array(
                    array(
                        'class' => 'UDPAppender',
                        'host' => '127.0.0.1',
                        'port' => 5775,
                        'threshold' => 1,
                        'prefix' => 'taoce'
                    )
                )
            )),

            new \oat\oatbox\log\logger\TaoMonolog(array(
                'name' => 'tao',
                'handlers' => array(

                    // Send log to a stream, could be a file or a daemon
                    array(
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'options' => array(
                            '/var/log/tao/taoce.log',
                            \Monolog\Logger::DEBUG
                        ),
                    ),

                )
            ))

        )
    )
));
