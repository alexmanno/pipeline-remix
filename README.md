# pipeline-remix
Reinvented pipelines for PHP

[![Latest Stable Version](https://poser.pugx.org/alexmanno/pipeline-remix/version)](https://packagist.org/packages/alexmanno/pipeline-remix) 
[![Latest Unstable Version](https://poser.pugx.org/alexmanno/pipeline-remix/v/unstable)](//packagist.org/packages/alexmanno/pipeline-remix) 
[![GitHub license](https://img.shields.io/github/license/alexmanno/pipeline-remix.svg)](https://github.com/alexmanno/pipeline-remix/blob/master/LICENSE.md) 
[![composer.lock available](https://poser.pugx.org/alexmanno/pipeline-remix/composerlock)](https://packagist.org/packages/alexmanno/pipeline-remix) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alexmanno/pipeline-remix/build-status/master)


## What's a Pipeline
A pipeline is a set of data processing elements connected in series, where the output of one element is the input of the next one.

## Installation
### From Composer
To use this package, use Composer:

 * from CLI: `composer require alexmanno/pipeline-remix`
 * or, directly in your `composer.json`:

```json
{
    "require": {
        "alexmanno/pipeline-remix": "dev-master"
    }
}
```

## Architecture

### Pipeline

A Pipeline is a simple SplQueue of Stage. 

You can initialize it in this way: `$pipeline = new AlexManno\Remix\Pipelines\Pipeline();`

You can add Stage to Pipeline using `$pipeline->pipe($stage)`

### Stage

A Stage is an object that implements `AlexManno\Remix\Pipelines\Interfaces\StageInterface` and has an `__invoke()` method.

This object is the smallest part of the pipeline and it should be a single operation.

You can create a class that implements that interface. 

Ex.
```php
 class MyCoolStage implements AlexManno\Remix\Pipelines\Interfaces\StageInterface
 {
    /**
     * @param Payload $payload
     */
    public function __invoke(Payload $payload)
    {
        $payload->setData('Hello!');
        
        return $payload;
    }
}
```

### Payload

Payload is an object that implements `PayloadInterface` and can store any kind of data.
For example in a web application it can store `Request` and `Response`.

Ex.
```php
class Payload implements AlexManno\Remix\Pipelines\Interfaces\PayloadInterface
{
    /** @var RequestInterface */
    public $request;
    /** @var ResponseInterface */
    public $response;
}
```

## Compose and run your pipeline

If you have already initialized Payload object and Stages objects you can compose your pipeline.

Ex.
```php
// -- Initialized objects: $payload, $pipeline, $stage1, $stage2 --

$pipeline
    ->pipe($stage1) // Add $stage1 to queue
    ->pipe($stage2); // Add $stage2 to queue

$pipeline($payload);  // Run pipeline: invoke $stage1 and then $stage2 with payload from $stage1
```

You can also compose two or more pipelines together using method `add()`

Ex.

```php
// -- Initialized objects: $payload, $pipeline1, $pipeline2, $stage1, $stage2 --

$pipeline1->pipe($stage1); // Add $stage1 to $pipeline1
$pipeline2->pipe($stage2); // Add $stage2 to $pipeline2

$pipeline1->add($pipeline2); // Add stages from $pipeline2

$payload = $pipeline1($payload); // Run pipeline: invoke $stage1 (from $pipeline1) and then $stage2 (from $pipeline2) with payload from $stage1

```

## Examples

 * Using Classes [Example-00](examples/example-00.php)


## Conclusion

I hope you found useful this repo. Thanks for attention. 

Made with :heart: by [@alexmanno](https://aka.am)


