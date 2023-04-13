<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'NelmioApiDoc'.\DIRECTORY_SEPARATOR.'AreasConfig.php';
require_once __DIR__.\DIRECTORY_SEPARATOR.'NelmioApiDoc'.\DIRECTORY_SEPARATOR.'ModelsConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class NelmioApiDocConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $useValidationGroups;
    private $documentation;
    private $mediaTypes;
    private $areas;
    private $models;
    private $_usedProperties = [];

    /**
     * If true, `groups` passed to @Model annotations will be used to limit validation constraints
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function useValidationGroups($value): static
    {
        $this->_usedProperties['useValidationGroups'] = true;
        $this->useValidationGroups = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function documentation(string $key, mixed $value): static
    {
        $this->_usedProperties['documentation'] = true;
        $this->documentation[$key] = $value;

        return $this;
    }

    /**
     * @param ParamConfigurator|list<ParamConfigurator|mixed> $value
     *
     * @return $this
     */
    public function mediaTypes(ParamConfigurator|array $value): static
    {
        $this->_usedProperties['mediaTypes'] = true;
        $this->mediaTypes = $value;

        return $this;
    }

    /**
     * @template TValue
     * @param TValue $value
     * Filter the routes that are documented
     * @default {"default":{"path_patterns":[],"host_patterns":[],"with_annotation":false,"documentation":[],"name_patterns":[],"disable_default_routes":false}}
     * @return \Symfony\Config\NelmioApiDoc\AreasConfig|$this
     * @psalm-return (TValue is array ? \Symfony\Config\NelmioApiDoc\AreasConfig : static)
     */
    public function areas(string $name, array $value = []): \Symfony\Config\NelmioApiDoc\AreasConfig|static
    {
        if (!\is_array($value)) {
            $this->_usedProperties['areas'] = true;
            $this->areas[$name] = $value;

            return $this;
        }

        if (!isset($this->areas[$name]) || !$this->areas[$name] instanceof \Symfony\Config\NelmioApiDoc\AreasConfig) {
            $this->_usedProperties['areas'] = true;
            $this->areas[$name] = new \Symfony\Config\NelmioApiDoc\AreasConfig($value);
        } elseif (1 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "areas()" has already been initialized. You cannot pass values the second time you call areas().');
        }

        return $this->areas[$name];
    }

    /**
     * @default {"use_jms":false,"names":[]}
    */
    public function models(array $value = []): \Symfony\Config\NelmioApiDoc\ModelsConfig
    {
        if (null === $this->models) {
            $this->_usedProperties['models'] = true;
            $this->models = new \Symfony\Config\NelmioApiDoc\ModelsConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "models()" has already been initialized. You cannot pass values the second time you call models().');
        }

        return $this->models;
    }

    public function getExtensionAlias(): string
    {
        return 'nelmio_api_doc';
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('use_validation_groups', $value)) {
            $this->_usedProperties['useValidationGroups'] = true;
            $this->useValidationGroups = $value['use_validation_groups'];
            unset($value['use_validation_groups']);
        }

        if (array_key_exists('documentation', $value)) {
            $this->_usedProperties['documentation'] = true;
            $this->documentation = $value['documentation'];
            unset($value['documentation']);
        }

        if (array_key_exists('media_types', $value)) {
            $this->_usedProperties['mediaTypes'] = true;
            $this->mediaTypes = $value['media_types'];
            unset($value['media_types']);
        }

        if (array_key_exists('areas', $value)) {
            $this->_usedProperties['areas'] = true;
            $this->areas = array_map(function ($v) { return \is_array($v) ? new \Symfony\Config\NelmioApiDoc\AreasConfig($v) : $v; }, $value['areas']);
            unset($value['areas']);
        }

        if (array_key_exists('models', $value)) {
            $this->_usedProperties['models'] = true;
            $this->models = new \Symfony\Config\NelmioApiDoc\ModelsConfig($value['models']);
            unset($value['models']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['useValidationGroups'])) {
            $output['use_validation_groups'] = $this->useValidationGroups;
        }
        if (isset($this->_usedProperties['documentation'])) {
            $output['documentation'] = $this->documentation;
        }
        if (isset($this->_usedProperties['mediaTypes'])) {
            $output['media_types'] = $this->mediaTypes;
        }
        if (isset($this->_usedProperties['areas'])) {
            $output['areas'] = array_map(function ($v) { return $v instanceof \Symfony\Config\NelmioApiDoc\AreasConfig ? $v->toArray() : $v; }, $this->areas);
        }
        if (isset($this->_usedProperties['models'])) {
            $output['models'] = $this->models->toArray();
        }

        return $output;
    }

}
