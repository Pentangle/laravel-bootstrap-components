<?php

namespace Pentangle\BootstrapComponents;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Pentangle\BootstrapComponents\View\Components\Form\Button;
use Pentangle\BootstrapComponents\View\Components\Form\Checkbox;
use Pentangle\BootstrapComponents\View\Components\Form\Checkboxes;
use Pentangle\BootstrapComponents\View\Components\Form\Error;
use Pentangle\BootstrapComponents\View\Components\Form\Errors;
use Pentangle\BootstrapComponents\View\Components\Form\File;
use Pentangle\BootstrapComponents\View\Components\Form\Input;
use Pentangle\BootstrapComponents\View\Components\Form\InputGroup;
use Pentangle\BootstrapComponents\View\Components\Form\ModelSelect;
use Pentangle\BootstrapComponents\View\Components\Form\Select;
use Pentangle\BootstrapComponents\View\Components\Form\Textarea;
use Pentangle\BootstrapComponents\View\Components\Navigation\Item;
use Pentangle\BootstrapComponents\View\Components\Navigation\Label;

class BootstrapComponentsServiceProvider extends ServiceProvider
{
    /** @var string */
    private const CONFIG_FILE = __DIR__.'/../config/library.php';

    /** @var string */
    private const PATH_VIEWS = __DIR__.'/../resources/views';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
            $this->publishes([
                self::CONFIG_FILE => config_path('library.php'),
            ], 'config');
        }
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bootstrap-components');

        $this
            ->registerFormComponents()
            ->registerNavigationComponents()
            ->registerComponentsPublishers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_FILE, 'library');
    }

    /**
     * Register the Blade form components.
     *
     * @return $this
     */
    private function registerFormComponents(): self
    {
        $this->loadViewComponentsAs('form', [
            'input'        => Input::class,
            'input-group'  => InputGroup::class,
            'select'       => Select::class,
            'model-select' => ModelSelect::class,
            'textarea'     => Textarea::class,
            'checkboxes'   => Checkboxes::class,
            'checkbox'     => Checkbox::class,
            'file'         => File::class,
            'button'       => Button::class,
            'errors'       => Errors::class,
            'error'        => Error::class,
        ]);

        return $this;
    }

    /**
     * Register the Blade navigation components.
     *
     * @return $this
     */
    private function registerNavigationComponents(): self
    {
        $this->loadViewComponentsAs('navigation', [
            'item'  => Item::class,
            'label' => Label::class,
        ]);

        return $this;
    }

    /**
     * Register the publishers of the component resources.
     *
     * @return $this
     */
    public function registerComponentsPublishers(): self
    {
        $this->publishes([
            self::PATH_VIEWS => resource_path('views/vendor/bootstrap-components'),
        ], 'components');

        $this->publishes([
            self::PATH_VIEWS.'/form' => resource_path('views/vendor/bootstrap-components/form'),
        ], 'form-components');

        $this->publishes([
            self::PATH_VIEWS.'/navigation' => resource_path('views/vendor/bootstrap-components/navigation'),
        ], 'navigation-components');

        return $this;
    }

    /** @inheritDoc */
    protected function loadViewComponentsAs($prefix, array $components)
    {
        $this->callAfterResolving(BladeCompiler::class, function ($blade) use ($prefix, $components) {
            foreach ($components as $alias => $component) {
                $blade->component($component, is_numeric($alias) ? null : $alias, $prefix);
            }
        });
    }
}
