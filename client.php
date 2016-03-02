<?php

    // 引入客户端文件
    require_once 'yourdir/workerman/applications/ThriftRpc/Clients/ThriftClient.php';
    use ThriftClient\ThriftClient;

    // 传入配置，一般在某统一入口文件中调用一次该配置接口即可
    ThriftClient::config(array(
                         'HelloWorld' => array(
                           'addresses' => array(
                               '127.0.0.1:9090',
                               '127.0.0.2:9191',
                             ),
                             'thrift_protocol' => 'TBinaryProtocol',//不配置默认是TBinaryProtocol，对应服务端HelloWorld.conf配置中的thrift_protocol
                             'thrift_transport' => 'TBufferedTransport',//不配置默认是TBufferedTransport，对应服务端HelloWorld.conf配置中的thrift_transport
                           ),
                           'UserInfo' => array(
                             'addresses' => array(
                               '127.0.0.1:9393'
                             ),
                           ),
                         )
                       );
    // =========  以上在WEB入口文件中调用一次即可  ===========


    // =========  以下是开发过程中的调用示例  ==========

    // 初始化一个HelloWorld的实例
    $client = ThriftClient::instance('HelloWorld');

    // --------同步调用实例----------
    var_export($client->sayHello("TOM"));

    // --------异步调用示例-----------
    // 异步调用 之 发送请求给服务端（注意：异步发送请求格式统一为 asend_XXX($arg),既在原有方法名前面增加'asend_'前缀）
    $client->asend_sayHello("JERRY");
    $client->asend_sayHello("KID");

    // 这里是其它业务逻辑
    sleep(1);

    // 异步调用 之 接收服务端的回应（注意：异步接收请求格式统一为 arecv_XXX($arg),既在原有方法名前面增加'arecv_'前缀）
    var_export($client->arecv_sayHello("KID"));
    var_export($client->arecv_sayHello("JERRY"));
