# pipeline-remix
Reinvented pipelines for PHP

[![Latest Stable Version](https://poser.pugx.org/alexmanno/pipeline-remix/version)](https://packagist.org/packages/alexmanno/pipeline-remix) [![Total Downloads](https://poser.pugx.org/alexmanno/pipeline-remix/downloads)](https://packagist.org/packages/alexmanno/pipeline-remix) [![Latest Unstable Version](https://poser.pugx.org/alexmanno/pipeline-remix/v/unstable)](//packagist.org/packages/alexmanno/pipeline-remix) [![License](https://poser.pugx.org/alexmanno/pipeline-remix/license)](https://packagist.org/packages/alexmanno/pipeline-remix) [![composer.lock available](https://poser.pugx.org/alexmanno/pipeline-remix/composerlock)](https://packagist.org/packages/alexmanno/pipeline-remix)

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

You can initialize it in this way: `$pipeline = new Remix\Pipelines\Pipeline();`

You can add Stage to Pipeline using `$pipeline->pipe($stage)`

### Stage

A Stage is an object that implements `Remix\Pipelines\Interfaces\StageInterface` and has an `__invoke()` method.

This object is the smallest part of the pipeline and it should be a single operation.

You can create a class that implements that interface. 

Ex.
```php
 class MyCoolStage implements Remix\Pipelines\Interfaces\StageInterface 
 {
    /**
     * @param State $state
     */
    public function __invoke(State $state)
    {
        $state->append('Hello!');
        
        return $state;
    }
}
```

### State

State is an object that implements `StateInterface` and can store all kind of data.
For example in a web application it can store `Request` and `Response`.

Ex.
```php
class State implements Remix\Pipelines\Interfaces\StateInterface
{
    /** @var RequestInterface */
    public $request;
    /** @var ResponseInterface */
    public $response;
}
```

## Compose and run your pipeline

If you have already initialized State object and Stages objects you can compose your pipeline.

Ex.
```php
// -- Initialized objects: $state, $pipeline, $stage1, $stage2 --

$state = $pipeline
    ->pipe($stage1) // Add $stage1 to queue
    ->pipe($stage2) // Add $stage2 to queue
    ->run($state);  // Run pipeline: invoke $stage1 and then $stage2 with state from $stage1
```

You can also compose two or more pipelines togheter using method `add()`

Ex.

```php
// -- Initialized objects: $state, $pipeline1, $pipeline2, $stage1, $stage2 --

$pipeline1->pipe($stage1); // Add $stage1 to $pipeline1
$pipeline2->pipe($stage2); // Add $stage2 to $pipeline2

$pipeline1->add($pipeline2); // Add stages from $pipeline2

$state = $pipeline1->run($state); // Run pipeline: invoke $stage1 (from $pipeline1) and then $stage2 (from $pipeline2) with state from $stage1

```


## Conclusion

I hope you found useful this repo. Thanks for attention. 

Made with :heart: from @alexmanno


