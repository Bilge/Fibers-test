# Fibers test

PHP 8.1 packs a lot of [great features](https://www.php.net/releases/8.1/en.php), but among them, the most interesting are [fibers](https://www.php.net/manual/en/language.fibers.php). Fibers allow us to work asynchronously in PHP without the cumbersome boilerplate of the prior state-of-the-art using [coroutines](https://www.npopov.com/2012/12/22/Cooperative-multitasking-using-coroutines-in-PHP.html). Of course, we still need a task scheduler built on top of fibers, and for this we defer to the excellent [Amp](https://amphp.org/). Although Amp's support for fibers is still in beta and documentation is missing, its APIs are intuitive enough to follow. 

This project is the PHP analog of my [Go concurrency test](https://github.com/Bilge/Go-concurrency-test) which implements the same pattern: spawn a web server that responds with incrementing integers starting at 1 and query it _n_ (typically 10) times and observe the numbers are emitted in a pseudo-random order. In Go, this pseudo-random order occurs naturally because Go has "real" concurrency semantics. In PHP, its single-threaded design means our contrived example has deterministic output, that is, the output is a contiguous integer sequence. We simulate randomness by introducing an arbitrary delay before sending the response in the order of ⅒<sup>th</sup> → 1 second on each request.
