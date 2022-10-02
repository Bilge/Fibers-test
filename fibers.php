<?php
declare(strict_types=1);

use Amp\Future;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Amp\Http\Server\DefaultErrorHandler;
use Amp\Http\Server\RequestHandler\ClosureRequestHandler;
use Amp\Http\Server\Response;
use Amp\Http\Server\SocketHttpServer;
use Amp\Socket\InternetAddress;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use function Amp\async;
use function Amp\delay;

require_once __DIR__ . '/vendor/autoload.php';

$logger = new Logger('server', [new StreamHandler(STDOUT, Level::Info)]);
$server = new SocketHttpServer($logger);
$server->expose(new InternetAddress($address = '127.0.0.1', 80));
$server->start(new ClosureRequestHandler(static function (): Response {
    static $id = 0;
    $localId = ++$id;

    delay(1 / random_int(1, 10));

    return new Response(body: (string)$localId);
}), new DefaultErrorHandler());

$client = HttpClientBuilder::buildDefault();
$request = new Request("http://$address");
for ($i = 0; $i < 10; ++$i) {
    $responses[] = async(fn () => $client->request($request)->getBody()->buffer());
}

foreach (Future::iterate($responses) as $response) {
    echo $response->await(), PHP_EOL;
}

$server->stop();
